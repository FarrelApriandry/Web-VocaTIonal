<?php

// vocational/public/api/submit-aspirasi.php

header('Content-Type: application/json');
session_start();

require_once __DIR__ . '/../../app/Config/Database.php';
require_once __DIR__ . '/../../app/Models/Aspirasi.php';
require_once __DIR__ . '/../../app/Controllers/Auth.php';

// Only POST requests allowed
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    die(json_encode(['success' => false, 'message' => 'Method not allowed']));
}

// Check authentication
$auth = new Auth();
if (!$auth->check()) {
    http_response_code(401);
    die(json_encode(['success' => false, 'message' => 'Unauthorized']));
}

try {
    $user = $auth->user();
    $npm = $user['npm'];

    // Get form data
    $judul = $_POST['subjek'] ?? null;
    $deskripsi = $_POST['detail'] ?? null;
    $kategori = $_POST['kategori'] ?? null;
    $anonim = isset($_POST['anonim']) && $_POST['anonim'] === '1' ? true : false;
    $showOnBoard = isset($_POST['show_on_board']) && $_POST['show_on_board'] === '1' ? true : false;

    // Validation
    if (!$judul || !trim($judul)) {
        http_response_code(400);
        die(json_encode(['success' => false, 'message' => 'Judul tidak boleh kosong']));
    }

    if (!$deskripsi || !trim($deskripsi)) {
        http_response_code(400);
        die(json_encode(['success' => false, 'message' => 'Deskripsi tidak boleh kosong']));
    }

    if (!$kategori) {
        http_response_code(400);
        die(json_encode(['success' => false, 'message' => 'Kategori harus dipilih']));
    }

    // Validate kategori
    $validCategories = ['Akademik', 'Fasilitas', 'Sarpras', 'Layanan', 'UKT', 'Lainnya'];
    if (!in_array($kategori, $validCategories)) {
        http_response_code(400);
        die(json_encode(['success' => false, 'message' => 'Kategori tidak valid']));
    }

    // Trim inputs
    $judul = trim(substr($judul, 0, 255));
    $deskripsi = trim(substr($deskripsi, 0, 5000));

    // Create aspirasi
    $aspirasi = new Aspirasi();
    $result = $aspirasi->create($npm, $judul, $deskripsi, $kategori, $anonim, $showOnBoard);

    if (!$result) {
        http_response_code(500);
        die(json_encode(['success' => false, 'message' => 'Gagal menyimpan aspirasi']));
    }

    http_response_code(201);
    echo json_encode([
        'success' => true,
        'message' => 'Aspirasi berhasil dikirim!',
        'data' => [
            'judul' => $judul,
            'kategori' => $kategori,
            'anonim' => $anonim,
            'showOnBoard' => $showOnBoard
        ]
    ]);
} catch (Exception $e) {
    http_response_code(500);
    error_log('Submit aspirasi error: ' . $e->getMessage() . ' - ' . $e->getFile() . ':' . $e->getLine());
    echo json_encode([
        'success' => false,
        'message' => 'Error menyimpan aspirasi',
        'error' => $e->getMessage()
    ]);
}
