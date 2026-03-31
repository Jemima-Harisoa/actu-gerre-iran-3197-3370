<?php
/**
 * Point d'entrée principal de l'application
 * index.php - Routage simple et délégation aux vues
 */

require_once __DIR__ . '/bootstrap.php';

// Initialiser les données globales pour toutes les vues
// Catégories pour la navigation rubrique (utilisée dans header.php)
$categories = $categoryModel->getAll() ?? [];

// Titre de page par défaut (peut être overridé dans chaque cas)
$pageTitle = 'Chronique de Guerre Iran - Actualités sur l\'Iran';

// Slug de la catégorie active (pour header.php)
$activeSlug = null;

// Récupérer les diffusions actives pour le header (ticker)
$diffusionData = $diffusionController->getActive();
$diffusions = $diffusionData['diffusions'] ?? [];

// Déterminer la page à afficher
$page = $_GET['page'] ?? 'home';

try {
    switch ($page) {
        case 'preview':
            // Seul un admin peut voir un aperçu
            if (empty($_SESSION['user_id']) || $_SESSION['role_id'] !== 1) {
                header('Location: /login');
                exit;
            }
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
            
            // Définir le titre de la page
            $pageTitle = htmlspecialchars($article['title']) . ' - Chronique de Guerre Iran';
            $isPreview = ($page === 'preview'); // pour afficher la bannière dans la vue
            if ($isPreview) {
                $pageTitle = 'Aperçu : ' . $pageTitle;
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
            
            // Marquer cette catégorie comme active dans la navigation
            $activeSlug = $categorySlug;
            
            // Définir le titre de la page
            $pageTitle = htmlspecialchars($category['name']) . ' - Chronique de Guerre Iran';
            
            include __DIR__ . '/views/category.php';
            break;
        case 'login':
            // Si l'utilisateur est déjà connecté, rediriger vers l'accueil 
            if (!empty($_SESSION['user_id'])) {
                header('Location: /login');
                exit;
            }  
            
            $errorMessage = null;

            // Si le formulaire de login est soumis (POST)
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $username = trim($_POST['username'] ?? '');
                $password = trim($_POST['password'] ?? '');

                if ($authenticationController->authenticate($username, $password)) {
                    // Authentification réussie, rediriger vers l'accueil
                    header('Location: /');
                    exit;
                } else {
                    $errorMessage = 'Nom d\'utilisateur ou mot de passe incorrect';
                }
            }
            $pageTitle = 'Connexion - Le Monde';

            include __DIR__ . '/views/login.php';
            break;
        case 'logout':
            $authenticationController->logout();
            header('Location: /login');
            exit;
        case 'admin-article':
            $errorMessage = null;

            if (empty($_SESSION['user_id']) || $_SESSION['role_id'] !== 1) {
                // header('Location: /login');
                $errorMessage = 'Accès refusé. Vous devez être administrateur pour accéder à cette page.'; 
            }
        
            $successMessage = null;

            $previewArticle = null; // ← contiendra l'article à prévisualiser

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $articleId = $adminArticleController->store($_POST, $_FILES);
        
                if ($articleId) {
                    $action = $_POST['action'] ?? 'draft';
        
                    if ($action === 'publish') {
                        header('Location: /?page=article&id=' . $articleId);
                        exit;
                    } else {
                        // Brouillon → charger l'article pour l'aperçu
                        $successMessage = 'Brouillon sauvegardé.';
                        $previewData = $articleController->view($articleId);
                        $previewArticle = $previewData['article'] ?? null;
                    }
                } else {
                    $errorMessage = 'Erreur lors de la sauvegarde.';
                }
            }
        
            $formData = $adminArticleController->getFormData();
            $categoriesForSelect = $formData['categories'];
            $pageTitle = 'Rédiger un article - Admin';
        
            include __DIR__ . '/views/admin/article-form.php';
            break;
                    
        case 'home':
        default:
            $data = $articleController->index();
            $articles = $data['articles'];
            
            // Marquer "À la une" comme active sur l'accueil
            $activeSlug = 'a-la-une';
            
            include __DIR__ . '/views/home.php';
            break;
    }
} catch (Exception $e) {
    die('Erreur : ' . htmlspecialchars($e->getMessage()));
}
?>
