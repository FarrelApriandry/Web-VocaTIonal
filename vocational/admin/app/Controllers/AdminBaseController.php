<?php
// vocational/admin/app/Controllers/AdminBaseController.php

/**
 * Base Controller for all admin controllers
 * Handles common functionality and auth checks
 */

abstract class AdminBaseController {
    protected $pdo;
    protected $admin;
    protected $aspirasi;
    protected $report;

    public function __construct() {
        // Auth check - should already be done in router, but double-check
        if (!AdminAuth::check()) {
            header('Location: ./auth/login.php');
            exit;
        }

        // Initialize database connection
        $this->pdo = Database::getConnection();
        
        // Get current admin info
        $this->admin = AdminAuth::user();

        // Initialize models
        $this->aspirasi = new Aspirasi();
        $this->report = new AspirationReport();
    }

    /**
     * Render with layout
     * 
     * @param string $view - View filename
     * @param array $data - Data to pass to view
     * @param string $layout - Layout file (default: main)
     */
    protected function renderLayout($view, $data = [], $layout = 'main') {
        // Build view path
        $viewPath = __DIR__ . '/../Views/' . $view . '.php';

        if (!file_exists($viewPath)) {
            die("View file not found: {$viewPath}");
        }

        // Capture view output with proper scope
        $renderViewFn = function($viewPath, $data) {
            extract($data);
            ob_start();
            include $viewPath;
            return ob_get_clean();
        };

        $content = $renderViewFn($viewPath, $data);

        // Include layout with content (Fixed case: Layouts with capital L)
        $layoutPath = __DIR__ . '/../Views/Layouts/' . $layout . '.php';
        if (!file_exists($layoutPath)) {
            die("Layout file not found: {$layoutPath}");
        }

        // Render layout with data and content
        $renderLayoutFn = function($layoutPath, $data, $content) {
            extract($data);
            include $layoutPath;
        };

        $renderLayoutFn($layoutPath, $data, $content);
    }

    /**
     * Get current admin information
     */
    protected function getAdmin() {
        return $this->admin;
    }

    /**
     * Check admin role
     */
    protected function hasRole($role) {
        return isset($this->admin['role']) && $this->admin['role'] === $role;
    }
}

?>