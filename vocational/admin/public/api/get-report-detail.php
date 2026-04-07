<?php

// vocational/admin/public/api/get-report-detail.php
// Admin API: Get single report with full details

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
    
    // Get report ID from query string
    $id_report = (int)($_GET['id'] ?? 0);
    
    if ($id_report === 0) {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'message' => 'Missing or invalid report ID'
        ]);
        exit;
    }
    
    // Fetch report detail
    $reportModel = new Report();
    $report = $reportModel->getReportDetail($id_report);
    
    if (!$report) {
        http_response_code(404);
        echo json_encode([
            'success' => false,
            'message' => 'Report not found'
        ]);
        exit;
    }
    
    http_response_code(200);
    echo json_encode([
        'success' => true,
        'data' => $report
    ]);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Server error: ' . $e->getMessage()
    ]);
}