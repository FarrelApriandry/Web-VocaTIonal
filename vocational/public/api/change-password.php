<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit();
}

require_once __DIR__ . '/../../app/Controllers/Auth.php';
require_once __DIR__ . '/../../app/Config/Session.php';
require_once __DIR__ . '/../../app/Config/Database.php';

Session::start();

// Check authentication
$auth = new Auth();
if (!$auth->check()) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

// CSRF validation
$json = file_get_contents('php://input');
$data = json_decode($json, true);

$csrfToken = $data['csrf_token'] ?? '';
if (!Session::validateCSRFToken($csrfToken)) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'CSRF token tidak valid']);
    exit();
}

// Validate required fields
$currentPassword = $data['current_password'] ?? '';
$newPassword = $data['new_password'] ?? '';
$confirmPassword = $data['confirm_password'] ?? '';

if (!$currentPassword || !$newPassword || !$confirmPassword) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Semua field harus diisi']);
    exit();
}

if ($newPassword !== $confirmPassword) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Password baru tidak cocok']);
    exit();
}

if (strlen($newPassword) < 8) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Password baru minimal 8 karakter']);
    exit();
}

// Get current user
$npm = Session::get('user_npm');
$pdo = Database::getConnection();

$stmt = $pdo->prepare("SELECT password FROM mhs_whitelist WHERE npm = ?");
$stmt->execute([$npm]);
$user = $stmt->fetch();

if (!$user || !password_verify($currentPassword, $user['password'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Password saat ini salah']);
    exit();
}

// Update password
$newHash = password_hash($newPassword, PASSWORD_BCRYPT);
$stmt = $pdo->prepare("UPDATE mhs_whitelist SET password = ? WHERE npm = ?");
$stmt->execute([$newHash, $npm]);

echo json_encode(['success' => true, 'message' => 'Password berhasil diubah']);
