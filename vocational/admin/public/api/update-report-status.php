<?php

// vocational/admin/public/api/update-report-status.php
// Admin API: Update report status (confirmed, processing, resolved, dismissed)

header('Content-Type: application/json');
require_once __DIR__ . '/../../app/Config/Database.php';
require_once __DIR__ . '/../../app/Models/Report.php';

use App\Models\Report;

try {
    // Start session for authentication
    session_start();
    
    // Check if user is admin
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
        http_response_code(403);
        echo json_encode([
            'success' => false,
            'message' => 'Forbidden: Admin access required'
        ]);
        exit;
    }
    
    // Get JSON request body
    $input = json_decode(file_get_contents('php://input'), true);
    
    // Validate required fields
    if (empty($input['id_report']) || empty($input['status'])) {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'message' => 'Missing required fields: id_report, status'
        ]);
        exit;
    }
    
    // Validate status
    $validStatuses = ['pending', 'confirmed', 'processing', 'resolved', 'dismissed'];
    if (!in_array($input['status'], $validStatuses)) {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'message' => 'Invalid status. Must be: pending, confirmed, processing, resolved, or dismissed'
        ]);
        exit;
    }
    
    // Sanitize inputs
    $id_report = (int)$input['id_report'];
    $new_status = htmlspecialchars($input['status']);
    $note = isset($input['note']) ? htmlspecialchars($input['note']) : null;
    
    // Update report status
    $reportModel = new Report();
    $result = $reportModel->updateReportStatus($id_report, $new_status, $note);
    
    if ($result['success']) {
        http_response_code(200);
        echo json_encode($result);
    } else {
        http_response_code(400);
        echo json_encode($result);
    }
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Server error: ' . $e->getMessage()
    ]);
}