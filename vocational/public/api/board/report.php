<?php

// vocational/public/api/board/report.php

header('Content-Type: application/json');
session_start();

require_once __DIR__ . '/../../app/Config/Database.php';
require_once __DIR__ . '/../../app/Models/AspirationReport.php';
require_once __DIR__ . '/../../app/Controllers/Auth.php';

// Only POST requests allowed
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    die(json_encode(['success' => false, 'message' => 'Method not allowed']));
}

// Check authentication
$auth = new Auth();
if (!$auth->check()) {
    http_response_code(401);
    die(json_encode(['success' => false, 'message' => 'Unauthorized']));
}

try {
    $user = $auth->user();
    $npm = $user['npm'];

    // Get JSON body
    $input = json_decode(file_get_contents('php://input'), true);

    if (!$input || !isset($input['id_aspirasi']) || !isset($input['reason'])) {
        http_response_code(400);
        die(json_encode(['success' => false, 'message' => 'Missing id_aspirasi or reason']));
    }

    $id_aspirasi = intval($input['id_aspirasi']);
    $reason = $input['reason'];
    $message = $input['message'] ?? null;

    // Validate reason
    $validReasons = ['inappropriate', 'spam', 'offensive'];
    if (!in_array($reason, $validReasons)) {
        http_response_code(400);
        die(json_encode(['success' => false, 'message' => 'Invalid reason']));
    }

    $report = new AspirationReport();

    // Check if already reported
    if ($report->hasUserReported($id_aspirasi, $npm)) {
        http_response_code(409);
        die(json_encode([
            'success' => false,
            'message' => 'You have already reported this aspiration'
        ]));
    }

    // Add report
    $result = $report->addReport($id_aspirasi, $npm, $reason, $message);

    if (!$result) {
        http_response_code(500);
        die(json_encode([
            'success' => false,
            'message' => 'Failed to submit report'
        ]));
    }

    // Get updated report count
    $totalReports = $report->getPendingReportCount($id_aspirasi);

    http_response_code(201);
    echo json_encode([
        'success' => true,
        'message' => 'Report submitted successfully',
        'data' => [
            'id_aspirasi' => $id_aspirasi,
            'reason' => $reason,
            'totalReports' => $totalReports
        ]
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Error submitting report',
        'error' => $e->getMessage()
    ]);
}