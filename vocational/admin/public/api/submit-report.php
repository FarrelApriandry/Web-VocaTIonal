<?php

// vocational/admin/public/api/submit-report.php
// Student API: Submit aspiration report

header('Content-Type: application/json');
require_once __DIR__ . '/../../app/Config/Database.php';
require_once __DIR__ . '/../../app/Models/Report.php';

use App\Models\Report;

try {
    // Start session for authentication
    session_start();
    
    // Check if user is logged in via session
    if (!isset($_SESSION['npm'])) {
        http_response_code(401);
        echo json_encode([
            'success' => false,
            'message' => 'Unauthorized: Login required'
        ]);
        exit;
    }
    
    // Get JSON request body
    $input = json_decode(file_get_contents('php://input'), true);
    
    // Validate required fields
    if (empty($input['id_aspirasi']) || empty($input['reason'])) {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'message' => 'Missing required fields: id_aspirasi, reason'
        ]);
        exit;
    }
    
    // Validate reason
    $validReasons = ['inappropriate', 'spam', 'offensive'];
    if (!in_array($input['reason'], $validReasons)) {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'message' => 'Invalid reason. Must be: inappropriate, spam, or offensive'
        ]);
        exit;
    }
    
    // Sanitize inputs
    $id_aspirasi = (int)$input['id_aspirasi'];
    $reason = htmlspecialchars($input['reason']);
    $message = isset($input['message']) ? htmlspecialchars($input['message']) : null;
    $npm_reporter = htmlspecialchars($_SESSION['npm']);
    
    // Create report using model
    $reportModel = new Report();
    $result = $reportModel->submitReport($id_aspirasi, $npm_reporter, $reason, $message);
    
    if ($result['success']) {
        http_response_code(201);
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