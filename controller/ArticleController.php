<?php
/**
 * Contrôleur Article
 */
require_once __DIR__ . '/../model/Article.php';
require_once __DIR__ . '/../model/Category.php';
require_once __DIR__ . '/../model/ArticleImage.php';

class ArticleController {
    private $article;
    private $category;
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->article = new Article($pdo);
        $this->category = new Category($pdo);
    }

    /**
     * Affiche la liste des articles par catégorie
     */
    public function listByCategory($category_slug, $page = 1) {
        // Valider et sanitizer le numéro de page
        $page = max(1, (int)$page);
        
        $category = $this->category->getBySlug($category_slug);
        
        if (!$category) {
            return ['error' => 'Catégorie non trouvée'];
        }

        $limit = 9;
        $offset = ($page - 1) * $limit;
        
        $articles = $this->article->getByCategory($category['id'], $limit, $offset);
        
        return [
            'articles' => $articles,
            'category' => $category,
            'page' => $page
        ];
    }

    /**
     * Affiche un article spécifique avec toutes les données associées
     */
    public function view($article_id) {
        $article = $this->article->getById($article_id);
        
        if (!$article) {
            return ['error' => 'Article non trouvé'];
        }

        // Récupérer les images de l'article
        $imageModel = new ArticleImage($this->pdo);
        $images = $imageModel->getByArticle($article_id);

        // Récupérer les autres articles (maximum 3)
        $allArticles = $this->article->getAll(100);
        $otherArticles = array_filter($allArticles, function($a) use ($article_id) {
            return $a['id'] != $article_id;
        });
        $otherArticles = array_slice($otherArticles, 0, 3);

        return [
            'article' => $article,
            'images' => $images,
            'otherArticles' => $otherArticles
        ];
    }

    /**
     * Affiche les articles "à la une" (featured)
     */
    public function featured($limit = 3) {
        $articles = $this->article->getFeatured($limit);
        return ['articles' => $articles];
    }

    /**
     * Affiche tous les articles
     */
    public function index($page = 1) {
        // Valider et sanitizer le numéro de page
        $page = max(1, (int)$page);
        
        $limit = 9;
        $offset = ($page - 1) * $limit;
        
        $articles = $this->article->getAll($limit, $offset);
        $categories = $this->category->getAll();
        
        return [
            'articles' => $articles,
            'categories' => $categories,
            'page' => $page
        ];
    }
}
?>
