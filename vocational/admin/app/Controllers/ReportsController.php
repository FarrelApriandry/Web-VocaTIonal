<?php
// vocational/admin/app/Controllers/ReportsController.php

require_once __DIR__ . '/AdminBaseController.php';

class ReportsController extends AdminBaseController {

    public function index() {
        try {
            // Get filters from query parameters
            $reason_filter = $_GET['reason'] ?? '';
            $kategori_filter = $_GET['kategori'] ?? '';
            $status_filter = $_GET['status'] ?? 'pending';
            $page = max(1, (int)($_GET['page'] ?? 1));
            $limit = 20;
            $offset = ($page - 1) * $limit;

            // Build query for reports
            $query = "SELECT 
                ar.id_report,
                ar.id_aspirasi,
                a.judul,
                a.kategori,
                ar.reason,
                ar.message,
                ar.status,
                ar.created_at,
                COUNT(DISTINCT ar2.id_report) as similar_reports
            FROM aspirasi_reports ar
            JOIN aspirasi a ON ar.id_aspirasi = a.id_aspirasi
            LEFT JOIN aspirasi_reports ar2 ON ar.id_aspirasi = ar2.id_aspirasi 
                AND ar2.status = 'pending'
            WHERE 1=1";

            $params = [];

            if (!empty($status_filter)) {
                $query .= " AND ar.status = ?";
                $params[] = $status_filter;
            }

            if (!empty($reason_filter)) {
                $query .= " AND ar.reason = ?";
                $params[] = $reason_filter;
            }

            if (!empty($kategori_filter)) {
                $query .= " AND a.kategori = ?";
                $params[] = $kategori_filter;
            }

            $query .= " GROUP BY ar.id_report ORDER BY ar.created_at DESC LIMIT " . (int)$limit . " OFFSET " . (int)$offset;

            // Get reports
            $stmt = $this->pdo->prepare($query);
            $stmt->execute($params);
            $allReports = $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];

            // Count total for pagination
            $countQuery = "SELECT COUNT(DISTINCT ar.id_report) as total FROM aspirasi_reports ar
                          JOIN aspirasi a ON ar.id_aspirasi = a.id_aspirasi
                          WHERE 1=1";

            if (!empty($status_filter)) {
                $countQuery .= " AND ar.status = ?";
            }
            if (!empty($reason_filter)) {
                $countQuery .= " AND ar.reason = ?";
            }
            if (!empty($kategori_filter)) {
                $countQuery .= " AND a.kategori = ?";
            }

            $countStmt = $this->pdo->prepare($countQuery);
            $countStmt->execute($params);
            $totalCount = $countStmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;
            $totalPages = ceil($totalCount / $limit);

            // Get stats
            $statsQuery = "SELECT 
                COUNT(*) as total_pending,
                SUM(CASE WHEN reason = 'inappropriate' THEN 1 ELSE 0 END) as inappropriate_count,
                SUM(CASE WHEN reason = 'spam' THEN 1 ELSE 0 END) as spam_count,
                SUM(CASE WHEN reason = 'offensive' THEN 1 ELSE 0 END) as offensive_count
            FROM aspirasi_reports
            WHERE status = 'pending'";
            
            $statsStmt = $this->pdo->prepare($statsQuery);
            $statsStmt->execute();
            $stats = $statsStmt->fetch(PDO::FETCH_ASSOC);

            // Prepare data
            $data = [
                'title' => 'Laporan',
                'currentPage' => 'reports',
                'allReports' => $allReports,
                'totalCount' => $totalCount,
                'totalPages' => $totalPages,
                'page' => $page,
                'stats' => $stats,
                'reason_filter' => $reason_filter,
                'kategori_filter' => $kategori_filter,
                'status_filter' => $status_filter,
                'admin' => $this->admin
            ];

            // Render view with layout
            $this->renderLayout('reports', $data);

        } catch (Exception $e) {
            error_log('Reports controller error: ' . $e->getMessage());
            die('Error loading reports: ' . $e->getMessage());
        }
    }
}

?>