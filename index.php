<?php
/**
 * Point d'entrée principal de l'application
 * index.php - Routage simple et délégation aux vues
 */

require_once __DIR__ . '/bootstrap.php';

// Déterminer la page à afficher
$page = $_GET['page'] ?? 'home';

try {
    switch ($page) {
        case 'article':
            if (!isset($_GET['id'])) {
                die('Article non spécifié');
            }
            
            $data = $articleController->view((int)$_GET['id']);
            
            if (isset($data['error'])) {
                die($data['error']);
            }
            
            $article = $data['article'];
            $images = $data['images'];
            $otherArticles = $data['otherArticles'];
            
            // Déterminer l'image du héros
            $heroImage = '';
            if (!empty($images)) {
                $heroImage = $images[0]['image_url'];
            } elseif (!empty($article['image_url'])) {
                $heroImage = $article['image_url'];
            }
            
            // Déterminer la légende du héros
            $heroCaption = '';
            if (!empty($images) && !empty($images[0]['caption'])) {
                $heroCaption = $images[0]['caption'];
            } else {
                $heroCaption = $article['description'] ?? '';
            }
            
            include __DIR__ . '/views/article.php';
            break;

        case 'category':
            if (!isset($_GET['slug'])) {
                die('Catégorie non spécifiée');
            }
            
            $categorySlug = $_GET['slug'];
            $categoryPage = (int)($_GET['page'] ?? 1);
            
            $data = $articleController->listByCategory($categorySlug, $categoryPage);
            
            if (isset($data['error'])) {
                die($data['error']);
            }
            
            $articles = $data['articles'];
            $category = $data['category'];
            
            include __DIR__ . '/views/category.php';
            break;

        case 'home':
        default:
            $data = $articleController->index();
            $articles = $data['articles'];
            
            include __DIR__ . '/views/home.php';
            break;
    }
} catch (Exception $e) {
    die('Erreur : ' . htmlspecialchars($e->getMessage()));
}
?>
