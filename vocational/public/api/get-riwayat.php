<?php
// vocational/public/api/get-riwayat.php

require_once __DIR__ . '/../../app/Config/Session.php';
require_once __DIR__ . '/../../app/Config/Database.php';
require_once __DIR__ . '/../../app/Models/Aspirasi.php';

// Set JSON header
header('Content-Type: application/json');

// SUPPRESS ERROR DISPLAY
ini_set('display_errors', '0');
error_reporting(E_ALL);

// Check auth
Session::start();

if (!Session::has('user_npm')) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

try {
    $userNpm = Session::get('user_npm');
    $aspirasi = new Aspirasi();
    
    // DEBUG: Log session npm
    $debugLog = date('Y-m-d H:i:s') . " | SESSION_NPM: " . ($userNpm ? "'{$userNpm}'" : "NULL") . "\n";
    file_put_contents(__DIR__ . '/../../logs/riwayat-debug.log', $debugLog, FILE_APPEND);
    
    // Get filter parameters
    $kategori = $_GET['kategori'] ?? null;
    $status = $_GET['status'] ?? null;
    $limit = (int)($_GET['limit'] ?? 50);
    $offset = (int)($_GET['offset'] ?? 0);
    
    // Validate limit & offset
    $limit = min($limit, 100); // Max 100 per request
    $limit = max($limit, 1);
    $offset = max($offset, 0);
    
    // Build filters array
    $filters = [];
    if ($kategori && $kategori !== 'all') {
        $filters['kategori'] = $kategori;
    }
    if ($status && $status !== 'all') {
        $filters['status'] = $status;
    }
    
    // DEBUG: Log query params
    $debugLog = date('Y-m-d H:i:s') . " | FILTERS: " . json_encode($filters) . " | LIMIT: {$limit} | OFFSET: {$offset}\n";
    file_put_contents(__DIR__ . '/../../logs/riwayat-debug.log', $debugLog, FILE_APPEND);
    
    // Get aspirasi data
    $data = $aspirasi->getByNpmWithFilters($userNpm, $filters, $limit, $offset);
    $total = $aspirasi->countByNpm($userNpm);
    
    // DEBUG: Log results
    $debugLog = date('Y-m-d H:i:s') . " | RESULT_COUNT: " . count($data) . " | TOTAL: {$total}\n";
    if (count($data) > 0) {
        $debugLog .= date('Y-m-d H:i:s') . " | FIRST_ITEM: " . json_encode($data[0]) . "\n";
    }
    file_put_contents(__DIR__ . '/../../logs/riwayat-debug.log', $debugLog, FILE_APPEND);
    
    // Ambil total reaksi untuk masing-masing aspirasi
    $pdo = Database::getConnection();
    $ids = array_column($data, 'id_aspirasi');
    $reactionCounts = [];
    if (!empty($ids)) {
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $reactStmt = $pdo->prepare(
            "SELECT id_aspirasi, COUNT(*) as total FROM aspirasi_reactions WHERE id_aspirasi IN ($placeholders) GROUP BY id_aspirasi"
        );
        $reactStmt->execute($ids);
        while ($row = $reactStmt->fetch(PDO::FETCH_ASSOC)) {
            $reactionCounts[$row['id_aspirasi']] = (int)$row['total'];
        }
    }

    // Ambil tanggapan admin untuk masing-masing aspirasi
    $tanggapanMap = [];
    if (!empty($ids)) {
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $tanggapanStmt = $pdo->prepare(
            "SELECT t.id_tanggapan, t.id_aspirasi, t.isi_tanggapan,
                    a.role_adm
             FROM tanggapan t
             LEFT JOIN admin_web a ON t.admin_id = a.admin_id
             WHERE t.id_aspirasi IN ($placeholders)
             ORDER BY t.id_tanggapan ASC"
        );
        $tanggapanStmt->execute($ids);
        while ($row = $tanggapanStmt->fetch(PDO::FETCH_ASSOC)) {
            $tanggapanMap[$row['id_aspirasi']][] = [
                'id_tanggapan' => $row['id_tanggapan'],
                'isi_tanggapan' => $row['isi_tanggapan'],
                'role_adm' => $row['role_adm'] ?? 'Admin',
                'created_at' => ''  // tabel tanggapan belum punya kolom created_at
            ];
        }
    }

    // Format response
    $formattedData = array_map(function($item) use ($reactionCounts, $tanggapanMap) {
        return [
            'id_aspirasi' => $item['id_aspirasi'],
            'judul' => $item['judul'],
            'deskripsi' => $item['deskripsi'],
            'kategori' => $item['kategori'],
            'status' => $item['status'],
            'anonim' => (bool)$item['anonim'],
            'show_on_board' => (bool)$item['show_on_board'],
            'board_approved' => (bool)$item['board_approved'],
            'total_reactions' => $reactionCounts[$item['id_aspirasi']] ?? 0,
            'tanggapan' => $tanggapanMap[$item['id_aspirasi']] ?? [],
            'created_at' => date('d M Y, H:i', strtotime($item['created_at'])),
            'created_timestamp' => $item['created_at']
        ];
    }, $data);
    
    // DEBUG: Log formatted response
    $debugLog = date('Y-m-d H:i:s') . " | FORMATTED_COUNT: " . count($formattedData) . "\n";
    file_put_contents(__DIR__ . '/../../logs/riwayat-debug.log', $debugLog, FILE_APPEND);
    
    echo json_encode([
        'success' => true,
        'data' => $formattedData,
        'total' => $total,
        'limit' => $limit,
        'offset' => $offset,
        'has_more' => ($offset + $limit) < $total,
        '_debug' => [
            'user_npm' => $userNpm,
            'filters' => $filters,
            'raw_count' => count($data),
            'formatted_count' => count($formattedData)
        ]
    ]);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Error: ' . $e->getMessage()
    ]);
}