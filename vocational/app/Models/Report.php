<?php

// vocational/app/Models/Report.php

namespace App\Models;

require_once __DIR__ . '/../Config/Database.php';

/**
 * Report Model
 * Handles aspiration report data and operations
 */
class Report
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = \Database::getConnection();
    }

    /**
     * Submit a new report on an aspiration
     * 
     * @param int $id_aspirasi Aspiration ID
     * @param string $npm_reporter Reporter NPM (from whitelist)
     * @param string $reason Report reason (inappropriate, spam, offensive)
     * @param string|null $message Optional report message
     * @return bool|array success flag or inserted ID
     */
    public function submitReport($id_aspirasi, $npm_reporter, $reason, $message = null)
    {
        try {
            // Check if aspiration exists and is on bulletin board
            $aspirationCheck = $this->pdo->prepare("
                SELECT id_aspirasi, show_on_board 
                FROM aspirasi 
                WHERE id_aspirasi = ? AND show_on_board = 1
            ");
            $aspirationCheck->execute([$id_aspirasi]);
            
            if ($aspirationCheck->rowCount() === 0) {
                return [
                    'success' => false,
                    'message' => 'Aspiration not found or not on bulletin board'
                ];
            }

            // Check if reporter npm exists in whitelist
            $reporterCheck = $this->pdo->prepare("
                SELECT npm FROM mhs_whitelist WHERE npm = ?
            ");
            $reporterCheck->execute([$npm_reporter]);
            
            if ($reporterCheck->rowCount() === 0) {
                return [
                    'success' => false,
                    'message' => 'Reporter not found in whitelist'
                ];
            }

            // Check for duplicate report from same user on same aspiration
            $duplicateCheck = $this->pdo->prepare("
                SELECT id_report FROM aspirasi_reports 
                WHERE id_aspirasi = ? AND npm_reporter = ?
            ");
            $duplicateCheck->execute([$id_aspirasi, $npm_reporter]);
            
            if ($duplicateCheck->rowCount() > 0) {
                return [
                    'success' => false,
                    'message' => 'You have already reported this aspiration'
                ];
            }

            // Insert new report (default status: pending)
            $stmt = $this->pdo->prepare("
                INSERT INTO aspirasi_reports (id_aspirasi, npm_reporter, reason, message, status)
                VALUES (?, ?, ?, ?, 'pending')
            ");
            
            $stmt->execute([$id_aspirasi, $npm_reporter, $reason, $message]);
            
            return [
                'success' => true,
                'report_id' => $this->pdo->lastInsertId(),
                'message' => 'Report submitted successfully'
            ];
        } catch (\PDOException $e) {
            return [
                'success' => false,
                'message' => 'Database error: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Get all reports with optional filtering
     * 
     * @param array $filters [status, reason, sort, limit, offset]
     * @return array Reports list
     */
    public function getReports($filters = [])
    {
        try {
            $query = "
                SELECT 
                    ar.id_report,
                    ar.id_aspirasi,
                    ar.npm_reporter,
                    ar.reason,
                    ar.message,
                    ar.status,
                    ar.created_at,
                    ar.updated_at,
                    asp.judul,
                    asp.kategori,
                    mhs.nama as reporter_name
                FROM aspirasi_reports ar
                JOIN aspirasi asp ON ar.id_aspirasi = asp.id_aspirasi
                JOIN mhs_whitelist mhs ON ar.npm_reporter = mhs.npm
                WHERE 1=1
            ";
            
            $params = [];
            
            // Apply status filter
            if (!empty($filters['status'])) {
                $query .= " AND ar.status = ?";
                $params[] = $filters['status'];
            }
            
            // Apply reason filter
            if (!empty($filters['reason'])) {
                $query .= " AND ar.reason = ?";
                $params[] = $filters['reason'];
            }
            
            // Apply sorting
            $sort = $filters['sort'] ?? 'created_at';
            $sortDirection = $filters['sort_direction'] ?? 'DESC';
            $allowedSorts = ['created_at', 'id_report', 'status', 'reason'];
            
            if (in_array($sort, $allowedSorts)) {
                $query .= " ORDER BY ar.$sort $sortDirection";
            }
            
            // Apply limit and offset for pagination
            $limit = (int)($filters['limit'] ?? 20);
            $offset = (int)($filters['offset'] ?? 0);
            $query .= " LIMIT $limit OFFSET $offset";
            
            $stmt = $this->pdo->prepare($query);
            $stmt->execute($params);
            
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return [];
        }
    }

    /**
     * Get report count with optional filtering
     * 
     * @param array $filters [status, reason]
     * @return int Total count
     */
    public function getReportCount($filters = [])
    {
        try {
            $query = "SELECT COUNT(*) as count FROM aspirasi_reports WHERE 1=1";
            $params = [];
            
            if (!empty($filters['status'])) {
                $query .= " AND status = ?";
                $params[] = $filters['status'];
            }
            
            if (!empty($filters['reason'])) {
                $query .= " AND reason = ?";
                $params[] = $filters['reason'];
            }
            
            $stmt = $this->pdo->prepare($query);
            $stmt->execute($params);
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);
            
            return (int)$result['count'];
        } catch (\PDOException $e) {
            return 0;
        }
    }

    /**
     * Get single report detail with aspiration info
     * 
     * @param int $id_report Report ID
     * @return array|false Report data or false if not found
     */
    public function getReportDetail($id_report)
    {
        try {
            error_log('[MODEL] getReportDetail called with id: ' . $id_report);
            
            $query = "
                SELECT 
                    ar.id_report,
                    ar.id_aspirasi,
                    ar.npm_reporter,
                    ar.reason,
                    ar.message,
                    ar.status,
                    ar.created_at,
                    ar.updated_at,
                    asp.id_aspirasi,
                    asp.judul,
                    asp.deskripsi,
                    asp.kategori,
                    asp.npm_pelapor,
                    asp.status as aspirasi_status,
                    mhs_reporter.nama as reporter_name,
                    mhs_author.nama as author_name
                FROM aspirasi_reports ar
                JOIN aspirasi asp ON ar.id_aspirasi = asp.id_aspirasi
                JOIN mhs_whitelist mhs_reporter ON ar.npm_reporter = mhs_reporter.npm
                JOIN mhs_whitelist mhs_author ON asp.npm_pelapor = mhs_author.npm
                WHERE ar.id_report = ?
            ";
            error_log('[MODEL] SQL Query prepared');
            
            $stmt = $this->pdo->prepare($query);
            error_log('[MODEL] Query executed with id: ' . $id_report);
            
            $stmt->execute([$id_report]);
            error_log('[MODEL] Execute successful');
            
            $report = $stmt->fetch(\PDO::FETCH_ASSOC);
            error_log('[MODEL] Fetch result: ' . ($report ? 'FOUND' : 'NOT FOUND'));
            error_log('[MODEL] Report data: ' . json_encode($report));
            
            if (!$report) {
                error_log('[MODEL] No report found for id: ' . $id_report);
                return false;
            }
            
            error_log('[MODEL] Returning report successfully');
            return $report;
        } catch (\PDOException $e) {
            error_log('❌ [MODEL] PDOException in getReportDetail: ' . $e->getMessage());
            error_log('❌ [MODEL] Error Code: ' . $e->getCode());
            error_log('❌ [MODEL] File: ' . $e->getFile() . ' Line: ' . $e->getLine());
            error_log('❌ [MODEL] Stack: ' . $e->getTraceAsString());
            return false;
        }
    }

    /**
     * Update report status
     * 
     * @param int $id_report Report ID
     * @param string $new_status New status (confirmed, processing, resolved, dismissed)
     * @param string|null $note Optional admin note
     * @return array success flag and message
     */
    public function updateReportStatus($id_report, $new_status, $note = null)
    {
        try {
            // Validate status
            $validStatuses = ['pending', 'confirmed', 'processing', 'resolved', 'dismissed'];
            
            if (!in_array($new_status, $validStatuses)) {
                return [
                    'success' => false,
                    'message' => 'Invalid status value'
                ];
            }
            
            // Check if report exists
            $checkStmt = $this->pdo->prepare("SELECT id_report FROM aspirasi_reports WHERE id_report = ?");
            $checkStmt->execute([$id_report]);
            
            if ($checkStmt->rowCount() === 0) {
                return [
                    'success' => false,
                    'message' => 'Report not found'
                ];
            }
            
            // Update status
            $stmt = $this->pdo->prepare("
                UPDATE aspirasi_reports 
                SET status = ? 
                WHERE id_report = ?
            ");
            
            $stmt->execute([$new_status, $id_report]);
            
            return [
                'success' => true,
                'message' => 'Report status updated successfully',
                'new_status' => $new_status
            ];
        } catch (\PDOException $e) {
            return [
                'success' => false,
                'message' => 'Database error: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Delete a report
     * 
     * @param int $id_report Report ID
     * @return array success flag and message
     */
    public function deleteReport($id_report)
    {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM aspirasi_reports WHERE id_report = ?");
            $stmt->execute([$id_report]);
            
            if ($stmt->rowCount() === 0) {
                return [
                    'success' => false,
                    'message' => 'Report not found'
                ];
            }
            
            return [
                'success' => true,
                'message' => 'Report deleted successfully'
            ];
        } catch (\PDOException $e) {
            return [
                'success' => false,
                'message' => 'Database error: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Get report statistics for dashboard
     * 
     * @return array Statistics with count per status
     */
    public function getReportStats()
    {
        try {
            $stmt = $this->pdo->prepare("
                SELECT 
                    COUNT(*) as total,
                    SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending,
                    SUM(CASE WHEN status = 'confirmed' THEN 1 ELSE 0 END) as confirmed,
                    SUM(CASE WHEN status = 'processing' THEN 1 ELSE 0 END) as processing,
                    SUM(CASE WHEN status = 'resolved' THEN 1 ELSE 0 END) as resolved,
                    SUM(CASE WHEN status = 'dismissed' THEN 1 ELSE 0 END) as dismissed
                FROM aspirasi_reports
            ");
            
            $stmt->execute();
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);
            
            return [
                'total' => (int)($result['total'] ?? 0),
                'pending' => (int)($result['pending'] ?? 0),
                'confirmed' => (int)($result['confirmed'] ?? 0),
                'processing' => (int)($result['processing'] ?? 0),
                'resolved' => (int)($result['resolved'] ?? 0),
                'dismissed' => (int)($result['dismissed'] ?? 0)
            ];
        } catch (\PDOException $e) {
            return [
                'total' => 0,
                'pending' => 0,
                'confirmed' => 0,
                'processing' => 0,
                'resolved' => 0,
                'dismissed' => 0
            ];
        }
    }

    /**
     * Get reports grouped by reason
     * 
     * @return array Reports count per reason
     */
    public function getReportsByReason()
    {
        try {
            $stmt = $this->pdo->prepare("
                SELECT 
                    reason,
                    COUNT(*) as count
                FROM aspirasi_reports
                GROUP BY reason
            ");
            
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return [];
        }
    }
}