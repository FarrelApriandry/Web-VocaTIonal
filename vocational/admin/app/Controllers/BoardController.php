<?php
// vocational/admin/app/Controllers/BoardController.php

require_once __DIR__ . '/AdminBaseController.php';

class BoardController extends AdminBaseController {

    public function index() {
        try {
            // Get filters from query parameters
            $kategori_filter = $_GET['kategori'] ?? '';
            $page = max(1, (int)($_GET['page'] ?? 1));
            $limit = 20;
            $offset = ($page - 1) * $limit;

            // Build query for board aspirations
            $query = "SELECT 
                a.id_aspirasi,
                a.judul,
                a.deskripsi,
                a.kategori,
                a.created_at,
                a.show_on_board,
                a.board_approved,
                COUNT(ar.id_reaction) as total_reactions
            FROM aspirasi a
            LEFT JOIN aspirasi_reactions ar ON a.id_aspirasi = ar.id_aspirasi
            WHERE 1=1";

            $params = [];

            if (!empty($kategori_filter)) {
                $query .= " AND a.kategori = ?";
                $params[] = $kategori_filter;
            }

            $query .= " GROUP BY a.id_aspirasi ORDER BY a.created_at DESC LIMIT " . (int)$limit . " OFFSET " . (int)$offset;

            // Get board aspirations
            $stmt = $this->pdo->prepare($query);
            $stmt->execute($params);
            $allAspirations = $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];

            // Count total for pagination
            $countQuery = "SELECT COUNT(DISTINCT a.id_aspirasi) as total FROM aspirasi a
                          WHERE 1=1";

            if (!empty($kategori_filter)) {
                $countQuery .= " AND a.kategori = ?";
            }

            $countStmt = $this->pdo->prepare($countQuery);
            $countStmt->execute($params);
            $totalCount = $countStmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;
            $totalPages = ceil($totalCount / $limit);

            // Get stats
            $statsQuery = "SELECT 
                COUNT(*) as total_aspirations,
                SUM(CASE WHEN show_on_board = 1 AND board_approved = 1 THEN 1 ELSE 0 END) as approved_on_board,
                SUM(CASE WHEN show_on_board = 1 AND board_approved = 0 THEN 1 ELSE 0 END) as pending_approval
            FROM aspirasi";
            
            $statsStmt = $this->pdo->prepare($statsQuery);
            $statsStmt->execute();
            $stats = $statsStmt->fetch(PDO::FETCH_ASSOC);

            // Prepare data
            $data = [
                'title' => 'Papan Buletin',
                'currentPage' => 'board',
                'allAspirations' => $allAspirations,
                'totalCount' => $totalCount,
                'totalPages' => $totalPages,
                'page' => $page,
                'stats' => $stats,
                'kategori_filter' => $kategori_filter,
                'admin' => $this->admin
            ];

            // Render view with layout
            $this->renderLayout('board', $data);

        } catch (Exception $e) {
            error_log('Board controller error: ' . $e->getMessage());
            die('Error loading board: ' . $e->getMessage());
        }
    }
}

?>