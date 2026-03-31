<?php
/**
 * Modèle Article
 */
class Article {
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Récupère tous les articles d'une catégorie
     */
    public function getByCategory($category_id, $limit = 10, $offset = 0) {
        $sql = "SELECT a.*, c.name as category_name FROM articles a
                LEFT JOIN categories c ON a.category_id = c.id
                WHERE a.category_id = :category_id 
                ORDER BY a.published_at DESC 
                LIMIT :offset, :limit";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère un article par ID
     */
    public function getById($article_id) {
        $sql = "SELECT a.*, c.name as category_name FROM articles a
                LEFT JOIN categories c ON a.category_id = c.id
                WHERE a.id = :id";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $article_id, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère les articles "à la une" (featured)
     */
    public function getFeatured($limit = 3) {
        $sql = "SELECT a.*, c.name as category_name FROM articles a
                LEFT JOIN categories c ON a.category_id = c.id
                WHERE a.is_featured = 1
                ORDER BY a.published_at DESC 
                LIMIT :limit";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère tous les articles avec pagination
     */
    public function getAll($limit = 9, $offset = 0) {
        $sql = "SELECT a.*, c.name as category_name FROM articles a
                LEFT JOIN categories c ON a.category_id = c.id
                ORDER BY a.published_at DESC 
                LIMIT :offset, :limit";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Ajoute un nouvel article
     */
    public function create($data) {
        $sql = "INSERT INTO articles (category_id, title, description, content, author, image_url, is_featured, published_at, updated_at)
                VALUES (:category_id, :title, :description, :content, :author, :image_url, :is_featured, :published_at, NOW())";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':category_id', $data['category_id']);
        $stmt->bindParam(':title', $data['title']);
        $stmt->bindParam(':description', $data['description']);
        $stmt->bindParam(':content', $data['content']);
        $stmt->bindParam(':author', $data['author']);
        $stmt->bindParam(':image_url', $data['image_url']);
        $stmt->bindParam(':is_featured', $data['is_featured']);
        $stmt->bindParam(':published_at', $data['published_at']);
        
        $stmt->execute();
        return (int) $this->pdo->lastInsertId(); // retourne l'ID ou 0 si échec
    }

    /**
     * Met à jour un article
     */
    public function update($id, $data) {
        $sql = "UPDATE articles SET 
                category_id = :category_id,
                title = :title,
                description = :description,
                content = :content,
                author = :author,
                image_url = :image_url,
                is_featured = :is_featured,
                published_at = :published_at,
                updated_at = NOW()
                WHERE id = :id";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':category_id', $data['category_id']);
        $stmt->bindParam(':title', $data['title']);
        $stmt->bindParam(':description', $data['description']);
        $stmt->bindParam(':content', $data['content']);
        $stmt->bindParam(':author', $data['author']);
        $stmt->bindParam(':image_url', $data['image_url']);
        $stmt->bindParam(':is_featured', $data['is_featured']);
        $stmt->bindParam(':published_at', $data['published_at']);
        
        return $stmt->execute();
    }

    /**
     * Supprime un article
     */
    public function delete($id) {
        $sql = "DELETE FROM articles WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    /**
     * Recherche des articles par mot-clé
     */
    public function search($searchTerm, $limit = 10, $offset = 0) {
        $sql = "SELECT a.*, c.name as category_name FROM articles a
                LEFT JOIN categories c ON a.category_id = c.id
                WHERE a.title LIKE :searchTerm
                   OR a.description LIKE :searchTerm
                   OR a.content LIKE :searchTerm
                ORDER BY a.published_at DESC
                LIMIT :offset, :limit";
        
        $stmt = $this->pdo->prepare($sql);
        $likeSearchTerm = '%' . $searchTerm . '%';
        $stmt->bindParam(':searchTerm', $likeSearchTerm);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
