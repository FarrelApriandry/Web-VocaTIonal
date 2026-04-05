<?php
require_once __DIR__ . '/../Config/Session.php';
require_once __DIR__ . '/../Config/Database.php';

class Auth {
    private $pdo;
    
    public function __construct() {
        $this->pdo = Database::getConnection();
        Session::start();
    }
    
    // Login dengan NPM - Enhanced Security
    public function login($npm) {
        // 1. Sanitize input - remove ALL non-numeric characters
        $npm = preg_replace('/[^0-9]/', '', $npm);
        
        // 2. Validate NPM length (exactly 10 digits)
        if (strlen($npm) !== 10) {
            $this->logSecurityEvent('invalid_npm_format', "Invalid NPM format: " . substr($npm, 0, 4) . "...", $_SERVER['REMOTE_ADDR']);
            return ['success' => false, 'message' => 'Format NPM tidak valid. NPM harus 10 digit angka.'];
        }
        
        // 3. Validate NPM pattern - first 2 digits should be valid year (20-24)
        $year = (int) substr($npm, 0, 2);
        if ($year < 20 || $year > 24) {
            $this->logSecurityEvent('invalid_npm_year', "Invalid NPM year: $year from IP " . $_SERVER['REMOTE_ADDR'], $_SERVER['REMOTE_ADDR']);
            return ['success' => false, 'message' => 'NPM tidak terdaftar. Pastikan NPM benar.'];
        }
        
        // 4. Check for suspicious patterns (e.g., all same digits)
        if (count(array_unique(str_split($npm))) === 1) {
            $this->logSecurityEvent('suspicious_npm', "Suspicious NPM pattern (all same digits): $npm", $_SERVER['REMOTE_ADDR']);
            return ['success' => false, 'message' => 'NPM tidak valid.'];
        }
        
        try {
            // 5. Check NPM in whitelist using prepared statement (anti SQL injection)
            $stmt = $this->pdo->prepare("SELECT npm, nama FROM mhs_whitelist WHERE npm = ?");
            $stmt->execute([$npm]);
            $user = $stmt->fetch();
            
            if (!$user) {
                // Log failed attempt
                $this->logSecurityEvent('login_failed', "Failed login attempt for NPM: " . substr($npm, 0, 4) . "...", $_SERVER['REMOTE_ADDR']);
                return ['success' => false, 'message' => 'NPM tidak terdaftar dalam whitelist.'];
            }
            
            // 6. Check if already logged in
            if (Session::has('user_npm')) {
                return ['success' => false, 'message' => 'Anda sudah login. Silakan logout terlebih dahulu.'];
            }
            
            // 7. Create secure session
            Session::set('user_npm', $user['npm']);
            Session::set('user_nama', $user['nama']);
            Session::set('login_time', time());
            Session::set('session_token', Session::generateToken());
            Session::set('user_agent', md5($_SERVER['HTTP_USER_AGENT'])); // Session fingerprinting
            Session::set('ip_address', $_SERVER['REMOTE_ADDR']); // IP tracking
            
            // 8. Regenerate session ID (prevent session fixation)
            Session::regenerate();
            
            // 9. Generate new CSRF token
            Session::generateCSRFToken();
            
            // Log successful login
            $this->logSecurityEvent('login_success', "Successful login for NPM: " . substr($user['npm'], 0, 4) . "...", $_SERVER['REMOTE_ADDR']);
            
            return [
                'success' => true, 
                'message' => 'Login berhasil',
                'user' => [
                    'npm' => $user['npm'],
                    'nama' => $user['nama']
                ]
            ];
            
        } catch (PDOException $e) {
            // Log database error (don't expose details to user)
            $this->logSecurityEvent('database_error', "Database error during login: " . $e->getMessage(), $_SERVER['REMOTE_ADDR']);
            return ['success' => false, 'message' => 'Terjadi kesalahan sistem. Silakan coba lagi.'];
        }
    }
    
    // Security logging function
    private function logSecurityEvent($type, $message, $ip) {
        $logEntry = [
            'timestamp' => date('Y-m-d H:i:s'),
            'type' => $type,
            'message' => $message,
            'ip' => $ip,
            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'unknown'
        ];
        
        // Log to file (in production, use proper logging system)
        $logFile = __DIR__ . '/../Logs/security_' . date('Y-m-d') . '.log';
        $logDir = dirname($logFile);
        
        // Suppress errors dengan @ operator - jika folder creation gagal, tetap lanjut
        if (!is_dir($logDir)) {
            @mkdir($logDir, 0755, true);
        }
        
        // Suppress file write errors - jika write gagal, tidak perlu crash
        @file_put_contents($logFile, json_encode($logEntry) . PHP_EOL, FILE_APPEND);
    }
    
    // Logout
    public function logout() {
        Session::destroy();
        return ['success' => true, 'message' => 'Logout berhasil'];
    }
    
    // Cek apakah user sudah login DAN session masih valid
    public function check() {
        // Check if session exists
        if (!Session::has('user_npm')) {
            return false;
        }
        
        // Check if session is valid (not expired)
        if (!Session::isValid()) {
            $this->logout();
            return false;
        }
        
        return true;
    }
    
    // Get current user with session info
    public function user() {
        if (!$this->check()) {
            return null;
        }
        
        return [
            'npm' => Session::get('user_npm'),
            'nama' => Session::get('user_nama'),
            'login_time' => Session::get('login_time'),
            'last_activity' => Session::get('last_activity'),
            'remaining_time' => Session::getRemainingTime(),
            'is_about_to_expire' => Session::isAboutToExpire()
        ];
    }
    
    // Validasi session token (anti CSRF)
    public function validateSessionToken($token) {
        return Session::has('session_token') && 
               hash_equals(Session::get('session_token'), $token);
    }
}
