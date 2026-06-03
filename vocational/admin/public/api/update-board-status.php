<?php
// vocational/admin/public/api/update-board-status.php

ini_set('display_errors', '0');
error_reporting(E_ALL);

session_start();

require_once __DIR__ . '/../../app/Controllers/AdminAuth.php';
require_once __DIR__ . '/../../app/Config/Database.php';

header('Content-Type: application/json');

if (!AdminAuth::check()) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['id_aspirasi']) || !isset($data['board_approved'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Missing required fields']);
    exit;
}

$id_aspirasi   = (int)$data['id_aspirasi'];
$board_approved = $data['board_approved'] ? 1 : 0;

try {
    $pdo = Database::getConnection();

    // Hanya boleh approve jika user memang minta tampil di board
    $check = $pdo->prepare("SELECT id_aspirasi FROM aspirasi WHERE id_aspirasi = ? AND show_on_board = 1");
    $check->execute([$id_aspirasi]);

    if (!$check->fetch()) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Aspirasi tidak ditemukan atau tidak meminta tampil di papan buletin']);
        exit;
    }

    $stmt = $pdo->prepare("UPDATE aspirasi SET board_approved = ? WHERE id_aspirasi = ?");
    $stmt->execute([$board_approved, $id_aspirasi]);

    echo json_encode([
        'success'       => true,
        'message'       => $board_approved ? 'Aspirasi ditampilkan di papan buletin' : 'Aspirasi disembunyikan dari papan buletin',
        'board_approved' => $board_approved
    ]);

} catch (Exception $e) {
    error_log('update-board-status error: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Server error']);
}
