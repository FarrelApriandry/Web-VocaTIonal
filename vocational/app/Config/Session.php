<?php
class Session {
    // Session timeout: 60 menit (3600 detik)
    const SESSION_TIMEOUT = 3600;
    const WARNING_THRESHOLD = 300; // Warning 5 menit sebelum expire
    
    public static function start() {
        if (session_status() === PHP_SESSION_NONE) {
            // Set session timeout configuration
            ini_set('session.gc_maxlifetime', self::SESSION_TIMEOUT);
            ini_set('session.cookie_lifetime', self::SESSION_TIMEOUT);
            
            session_start([
                'cookie_httponly' => true,
                'cookie_secure' => false, // Set true kalo pake HTTPS
                'use_strict_mode' => true,
                'cookie_samesite' => 'Strict',
                'cookie_lifetime' => self::SESSION_TIMEOUT
            ]);
            
            // Check if session expired (for existing sessions)
            if (isset($_SESSION['login_time'])) {
                $elapsed = time() - $_SESSION['login_time'];
                if ($elapsed > self::SESSION_TIMEOUT) {
                    // Session expired!
                    self::destroy();
                    return false;
                }
                
                // Update last activity
                $_SESSION['last_activity'] = time();
            }
        }
        return true;
    }
    
    public static function set($key, $value) {
        $_SESSION[$key] = $value;
    }
    
    public static function get($key, $default = null) {
        return $_SESSION[$key] ?? $default;
    }
    
    public static function has($key) {
        return isset($_SESSION[$key]);
    }
    
    public static function destroy() {
        // Clear all session data
        $_SESSION = [];
        
        // Destroy session cookie
        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time() - 3600, '/');
        }
        
        // Destroy session
        session_destroy();
    }
    
    // Check if session is valid (not expired)
    public static function isValid() {
        if (!isset($_SESSION['login_time'])) {
            return false;
        }
        
        $elapsed = time() - $_SESSION['login_time'];
        return $elapsed <= self::SESSION_TIMEOUT;
    }
    
    // Get remaining session time in seconds
    public static function getRemainingTime() {
        if (!isset($_SESSION['login_time'])) {
            return 0;
        }
        
        $elapsed = time() - $_SESSION['login_time'];
        return max(0, self::SESSION_TIMEOUT - $elapsed);
    }
    
    // Check if session is about to expire (within warning threshold)
    public static function isAboutToExpire() {
        $remaining = self::getRemainingTime();
        return $remaining > 0 && $remaining <= self::WARNING_THRESHOLD;
    }
    
    // Generate secure token
    public static function generateToken($length = 32) {
        return bin2hex(random_bytes($length));
    }
    
    // CSRF Token
    public static function generateCSRFToken() {
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = self::generateToken();
        }
        return $_SESSION['csrf_token'];
    }
    
    public static function validateCSRFToken($token) {
        return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
    }
}
