<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit();
}

require_once __DIR__ . '/../../app/Config/Session.php';
require_once __DIR__ . '/../../app/Config/Database.php';

Session::start();

if (!Session::has('user_npm')) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

$json = file_get_contents('php://input');
$data = json_decode($json, true);

$id = intval($data['id_aspirasi'] ?? 0);
$csrfToken = $data['csrf_token'] ?? '';

if (!Session::validateCSRFToken($csrfToken)) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'CSRF token tidak valid']);
    exit();
}

if (!$id) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'ID aspirasi tidak valid']);
    exit();
}

$npm = Session::get('user_npm');
$pdo = Database::getConnection();

// Verify ownership
$stmt = $pdo->prepare("SELECT id_aspirasi FROM aspirasi WHERE id_aspirasi = ? AND npm_pelapor = ?");
$stmt->execute([$id, $npm]);

if (!$stmt->fetch()) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Anda tidak memiliki akses untuk menghapus aspirasi ini']);
    exit();
}

$stmt = $pdo->prepare("DELETE FROM aspirasi WHERE id_aspirasi = ? AND npm_pelapor = ?");
$stmt->execute([$id, $npm]);

echo json_encode(['success' => true, 'message' => 'Aspirasi berhasil dihapus']);
