<?php

// vocational/app/Models/AspirationReport.php

require_once __DIR__ . '/../Config/Database.php';

class AspirationReport
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::getConnection();
    }

    /**
     * Add report for aspirasi
     */
    public function addReport($id_aspirasi, $npm, $reason, $message = null)
    {
        try {
            $query = "INSERT INTO aspirasi_reports (id_aspirasi, npm_reporter, reason, message, status) 
                      VALUES (?, ?, ?, ?, 'pending')";
            $stmt = $this->pdo->prepare($query);
            return $stmt->execute([$id_aspirasi, $npm, $reason, $message]);
        } catch (PDOException $e) {
            // Duplicate report or other errors
            throw $e;
        }
    }

    /**
     * Check if user has already reported this aspirasi
     */
    public function hasUserReported($id_aspirasi, $npm)
    {
        $query = "SELECT COUNT(*) as count FROM aspirasi_reports 
                  WHERE id_aspirasi = ? AND npm_reporter = ? AND status = 'pending'";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$id_aspirasi, $npm]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $result['count'] > 0;
    }

    /**
     * Get total pending reports for aspirasi
     */
    public function getPendingReportCount($id_aspirasi)
    {
        $query = "SELECT COUNT(*) as count FROM aspirasi_reports 
                  WHERE id_aspirasi = ? AND status = 'pending'";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$id_aspirasi]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $result['count'] ?? 0;
    }

    /**
     * Get all reports for aspirasi
     */
    public function getReports($id_aspirasi, $status = null, $limit = 50, $offset = 0)
    {
        $query = "SELECT 
                    id_report,
                    id_aspirasi,
                    reason,
                    message,
                    status,
                    created_at
                  FROM aspirasi_reports
                  WHERE id_aspirasi = ?";
        
        $params = [$id_aspirasi];

        if ($status) {
            $query .= " AND status = ?";
            $params[] = $status;
        }

        $query .= " ORDER BY created_at DESC LIMIT ? OFFSET ?";
        $params[] = $limit;
        $params[] = $offset;

        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get report breakdown by reason
     */
    public function getReportBreakdown($id_aspirasi)
    {
        $query = "SELECT reason, COUNT(*) as count FROM aspirasi_reports 
                  WHERE id_aspirasi = ? AND status = 'pending'
                  GROUP BY reason";
        
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$id_aspirasi]);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Update report status (for admin)
     */
    public function updateStatus($id_report, $status)
    {
        $query = "UPDATE aspirasi_reports SET status = ? WHERE id_report = ?";
        $stmt = $this->pdo->prepare($query);
        return $stmt->execute([$status, $id_report]);
    }

    /**
     * Get top reported aspirasi (for analytics)
     */
    public function getMostReportedAspirations($limit = 10)
    {
        $query = "SELECT 
                    a.id_aspirasi,
                    a.judul,
                    COUNT(ar.id_report) as total_reports
                  FROM aspirasi a
                  LEFT JOIN aspirasi_reports ar ON a.id_aspirasi = ar.id_aspirasi
                  WHERE ar.status = 'pending'
                  GROUP BY a.id_aspirasi
                  ORDER BY total_reports DESC
                  LIMIT ?";
        
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$limit]);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get all pending reports (for admin dashboard)
     */
    public function getAllPendingReports($limit = 50, $offset = 0)
    {
        $query = "SELECT 
                    ar.id_report,
                    ar.id_aspirasi,
                    a.judul,
                    a.kategori,
                    ar.reason,
                    ar.message,
                    ar.created_at,
                    COUNT(DISTINCT ar2.id_report) as similar_reports
                  FROM aspirasi_reports ar
                  JOIN aspirasi a ON ar.id_aspirasi = a.id_aspirasi
                  LEFT JOIN aspirasi_reports ar2 ON ar.id_aspirasi = ar2.id_aspirasi 
                    AND ar2.status = 'pending'
                  WHERE ar.status = 'pending'
                  GROUP BY ar.id_report
                  ORDER BY ar.created_at DESC
                  LIMIT ? OFFSET ?";
        
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$limit, $offset]);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}