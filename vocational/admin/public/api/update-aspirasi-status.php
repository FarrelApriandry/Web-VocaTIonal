<?php
// vocational/admin/api/update-aspirasi-status.php

ini_set('display_errors', '0');
error_reporting(E_ALL);

session_start();

require_once __DIR__ . '/../../app/Controllers/AdminAuth.php';
require_once __DIR__ . '/../../app/Config/Database.php';

header('Content-Type: application/json');

// Auth check
if (!AdminAuth::check()) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

// Get JSON input
$data = json_decode(file_get_contents('php://input'), true);

// Validate input
if (empty($data['id_aspirasi']) || empty($data['status'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Missing required fields']);
    exit;
}

$id_aspirasi = (int)$data['id_aspirasi'];
$new_status = $data['status'];

// Validate status
$valid_statuses = ['Pending', 'Proses', 'Selesai'];
if (!in_array($new_status, $valid_statuses)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid status']);
    exit;
}

try {
    $pdo = Database::getConnection();
    
    // Check if aspirasi exists
    $checkStmt = $pdo->prepare("SELECT id_aspirasi FROM aspirasi WHERE id_aspirasi = ?");
    $checkStmt->execute([$id_aspirasi]);
    
    if (!$checkStmt->fetch(PDO::FETCH_ASSOC)) {
        http_response_code(404);
        echo json_encode(['success' => false, 'message' => 'Aspirasi not found']);
        exit;
    }
    
    // Update status
    $updateStmt = $pdo->prepare("UPDATE aspirasi SET status = ? WHERE id_aspirasi = ?");
    $result = $updateStmt->execute([$new_status, $id_aspirasi]);
    
    if ($result) {
        http_response_code(200);
        echo json_encode([
            'success' => true,
            'message' => "Status aspirasi berhasil diupdate ke '{$new_status}'",
            'id_aspirasi' => $id_aspirasi,
            'new_status' => $new_status
        ]);
    } else {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Failed to update status']);
    }
    
} catch (Exception $e) {
    error_log('Update aspirasi status error: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Server error']);
}