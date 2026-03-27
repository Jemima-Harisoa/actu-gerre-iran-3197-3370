<?php
/**
 * Modèle Diffusion (En Direct)
 * États : 'fini', 'en_cours', 'a_predire'
 */
class Diffusion {
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Récupère toutes les diffusions actives/en cours
     */
    public function getActive($limit = 10) {
        $sql = "SELECT * FROM diffusion 
                WHERE status IN ('en_cours', 'a_predire')
                ORDER BY created_at DESC 
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
        $sql = "SELECT * FROM diffusion 
                ORDER BY created_at DESC 
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
        $sql = "SELECT * FROM diffusion WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère les diffusions par statut
     */
    public function getByStatus($status) {
        $sql = "SELECT * FROM diffusion 
                WHERE status = :status
                ORDER BY created_at DESC";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':status', $status);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Ajoute une nouvelle diffusion
     * @param string $title Titre de la diffusion
     * @param string $status 'en_cours', 'fini', 'a_predire'
     */
    public function create($title, $status = 'en_cours') {
        $sql = "INSERT INTO diffusion (title, status, created_at, updated_at)
                VALUES (:title, :status, NOW(), NOW())";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':status', $status);
        
        return $stmt->execute();
    }

    /**
     * Met à jour une diffusion
     */
    public function update($id, $data) {
        $sql = "UPDATE diffusion SET 
                title = :title,
                status = :status,
                updated_at = NOW()
                WHERE id = :id";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':title', $data['title']);
        $stmt->bindParam(':status', $data['status']);
        
        return $stmt->execute();
    }

    /**
     * Change le statut d'une diffusion
     */
    public function updateStatus($id, $status) {
        $sql = "UPDATE diffusion SET status = :status, updated_at = NOW() WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':status', $status);
        
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
