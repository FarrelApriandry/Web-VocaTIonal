<?php

// Import Models
require_once __DIR__ . '/../Models/Aspirasi.php';
require_once __DIR__ . '/../Models/AspirationReaction.php';
require_once __DIR__ . '/../Models/AspirationReport.php';

class AspirationController
{
    private $aspirasi;
    private $reaction;
    private $report;

    public function __construct()
    {
        $this->aspirasi = new Aspirasi();
        $this->reaction = new AspirationReaction();
        $this->report = new AspirationReport();
    }

    /**
     * Submit new aspiration
     * @param string $npm - Student NPM
     * @param string $judul - Aspiration title
     * @param string $deskripsi - Aspiration description
     * @param string $kategori - Category (Akademik, Fasilitas, etc)
     * @param bool $anonim - Anonymous flag
     * @param bool $showOnBoard - Show on bulletin board flag
     * @return array - Response with result
     */
    public function submitAspiration($npm, $judul, $deskripsi, $kategori, $anonim = false, $showOnBoard = false)
    {
        try {
            // Validate inputs
            if (!$npm || !trim($judul) || !trim($deskripsi) || !$kategori) {
                return [
                    'success' => false,
                    'message' => 'Data tidak lengkap'
                ];
            }

            // Validate category
            $validCategories = ['Akademik', 'Fasilitas', 'Sarpras', 'Layanan', 'UKT', 'Lainnya'];
            if (!in_array($kategori, $validCategories)) {
                return [
                    'success' => false,
                    'message' => 'Kategori tidak valid'
                ];
            }

            // Handle anonymous submission
            if ($anonim === true) {
                $npm = "anonim";
            }

            // Trim inputs
            $judul = trim(substr($judul, 0, 255));
            $deskripsi = trim(substr($deskripsi, 0, 5000));

            // Create aspiration in database
            $result = $this->aspirasi->create($npm, $judul, $deskripsi, $kategori, $anonim, $showOnBoard);

            if (!$result) {
                return [
                    'success' => false,
                    'message' => 'Gagal menyimpan aspirasi'
                ];
            }

            return [
                'success' => true,
                'message' => 'Aspirasi berhasil dikirim!',
                'data' => [
                    'judul' => $judul,
                    'kategori' => $kategori,
                    'anonim' => $anonim,
                    'showOnBoard' => $showOnBoard
                ]
            ];
        } catch (\Exception $e) {
            error_log('Submit aspiration error: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Error menyimpan aspirasi',
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Get user aspirations
     * @param string $npm - Student NPM
     * @param int $limit - Query limit
     * @param int $offset - Query offset
     * @return array - User aspirations
     */
    public function getUserAspirations($npm, $limit = 50, $offset = 0)
    {
        try {
            return $this->aspirasi->getByNpm($npm, $limit, $offset);
        } catch (\Exception $e) {
            error_log('Get user aspirations error: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Get aspiration by ID
     * @param int $id - Aspiration ID
     * @return array|null - Aspiration data
     */
    public function getAspirationById($id)
    {
        try {
            return $this->aspirasi->getById($id);
        } catch (\Exception $e) {
            error_log('Get aspiration by ID error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Get board aspirations (public)
     * @param string $category - Filter by category
     * @param int $limit - Query limit
     * @param int $offset - Query offset
     * @return array - Board aspirations
     */
    public function getBoardAspirations($category = null, $limit = 50, $offset = 0)
    {
        try {
            return $this->aspirasi->getBoardAspirations($category, $limit, $offset);
        } catch (\Exception $e) {
            error_log('Get board aspirations error: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Toggle reaction (like/unlike)
     * @param int $id_aspirasi - Aspiration ID
     * @param string $npm - Student NPM
     * @param string $reactionType - Type of reaction (default: 'like')
     * @return array - Response
     */
    public function toggleReaction($id_aspirasi, $npm, $reactionType = 'like')
    {
        try {
            $result = $this->reaction->toggleReaction($id_aspirasi, $npm, $reactionType);

            if (!$result) {
                return [
                    'success' => false,
                    'message' => 'Gagal toggle reaction'
                ];
            }

            $reactionCount = $this->reaction->getReactionCount($id_aspirasi, $reactionType);

            return [
                'success' => true,
                'message' => 'Reaction toggled',
                'reaction_count' => $reactionCount
            ];
        } catch (\Exception $e) {
            error_log('Toggle reaction error: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Error toggle reaction',
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Check if user has reacted
     * @param int $id_aspirasi - Aspiration ID
     * @param string $npm - Student NPM
     * @return bool - Has reacted
     */
    public function hasUserReacted($id_aspirasi, $npm)
    {
        try {
            return $this->reaction->hasReacted($id_aspirasi, $npm);
        } catch (\Exception $e) {
            error_log('Check user reaction error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Get total reactions for aspiration
     * @param int $id_aspirasi - Aspiration ID
     * @return int - Total reactions
     */
    public function getTotalReactions($id_aspirasi)
    {
        try {
            return $this->reaction->getReactionCount($id_aspirasi);
        } catch (\Exception $e) {
            error_log('Get total reactions error: ' . $e->getMessage());
            return 0;
        }
    }

    /**
     * Report aspiration
     * @param int $id_aspirasi - Aspiration ID
     * @param string $npm - Reporter NPM
     * @param string $reason - Report reason
     * @param string $message - Additional message
     * @return array - Response
     */
    public function reportAspiration($id_aspirasi, $npm, $reason, $message = null)
    {
        try {
            // Check if already reported
            if ($this->report->hasUserReported($id_aspirasi, $npm)) {
                return [
                    'success' => false,
                    'message' => 'Anda sudah melaporkan aspirasi ini'
                ];
            }

            // Validate reason
            $validReasons = ['inappropriate', 'spam', 'offensive'];
            if (!in_array($reason, $validReasons)) {
                return [
                    'success' => false,
                    'message' => 'Alasan laporan tidak valid'
                ];
            }

            $result = $this->report->addReport($id_aspirasi, $npm, $reason, $message);

            if (!$result) {
                return [
                    'success' => false,
                    'message' => 'Gagal menyimpan laporan'
                ];
            }

            return [
                'success' => true,
                'message' => 'Laporan berhasil dikirim'
            ];
        } catch (\Exception $e) {
            error_log('Report aspiration error: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Error menyimpan laporan',
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Check if user has reported
     * @param int $id_aspirasi - Aspiration ID
     * @param string $npm - Student NPM
     * @return bool - Has reported
     */
    public function hasUserReported($id_aspirasi, $npm)
    {
        try {
            return $this->report->hasUserReported($id_aspirasi, $npm);
        } catch (\Exception $e) {
            error_log('Check user report error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Get total reports for aspiration
     * @param int $id_aspirasi - Aspiration ID
     * @return int - Total reports
     */
    public function getTotalReports($id_aspirasi)
    {
        try {
            return $this->report->getPendingReportCount($id_aspirasi);
        } catch (\Exception $e) {
            error_log('Get total reports error: ' . $e->getMessage());
            return 0;
        }
    }
}