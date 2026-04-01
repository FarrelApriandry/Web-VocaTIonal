<?php
require_once __DIR__ . '/../Config/Session.php';
require_once __DIR__ . '/../Config/Database.php';

class Auth {
    private $pdo;
    
    public function __construct() {
        $this->pdo = Database::getConnection();
        Session::start();
    }
    
    // Login dengan NPM
    public function login($npm) {
        // Validasi format NPM (10 digit angka)
        $npm = preg_replace('/[^0-9]/', '', $npm);
        
        if (strlen($npm) !== 10) {
            return ['success' => false, 'message' => 'NPM tidak valid'];
        }
        
        try {
            // Cek NPM di whitelist
            $stmt = $this->pdo->prepare("SELECT npm, nama FROM mhs_whitelist WHERE npm = ?");
            $stmt->execute([$npm]);
            $user = $stmt->fetch();
            
            if (!$user) {
                return ['success' => false, 'message' => 'NPM tidak terdaftar'];
            }
            
            // Cek apakah sudah login
            if (Session::has('user_npm')) {
                return ['success' => false, 'message' => 'Anda sudah login'];
            }
            
            // Buat session user
            Session::set('user_npm', $user['npm']);
            Session::set('user_nama', $user['nama']);
            Session::set('login_time', time());
            Session::set('session_token', Session::generateToken());
            
            // Generate CSRF token baru
            Session::generateCSRFToken();
            
            return [
                'success' => true, 
                'message' => 'Login berhasil',
                'user' => [
                    'npm' => $user['npm'],
                    'nama' => $user['nama']
                ]
            ];
            
        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Terjadi kesalahan sistem'];
        }
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
