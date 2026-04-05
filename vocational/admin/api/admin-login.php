<?php
// vocational/admin/api/admin-login.php

require_once __DIR__ . '/../../app/Config/Session.php';
require_once __DIR__ . '/../../app/Controllers/AdminAuth.php';

header('Content-Type: application/json');

// SUPPRESS ERROR DISPLAY
ini_set('display_errors', '0');
error_reporting(E_ALL);

try {
    // Check request method
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        echo json_encode([
            'success' => false,
            'message' => 'Method not allowed'
        ]);
        exit;
    }

    // Get JSON input
    $input = json_decode(file_get_contents('php://input'), true);

    if (!$input) {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'message' => 'Invalid JSON'
        ]);
        exit;
    }

    // Validate input
    $username = $input['username'] ?? null;
    $password = $input['password'] ?? null;

    if (!$username || !$password) {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'message' => 'Username dan password harus diisi'
        ]);
        exit;
    }

    // Attempt login
    $result = AdminAuth::login($username, $password);

    http_response_code($result['success'] ? 200 : 401);
    echo json_encode($result);

} catch (Exception $e) {
    error_log('Admin login API error: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Server error'
    ]);
}
