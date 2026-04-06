<?php
// vocational/admin/app/Controllers/DashboardController.php

require_once __DIR__ . '/AdminBaseController.php';

class DashboardController extends AdminBaseController {

    public function index() {
        try {
            // Total aspirations
            $stmt = $this->pdo->query("SELECT COUNT(*) as total FROM aspirasi");
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $totalAspirations = $result['total'] ?? 0;

            // Pending aspirations
            $stmt = $this->pdo->query("SELECT COUNT(*) as pending FROM aspirasi WHERE status = 'Pending'");
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $pendingAspirations = $result['pending'] ?? 0;

            // On board
            $stmt = $this->pdo->query("SELECT COUNT(*) as on_board FROM aspirasi WHERE show_on_board = 1 AND board_approved = 1");
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $onBoard = $result['on_board'] ?? 0;

            // Pending reports
            $stmt = $this->pdo->query("SELECT COUNT(*) as pending FROM aspirasi_reports WHERE status = 'pending'");
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $pendingReports = $result['pending'] ?? 0;

            // Most reported aspirations
            $stmt = $this->pdo->query("
                SELECT 
                    a.id_aspirasi,
                    a.judul,
                    COUNT(ar.id_report) as report_count
                FROM aspirasi a
                LEFT JOIN aspirasi_reports ar ON a.id_aspirasi = ar.id_aspirasi AND ar.status = 'pending'
                GROUP BY a.id_aspirasi
                HAVING report_count > 0
                ORDER BY report_count DESC
                LIMIT 5
            ");
            $mostReported = $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];

            // Prepare data for view
            $data = [
                'title' => 'Dashboard',
                'totalAspirations' => $totalAspirations,
                'pendingAspirations' => $pendingAspirations,
                'onBoard' => $onBoard,
                'pendingReports' => $pendingReports,
                'mostReported' => $mostReported,
                'admin' => $this->admin
            ];

            // Render view with layout
            $this->renderLayout('dashboard', $data);

        } catch (Exception $e) {
            error_log('Dashboard controller error: ' . $e->getMessage());
            die('Error loading dashboard: ' . $e->getMessage());
        }
    }
}

?>