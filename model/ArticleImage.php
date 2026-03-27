<?php
/**
 * Modèle ArticleImage (Images multiples par article)
 */
class ArticleImage {
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Récupère toutes les images d'un article
     */
    public function getByArticle($article_id) {
        $sql = "SELECT * FROM article_images 
                WHERE article_id = :article_id 
                ORDER BY position ASC";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':article_id', $article_id, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Ajoute une image à un article
     */
    public function create($article_id, $image_url, $caption = '', $position = 0) {
        $sql = "INSERT INTO article_images (article_id, image_url, caption, position)
                VALUES (:article_id, :image_url, :caption, :position)";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':article_id', $article_id);
        $stmt->bindParam(':image_url', $image_url);
        $stmt->bindParam(':caption', $caption);
        $stmt->bindParam(':position', $position);
        
        return $stmt->execute();
    }

    /**
     * Supprime une image
     */
    public function delete($id) {
        $sql = "DELETE FROM article_images WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    /**
     * Supprime toutes les images d'un article
     */
    public function deleteByArticle($article_id) {
        $sql = "DELETE FROM article_images WHERE article_id = :article_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':article_id', $article_id);
        return $stmt->execute();
    }
}
?>
