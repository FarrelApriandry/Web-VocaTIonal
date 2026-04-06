<?php
// vocational/admin/app/Controllers/AspirationsController.php

require_once __DIR__ . '/AdminBaseController.php';

class AspirationsController extends AdminBaseController {

    public function index() {
        try {
            // Get filters from query parameters
            $status_filter = $_GET['status'] ?? '';
            $kategori_filter = $_GET['kategori'] ?? '';
            $search = $_GET['search'] ?? '';
            $page = max(1, (int)($_GET['page'] ?? 1));
            $limit = 20;
            $offset = ($page - 1) * $limit;

            // Build query
            $query = "SELECT * FROM aspirasi WHERE 1=1";
            $params = [];

            if (!empty($status_filter)) {
                $query .= " AND status = ?";
                $params[] = $status_filter;
            }

            if (!empty($kategori_filter)) {
                $query .= " AND kategori = ?";
                $params[] = $kategori_filter;
            }

            if (!empty($search)) {
                $query .= " AND (judul LIKE ? OR deskripsi LIKE ?)";
                $params[] = "%$search%";
                $params[] = "%$search%";
            }

            // Count total
            $countQuery = "SELECT COUNT(*) as total FROM aspirasi WHERE 1=1";
            if (!empty($status_filter)) $countQuery .= " AND status = ?";
            if (!empty($kategori_filter)) $countQuery .= " AND kategori = ?";
            if (!empty($search)) $countQuery .= " AND (judul LIKE ? OR deskripsi LIKE ?)";

            $countStmt = $this->pdo->prepare($countQuery);
            $countStmt->execute($params);
            $totalCount = $countStmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;
            $totalPages = ceil($totalCount / $limit);

            // Get aspirasi
            $query .= " ORDER BY created_at DESC LIMIT " . (int)$limit . " OFFSET " . (int)$offset;
            $stmt = $this->pdo->prepare($query);
            $stmt->execute($params);
            $allAspirations = $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];

            // Get stats
            $statsQuery = "SELECT 
                COUNT(*) as total,
                SUM(CASE WHEN status = 'Pending' THEN 1 ELSE 0 END) as pending_count,
                SUM(CASE WHEN status = 'Proses' THEN 1 ELSE 0 END) as proses_count,
                SUM(CASE WHEN status = 'Selesai' THEN 1 ELSE 0 END) as selesai_count
            FROM aspirasi";
            $statsStmt = $this->pdo->prepare($statsQuery);
            $statsStmt->execute();
            $stats = $statsStmt->fetch(PDO::FETCH_ASSOC);

            // Prepare data
            $data = [
                'title' => 'Aspirasi',
                'currentPage' => 'aspirations',
                'allAspirations' => $allAspirations,
                'totalCount' => $totalCount,
                'totalPages' => $totalPages,
                'page' => $page,
                'stats' => $stats,
                'status_filter' => $status_filter,
                'kategori_filter' => $kategori_filter,
                'search' => $search,
                'admin' => $this->admin
            ];

            // Render view with layout
            $this->renderLayout('aspirations', $data);

        } catch (Exception $e) {
            error_log('Aspirations controller error: ' . $e->getMessage());
            die('Error loading aspirations: ' . $e->getMessage());
        }
    }
}

?>