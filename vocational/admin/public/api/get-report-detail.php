<?php

// vocational/admin/public/api/get-report-detail.php
// Admin API: Get single report with full details

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
    error_log('=== [API] GET REPORT DETAIL DEBUG START ===');
    error_log('[API] Request Method: ' . $_SERVER['REQUEST_METHOD']);
    error_log('[API] Request URI: ' . $_SERVER['REQUEST_URI']);
    error_log('[API] Session Data: ' . json_encode($_SESSION));
    
    // Check if user is admin
    error_log('[API] Checking admin_role: ' . ($_SESSION['admin_role'] ?? 'NOT SET'));
    if (!isset($_SESSION['admin_role']) || $_SESSION['admin_role'] !== 'Admin') {
        error_log('❌ [API] Access Denied: Invalid admin role');
        ob_clean();
        http_response_code(403);
        echo json_encode([
            'success' => false,
            'message' => 'Forbidden: Admin access required'
        ]);
        error_log('=== [API] GET REPORT DETAIL DEBUG END (403) ===');
        exit;
    }
    error_log('✅ [API] Admin authentication passed');
    
    // Get report ID from query string
    $id_report = (int)($_GET['id'] ?? 0);
    error_log('[API] Report ID from query: ' . $id_report);
    
    if ($id_report === 0) {
        error_log('❌ [API] Invalid report ID');
        ob_clean();
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'message' => 'Missing or invalid report ID'
        ]);
        error_log('=== [API] GET REPORT DETAIL DEBUG END (400) ===');
        exit;
    }
    
    // Fetch report detail
    error_log('[API] Fetching report detail from model...');
    $reportModel = new Report();
    error_log('[API] Report model instantiated');
    
    try {
        $report = $reportModel->getReportDetail($id_report);
        error_log('[API] Report data received: ' . ($report ? 'YES' : 'NO'));
        error_log('[API] Report content: ' . json_encode($report));
    } catch (Exception $modelError) {
        error_log('❌ [API] Model error: ' . $modelError->getMessage());
        error_log('❌ [API] Model error trace: ' . $modelError->getTraceAsString());
        throw $modelError;
    }
    
    if (!$report) {
        error_log('❌ [API] Report not found in database');
        ob_clean();
        http_response_code(404);
        echo json_encode([
            'success' => false,
            'message' => 'Report not found'
        ]);
        error_log('=== [API] GET REPORT DETAIL DEBUG END (404) ===');
        exit;
    }
    
    error_log('✅ [API] Report found successfully');
    ob_clean();
    http_response_code(200);
    echo json_encode([
        'success' => true,
        'data' => $report
    ]);
    error_log('✅ [API] Response sent successfully');
    error_log('=== [API] GET REPORT DETAIL DEBUG END (200) ===');
    
} catch (Exception $e) {
    error_log('❌ [API] Exception caught: ' . $e->getMessage());
    error_log('❌ [API] Exception Code: ' . $e->getCode());
    error_log('❌ [API] Exception File: ' . $e->getFile());
    error_log('❌ [API] Exception Line: ' . $e->getLine());
    error_log('❌ [API] Stack Trace: ' . $e->getTraceAsString());
    
    ob_clean();
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Server error: ' . $e->getMessage()
    ]);
    error_log('=== [API] GET REPORT DETAIL DEBUG END (500) ===');
}