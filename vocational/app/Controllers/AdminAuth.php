<?php

// vocational/app/Controllers/AdminAuth.php

require_once __DIR__ . '/../Config/Session.php';
require_once __DIR__ . '/../Config/Database.php';

class AdminAuth
{
    private static $pdo = null;

    public static function init()
    {
        if (self::$pdo === null) {
            self::$pdo = Database::getConnection();
        }
    }

    /**
     * Login admin dengan username dan password
     * @param string $usn_adm - Admin username
     * @param string $pw_adm - Admin password
     * @return array - Login result
     */
    public static function login($usn_adm, $pw_adm)
    {
        try {
            self::init();

            // Query admin dari database
            $query = "SELECT admin_id, usn_adm, pw_adm, role_adm FROM admin_web WHERE usn_adm = ?";
            $stmt = self::$pdo->prepare($query);
            $stmt->execute([$usn_adm]);
            $admin = $stmt->fetch(\PDO::FETCH_ASSOC);

            // Admin tidak ditemukan
            if (!$admin) {
                return [
                    'success' => false,
                    'message' => 'Username atau password salah'
                ];
            }

            // Verifikasi password
            if (!password_verify($pw_adm, $admin['pw_adm'])) {
                return [
                    'success' => false,
                    'message' => 'Username atau password salah'
                ];
            }

            // Set session
            Session::start();
            Session::set('admin_id', $admin['admin_id']);
            Session::set('admin_username', $admin['usn_adm']);
            Session::set('admin_role', $admin['role_adm']);

            return [
                'success' => true,
                'message' => 'Login berhasil',
                'admin' => [
                    'id' => $admin['admin_id'],
                    'username' => $admin['usn_adm'],
                    'role' => $admin['role_adm']
                ]
            ];
        } catch (\Exception $e) {
            error_log('Admin login error: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Error login',
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Check if user is logged in as admin
     * @return bool
     */
    public static function check()
    {
        Session::start();
        return Session::has('admin_id');
    }

    /**
     * Get current admin data
     * @return array|null
     */
    public static function user()
    {
        Session::start();

        if (!self::check()) {
            return null;
        }

        return [
            'id' => Session::get('admin_id'),
            'username' => Session::get('admin_username'),
            'role' => Session::get('admin_role')
        ];
    }

    /**
     * Logout admin
     * @return void
     */
    public static function logout()
    {
        Session::start();
        Session::destroy([
            'admin_id',
            'admin_username',
            'admin_role'
        ]);
    }

    /**
     * Get all admin data
     * @return array|null
     */
    public static function getAdminData()
    {
        try {
            self::init();

            $admin = self::user();
            if (!$admin) {
                return null;
            }

            $query = "SELECT admin_id, usn_adm, role_adm FROM admin_web WHERE admin_id = ?";
            $stmt = self::$pdo->prepare($query);
            $stmt->execute([$admin['id']]);

            return $stmt->fetch(\PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            error_log('Get admin data error: ' . $e->getMessage());
            return null;
        }
    }
}