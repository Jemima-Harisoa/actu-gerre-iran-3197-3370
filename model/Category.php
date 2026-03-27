<?php
/**
 * Modèle Category (Rubrique)
 */
class Category {
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Récupère toutes les catégories
     */
    public function getAll() {
        $sql = "SELECT * FROM categories ORDER BY name ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère une catégorie par ID
     */
    public function getById($id) {
        $sql = "SELECT * FROM categories WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère une catégorie par slug
     */
    public function getBySlug($slug) {
        $sql = "SELECT * FROM categories WHERE slug = :slug";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':slug', $slug);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Ajoute une nouvelle catégorie
     */
    public function create($name, $slug) {
        $sql = "INSERT INTO categories (name, slug) VALUES (:name, :slug)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':slug', $slug);
        
        return $stmt->execute();
    }

    /**
     * Met à jour une catégorie
     */
    public function update($id, $name, $slug) {
        $sql = "UPDATE categories SET name = :name, slug = :slug WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':slug', $slug);
        
        return $stmt->execute();
    }

    /**
     * Supprime une catégorie
     */
    public function delete($id) {
        $sql = "DELETE FROM categories WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    /**
     * Récupère le nombre d'articles par catégorie
     */
    public function getArticleCount($id) {
        $sql = "SELECT COUNT(*) as count FROM articles WHERE category_id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'];
    }
}
?>
