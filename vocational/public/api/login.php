<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type, X-CSRF-Token');

// Handle preflight
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

require_once __DIR__ . '/../../app/Controllers/Auth.php';
require_once __DIR__ . '/../../app/Config/Session.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit();
}

// Start session for rate limiting
Session::start();

// ==========================================
// RATE LIMITING - Anti Brute Force
// ==========================================
$ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
$now = time();

// IP-based rate limit: max 5 attempts per 15 minutes
$ipKey = "login_attempts_ip_$ip";
$ipData = $_SESSION[$ipKey] ?? ['count' => 0, 'last' => 0];

if ($now - $ipData['last'] < 900) { // 15 minutes
    if ($ipData['count'] >= 5) {
        $retryAfter = 900 - ($now - $ipData['last']);
        http_response_code(429);
        echo json_encode([
            'success' => false,
            'message' => "Terlalu banyak percobaan login. Silakan coba lagi dalam $retryAfter detik.",
            'retry_after' => $retryAfter
        ]);
        exit();
    }
} else {
    $ipData = ['count' => 0, 'last' => $now];
}

// Get JSON input
$json = file_get_contents('php://input');
$data = json_decode($json, true);

if (!isset($data['npm']) || empty($data['npm'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'NPM harus diisi']);
    exit();
}

// NPM-based rate limit: max 3 attempts per 10 minutes per NPM
$npm = preg_replace('/[^0-9]/', '', $data['npm']);
$npmKey = "login_attempts_npm_$npm";
$npmData = $_SESSION[$npmKey] ?? ['count' => 0, 'last' => 0];

if ($now - $npmData['last'] < 600) { // 10 minutes
    if ($npmData['count'] >= 3) {
        $retryAfter = 600 - ($now - $npmData['last']);
        http_response_code(429);
        echo json_encode([
            'success' => false,
            'message' => "NPM ini sudah terlalu sering dicoba. Silakan coba lagi dalam $retryAfter detik.",
            'retry_after' => $retryAfter
        ]);
        exit();
    }
} else {
    $npmData = ['count' => 0, 'last' => $now];
}

// Increment rate limit counters
$_SESSION[$ipKey] = ['count' => $ipData['count'] + 1, 'last' => $now];
$_SESSION[$npmKey] = ['count' => $npmData['count'] + 1, 'last' => $now];

// ==========================================
// CSRF TOKEN VALIDATION
// ==========================================
$csrfToken = $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '';
if (!empty($csrfToken) && !Session::validateCSRFToken($csrfToken)) {
    http_response_code(403);
    echo json_encode([
        'success' => false,
        'message' => 'CSRF token tidak valid. Silakan refresh halaman.'
    ]);
    exit();
}

// ==========================================
// PROCEED WITH LOGIN
// ==========================================
$auth = new Auth();
$result = $auth->login($data['npm']);

if ($result['success']) {
    // Reset rate limits on successful login
    unset($_SESSION[$ipKey]);
    unset($_SESSION[$npmKey]);
    
    http_response_code(200);
} else {
    http_response_code(401);
}

echo json_encode($result);
