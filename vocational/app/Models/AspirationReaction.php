<?php

// vocational/app/Models/AspirationReaction.php

require_once __DIR__ . '/../Config/Database.php';

class AspirationReaction
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::getConnection();
    }

    /**
     * Add reaction (like) to aspirasi
     * Returns true if added, false if already exists
     */
    public function addReaction($id_aspirasi, $npm, $reaction_type = 'like')
    {
        try {
            $query = "INSERT INTO aspirasi_reactions (id_aspirasi, npm_reactor, reaction_type) 
                      VALUES (?, ?, ?)";
            $stmt = $this->pdo->prepare($query);
            return $stmt->execute([$id_aspirasi, $npm, $reaction_type]);
        } catch (PDOException $e) {
            // Unique constraint violation - already reacted
            if ($e->getCode() == 23000) {
                return false;
            }
            throw $e;
        }
    }

    /**
     * Remove reaction (unlike) from aspirasi
     */
    public function removeReaction($id_aspirasi, $npm)
    {
        $query = "DELETE FROM aspirasi_reactions WHERE id_aspirasi = ? AND npm_reactor = ?";
        $stmt = $this->pdo->prepare($query);
        return $stmt->execute([$id_aspirasi, $npm]);
    }

    /**
     * Toggle reaction - add if not exists, remove if exists
     */
    public function toggleReaction($id_aspirasi, $npm, $reaction_type = 'like')
    {
        if ($this->hasReacted($id_aspirasi, $npm)) {
            return $this->removeReaction($id_aspirasi, $npm);
        } else {
            return $this->addReaction($id_aspirasi, $npm, $reaction_type);
        }
    }

    /**
     * Check if user has reacted to aspirasi
     */
    public function hasReacted($id_aspirasi, $npm)
    {
        $query = "SELECT COUNT(*) as count FROM aspirasi_reactions WHERE id_aspirasi = ? AND npm_reactor = ?";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$id_aspirasi, $npm]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $result['count'] > 0;
    }

    /**
     * Get total reactions count for aspirasi
     */
    public function getReactionCount($id_aspirasi, $reaction_type = null)
    {
        $query = "SELECT COUNT(*) as count FROM aspirasi_reactions WHERE id_aspirasi = ?";
        $params = [$id_aspirasi];

        if ($reaction_type) {
            $query .= " AND reaction_type = ?";
            $params[] = $reaction_type;
        }

        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $result['count'] ?? 0;
    }

    /**
     * Get all reactions for aspirasi with user details (anonymized)
     */
    public function getReactions($id_aspirasi, $limit = 50, $offset = 0)
    {
        $query = "SELECT 
                    ar.id_reaction,
                    ar.id_aspirasi,
                    ar.reaction_type,
                    ar.created_at
                  FROM aspirasi_reactions ar
                  WHERE ar.id_aspirasi = ?
                  ORDER BY ar.created_at DESC
                  LIMIT ? OFFSET ?";
        
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$id_aspirasi, $limit, $offset]);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get breakdown of reactions by type
     */
    public function getReactionBreakdown($id_aspirasi)
    {
        $query = "SELECT reaction_type, COUNT(*) as count FROM aspirasi_reactions 
                  WHERE id_aspirasi = ? GROUP BY reaction_type";
        
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$id_aspirasi]);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get trending aspirasi by reactions
     */
    public function getTrendingAspirations($limit = 10)
    {
        $query = "SELECT 
                    a.id_aspirasi,
                    a.judul,
                    a.deskripsi,
                    a.kategori,
                    a.created_at,
                    COUNT(ar.id_reaction) as total_reactions
                  FROM aspirasi a
                  LEFT JOIN aspirasi_reactions ar ON a.id_aspirasi = ar.id_aspirasi
                  WHERE a.show_on_board = TRUE AND a.board_approved = TRUE
                  GROUP BY a.id_aspirasi
                  ORDER BY total_reactions DESC, a.created_at DESC
                  LIMIT ?";
        
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$limit]);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}