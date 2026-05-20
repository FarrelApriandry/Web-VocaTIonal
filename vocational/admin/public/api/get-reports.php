<?php

// vocational/admin/public/api/get-reports.php
// Admin API: Get all reports with filtering and pagination

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
    
    // Get query parameters
    $status = $_GET['status'] ?? null;
    $reason = $_GET['reason'] ?? null;
    $sort = $_GET['sort'] ?? 'created_at';
    $sort_direction = $_GET['sort_direction'] ?? 'DESC';
    $page = (int)($_GET['page'] ?? 1);
    $limit = (int)($_GET['limit'] ?? 20);
    
    // Validate and sanitize
    $validStatuses = ['pending', 'confirmed', 'processing', 'resolved', 'dismissed'];
    if ($status && !in_array($status, $validStatuses)) {
        $status = null;
    }
    
    $validReasons = ['inappropriate', 'spam', 'offensive'];
    if ($reason && !in_array($reason, $validReasons)) {
        $reason = null;
    }
    
    $validSorts = ['created_at', 'id_report', 'status', 'reason'];
    if (!in_array($sort, $validSorts)) {
        $sort = 'created_at';
    }
    
    if (!in_array($sort_direction, ['ASC', 'DESC'])) {
        $sort_direction = 'DESC';
    }
    
    $limit = min($limit, 100); // Max 100 items per page
    $offset = ($page - 1) * $limit;
    
    // Build filters array
    $filters = [
        'status' => $status,
        'reason' => $reason,
        'sort' => $sort,
        'sort_direction' => $sort_direction,
        'limit' => $limit,
        'offset' => $offset
    ];
    
    // Fetch reports
    $reportModel = new Report();
    $reports = $reportModel->getReports($filters);
    $total = $reportModel->getReportCount([
        'status' => $status,
        'reason' => $reason
    ]);
    
    // Calculate pagination
    $totalPages = ceil($total / $limit);
    
    http_response_code(200);
    echo json_encode([
        'success' => true,
        'data' => $reports,
        'pagination' => [
            'total' => $total,
            'page' => $page,
            'limit' => $limit,
            'pages' => $totalPages
        ]
    ]);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Server error: ' . $e->getMessage()
    ]);
}