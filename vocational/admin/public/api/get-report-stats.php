<?php

// vocational/admin/public/api/get-report-stats.php
// Admin API: Get report statistics for dashboard

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
    
    // Fetch report statistics
    $reportModel = new Report();
    $stats = $reportModel->getReportStats();
    $byReason = $reportModel->getReportsByReason();
    
    http_response_code(200);
    echo json_encode([
        'success' => true,
        'data' => [
            'summary' => $stats,
            'by_reason' => $byReason
        ]
    ]);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Server error: ' . $e->getMessage()
    ]);
}