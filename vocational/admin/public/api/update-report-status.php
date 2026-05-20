<?php

// vocational/admin/public/api/update-report-status.php
// Admin API: Update report status (confirmed, processing, resolved, dismissed)

// CRITICAL: Prevent ANY output before JSON - Start output buffering FIRST
ob_start();
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/../../logs/admin-api.log');
error_reporting(E_ALL);

// Set JSON header
header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../../app/Config/Database.php';
require_once __DIR__ . '/../../app/Models/Report.php';

use App\Models\Report;

try {
    // CRITICAL: Clean any output that might have been buffered
    ob_clean();
    
    // Start session for authentication
    session_start();
    
    // Check if user is admin
    if (!isset($_SESSION['admin_role']) || $_SESSION['admin_role'] !== 'Admin') {
        ob_clean();
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
        ob_clean();
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
        ob_clean();
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
    
    ob_clean();
    if ($result['success']) {
        http_response_code(200);
        echo json_encode($result);
    } else {
        http_response_code(400);
        echo json_encode($result);
    }
    
} catch (Exception $e) {
    ob_clean();
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Server error: ' . $e->getMessage()
    ]);
}