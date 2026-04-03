<?php

// vocational/app/Models/Aspirasi.php

require_once __DIR__ . '/../Config/Database.php';

class Aspirasi
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::getConnection();
    }

    /**
     * Get all aspirasi for bulletin board
     * Always returns anonymized data
     */
    public function getBoardAspirations($category = null, $limit = 50, $offset = 0)
    {
        $query = "SELECT 
                    a.id_aspirasi,
                    a.judul,
                    a.deskripsi,
                    a.kategori,
                    a.created_at,
                    (SELECT COUNT(*) FROM aspirasi_reactions WHERE id_aspirasi = a.id_aspirasi) as total_reactions
                  FROM aspirasi a
                  WHERE a.show_on_board = TRUE AND a.board_approved = TRUE";
        
        $params = [];

        if ($category && $category !== 'all') {
            $query .= " AND a.kategori = ?";
            $params[] = $category;
        }

        $query .= " ORDER BY a.created_at DESC LIMIT " . ((int)$limit) . " OFFSET " . ((int)$offset);

        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get single aspirasi by ID (for board view)
     * Returns anonymized data only
     */
    public function getBoardAspirationById($id)
    {
        $query = "SELECT 
                    a.id_aspirasi,
                    a.judul,
                    a.deskripsi,
                    a.kategori,
                    a.created_at,
                    (SELECT COUNT(*) FROM aspirasi_reactions WHERE id_aspirasi = a.id_aspirasi) as total_reactions
                  FROM aspirasi a
                  WHERE a.id_aspirasi = ? 
                  AND a.show_on_board = TRUE 
                  AND a.board_approved = TRUE
                  AND a.anonim = TRUE";
        
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$id]);
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Get aspirasi by ID (admin/general use)
     */
    public function getById($id)
    {
        $query = "SELECT * FROM aspirasi WHERE id_aspirasi = ?";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$id]);
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Get aspirasi by npm_pelapor (personal history)
     */
    public function getByNpm($npm, $limit = 50, $offset = 0)
    {
        $query = "SELECT * FROM aspirasi WHERE npm_pelapor = ? ORDER BY created_at DESC LIMIT ? OFFSET ?";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$npm, $limit, $offset]);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Create new aspirasi
     */
    public function create($npm, $judul, $deskripsi, $kategori, $anonim = false, $showOnBoard = false)
    {
        $query = "INSERT INTO aspirasi (npm_pelapor, judul, deskripsi, kategori, anonim, show_on_board, status) 
                  VALUES (?, ?, ?, ?, ?, ?, 'Pending')";
        
        $stmt = $this->pdo->prepare($query);
        
        return $stmt->execute([
            $npm,
            $judul,
            $deskripsi,
            $kategori,
            $anonim ? 1 : 0,
            $showOnBoard ? 1 : 0
        ]);
    }

    /**
     * Check if user has already reacted to this aspirasi
     */
    public function hasUserReacted($id_aspirasi, $npm)
    {
        $query = "SELECT COUNT(*) as count FROM aspirasi_reactions WHERE id_aspirasi = ? AND npm_reactor = ?";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$id_aspirasi, $npm]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $result['count'] > 0;
    }

    /**
     * Get total reactions for aspirasi
     */
    public function getTotalReactions($id_aspirasi)
    {
        $query = "SELECT COUNT(*) as count FROM aspirasi_reactions WHERE id_aspirasi = ?";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$id_aspirasi]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $result['count'] ?? 0;
    }

    /**
     * Check if aspirasi has been reported by user
     */
    public function hasUserReported($id_aspirasi, $npm)
    {
        $query = "SELECT COUNT(*) as count FROM aspirasi_reports WHERE id_aspirasi = ? AND npm_reporter = ?";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$id_aspirasi, $npm]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $result['count'] > 0;
    }

    /**
     * Get total reports for aspirasi
     */
    public function getTotalReports($id_aspirasi)
    {
        $query = "SELECT COUNT(*) as count FROM aspirasi_reports WHERE id_aspirasi = ? AND status = 'pending'";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$id_aspirasi]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $result['count'] ?? 0;
    }
}