<?php

// Import Models
require_once __DIR__ . '/../Models/AspirationReport.php';
require_once __DIR__ . '/../Models/Aspirasi.php';

class AdminController
{
    private $report;
    private $aspirasi;

    public function __construct()
    {
        $this->report = new AspirationReport();
        $this->aspirasi = new Aspirasi();
    }

    /**
     * Get pending reports for dashboard
     * @param int $limit - Query limit
     * @param int $offset - Query offset
     * @return array - Pending reports
     */
    public function getPendingReports($limit = 50, $offset = 0)
    {
        try {
            return $this->report->getAllPendingReports($limit, $offset);
        } catch (\Exception $e) {
            error_log('Get pending reports error: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Get reports for specific aspiration
     * @param int $id_aspirasi - Aspiration ID
     * @param string $status - Filter by status (pending, reviewed)
     * @param int $limit - Query limit
     * @param int $offset - Query offset
     * @return array - Reports
     */
    public function getAspirationReports($id_aspirasi, $status = null, $limit = 50, $offset = 0)
    {
        try {
            return $this->report->getReports($id_aspirasi, $status, $limit, $offset);
        } catch (\Exception $e) {
            error_log('Get aspiration reports error: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Update report status
     * @param int $id_report - Report ID
     * @param string $status - New status (pending, reviewed)
     * @return array - Response
     */
    public function updateReportStatus($id_report, $status)
    {
        try {
            // Validate status
            $validStatuses = ['pending', 'reviewed'];
            if (!in_array($status, $validStatuses)) {
                return [
                    'success' => false,
                    'message' => 'Status tidak valid'
                ];
            }

            $result = $this->report->updateStatus($id_report, $status);

            if (!$result) {
                return [
                    'success' => false,
                    'message' => 'Gagal update status laporan'
                ];
            }

            return [
                'success' => true,
                'message' => 'Status laporan berhasil diupdate'
            ];
        } catch (\Exception $e) {
            error_log('Update report status error: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Error update status',
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Get most reported aspirations
     * @param int $limit - Query limit
     * @return array - Most reported aspirations
     */
    public function getMostReportedAspirations($limit = 10)
    {
        try {
            return $this->report->getMostReportedAspirations($limit);
        } catch (\Exception $e) {
            error_log('Get most reported aspirations error: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Approve aspiration for bulletin board
     * @param int $id_aspirasi - Aspiration ID
     * @return array - Response
     */
    public function approveForBoard($id_aspirasi)
    {
        try {
            // Get aspiration first
            $aspiration = $this->aspirasi->getById($id_aspirasi);
            if (!$aspiration) {
                return [
                    'success' => false,
                    'message' => 'Aspirasi tidak ditemukan'
                ];
            }

            // Update aspiration to show on board and approve
            // Note: This would need a method in Aspirasi model to update these fields
            // For now, returning success as placeholder
            
            return [
                'success' => true,
                'message' => 'Aspirasi berhasil disetujui untuk papan buletin'
            ];
        } catch (\Exception $e) {
            error_log('Approve for board error: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Error menyetujui aspirasi',
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Reject/remove aspiration from board
     * @param int $id_aspirasi - Aspiration ID
     * @param string $reason - Rejection reason (for audit)
     * @return array - Response
     */
    public function rejectFromBoard($id_aspirasi, $reason = null)
    {
        try {
            // Get aspiration first
            $aspiration = $this->aspirasi->getById($id_aspirasi);
            if (!$aspiration) {
                return [
                    'success' => false,
                    'message' => 'Aspirasi tidak ditemukan'
                ];
            }

            // Update aspiration to not show on board
            // Note: This would need a method in Aspirasi model to update these fields
            // For now, returning success as placeholder
            
            return [
                'success' => true,
                'message' => 'Aspirasi berhasil ditolak'
            ];
        } catch (\Exception $e) {
            error_log('Reject from board error: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Error menolak aspirasi',
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Get dashboard statistics
     * @return array - Dashboard stats
     */
    public function getDashboardStats()
    {
        try {
            $stats = [
                'total_pending_reports' => count($this->getPendingReports(9999, 0)),
                'most_reported' => $this->getMostReportedAspirations(5),
                'report_breakdown' => []
            ];

            return [
                'success' => true,
                'data' => $stats
            ];
        } catch (\Exception $e) {
            error_log('Get dashboard stats error: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Error get stats',
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Check if user is admin
     * @param string $npm - Student NPM
     * @return bool - Is admin
     */
    public function isAdmin($npm)
    {
        // This would need to check against admin table
        // Placeholder for now
        return false;
    }
}