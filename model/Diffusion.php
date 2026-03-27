<?php
/**
 * Modèle Diffusion (En Direct)
 * États : 'en_cours' (1), 'fini' (2), 'a_predire' (3)
 */
class Diffusion {
    private $pdo;
    
    // Mapping des statuts nom -> ID
    const STATUS_MAP = [
        'en_cours' => 1,
        'fini' => 2,
        'a_predire' => 3
    ];
    
    // Mapping inverse ID -> nom
    const STATUS_REVERSE_MAP = [
        1 => 'en_cours',
        2 => 'fini',
        3 => 'a_predire'
    ];
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Obtient l'ID d'un statut par son nom
     */
    private function getStatusId($statusName) {
        return self::STATUS_MAP[$statusName] ?? 1; // Default to 'en_cours'
    }

    /**
     * Récupère toutes les diffusions actives/en cours
     */
    public function getActive($limit = 10) {
        $sql = "SELECT d.*, s.name as status_name FROM diffusion d
                LEFT JOIN statuts s ON d.status_id = s.id
                WHERE d.status_id IN (1, 3)
                ORDER BY d.created_at DESC 
                LIMIT :limit";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère toutes les diffusions
     */
    public function getAll($limit = 20) {
        $sql = "SELECT d.*, s.name as status_name FROM diffusion d
                LEFT JOIN statuts s ON d.status_id = s.id
                ORDER BY d.created_at DESC 
                LIMIT :limit";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère une diffusion par ID
     */
    public function getById($id) {
        $sql = "SELECT d.*, s.name as status_name FROM diffusion d
                LEFT JOIN statuts s ON d.status_id = s.id
                WHERE d.id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère les diffusions par statut
     * @param mixed $status Nom du statut ('en_cours', 'fini', 'a_predire') ou ID (1, 2, 3)
     */
    public function getByStatus($status) {
        // Si c'est un string, convertir en ID
        if (is_string($status)) {
            $statusId = $this->getStatusId($status);
        } else {
            $statusId = (int)$status;
        }
        
        $sql = "SELECT d.*, s.name as status_name FROM diffusion d
                LEFT JOIN statuts s ON d.status_id = s.id
                WHERE d.status_id = :status_id
                ORDER BY d.created_at DESC";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':status_id', $statusId, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Ajoute une nouvelle diffusion
     * @param string $title Titre de la diffusion
     * @param string $status 'en_cours', 'fini', 'a_predire' (optionnel, défaut: 'en_cours')
     */
    public function create($title, $status = 'en_cours') {
        $statusId = $this->getStatusId($status);
        
        $sql = "INSERT INTO diffusion (title, status_id, created_at, updated_at)
                VALUES (:title, :status_id, NOW(), NOW())";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':status_id', $statusId, PDO::PARAM_INT);
        
        return $stmt->execute();
    }

    /**
     * Met à jour une diffusion
     * @param int $id ID de la diffusion
     * @param array $data Données à mettre à jour (title, status)
     */
    public function update($id, $data) {
        $statusId = isset($data['status']) ? $this->getStatusId($data['status']) : null;
        
        if ($statusId !== null) {
            $sql = "UPDATE diffusion SET 
                    title = :title,
                    status_id = :status_id,
                    updated_at = NOW()
                    WHERE id = :id";
        } else {
            $sql = "UPDATE diffusion SET 
                    title = :title,
                    updated_at = NOW()
                    WHERE id = :id";
        }
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':title', $data['title']);
        
        if ($statusId !== null) {
            $stmt->bindParam(':status_id', $statusId, PDO::PARAM_INT);
        }
        
        return $stmt->execute();
    }

    /**
     * Change le statut d'une diffusion
     * @param int $id ID de la diffusion
     * @param string $status Nom du statut ou ID
     */
    public function updateStatus($id, $status) {
        $statusId = is_string($status) ? $this->getStatusId($status) : (int)$status;
        
        $sql = "UPDATE diffusion SET status_id = :status_id, updated_at = NOW() WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':status_id', $statusId, PDO::PARAM_INT);
        
        return $stmt->execute();
    }

    /**
     * Supprime une diffusion
     */
    public function delete($id) {
        $sql = "DELETE FROM diffusion WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>
