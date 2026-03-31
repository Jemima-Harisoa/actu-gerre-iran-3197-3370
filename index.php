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
                    header('Location: /admin');
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
                $slug = generateSlug($_POST['title']);
                if ($articleId) {
                    $action = $_POST['action'] ?? 'draft';
        
                    if ($action === 'publish') {
                        header("Location: /{$articleId}/article/{$slug}");
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
        case 'admin-articles':
            if (empty($_SESSION['user_id']) || $_SESSION['role_id'] !== 1) {
                header('Location: /login'); exit;
            }
    
            $successMessage = null;
            $errorMessage   = null;
    
            // Traitement des actions POST
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $action    = $_POST['action'] ?? '';
                $targetId  = (int)($_POST['id'] ?? 0);
                $articleModel = new Article($pdo);
    
                switch ($action) {
    
                    case 'delete':
                        if ($targetId && $articleModel->delete($targetId)) {
                            $successMessage = 'Article supprimé.';
                        } else {
                            $errorMessage = 'Erreur lors de la suppression.';
                        }
                        break;
    
                    case 'toggle_publish':
                        // Récupérer l'article pour savoir son état actuel
                        $current = $articleModel->getById($targetId);
                        if ($current) {
                            $newPublishedAt = !empty($current['published_at']) ? null : date('Y-m-d H:i:s');
                            $articleModel->update($targetId, array_merge($current, ['published_at' => $newPublishedAt]));
                            $successMessage = !empty($current['published_at']) ? 'Article dépublié.' : 'Article publié.';
                        }
                        break;
    
                    case 'toggle_featured':
                        $current = $articleModel->getById($targetId);
                        if ($current) {
                            $newFeatured = $current['is_featured'] ? 0 : 1;
                            $articleModel->update($targetId, array_merge($current, ['is_featured' => $newFeatured]));
                            $successMessage = $newFeatured ? 'Article mis à la une.' : 'Article retiré de la une.';
                        }
                        break;
                }
            }
    
            // Charger tous les articles pour la liste
            $articleModel = new Article($pdo);
            $articles     = $articleModel->getAll(100, 0);
            $pageTitle    = 'Articles — Admin';
    
            include __DIR__ . '/views/admin/articles-list.php';
            break;
    // ── LISTE DES DIFFUSIONS ────────────────────────────────
        case 'admin-diffusions':
            if (empty($_SESSION['user_id']) || $_SESSION['role_id'] !== 1) {
                header('Location: /login'); exit;
            }
    
            $successMessage = null;
            $errorMessage   = null;
    
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $action   = $_POST['action'] ?? '';
                $targetId = (int)($_POST['id'] ?? 0);
    
                switch ($action) {
    
                    case 'create':
                        $title  = trim($_POST['title'] ?? '');
                        $status = $_POST['status'] ?? 'en_cours';
                        if ($title) {
                            // Diffusion->create() existe déjà dans le model
                            $diffModel = new Diffusion($pdo);
                            $diffModel->create($title, $status);
                            $successMessage = 'Diffusion ajoutée.';
                        } else {
                            $errorMessage = 'Le titre est requis.';
                        }
                        break;
    
                    case 'update_status':
                        $status    = $_POST['status'] ?? 'en_cours';
                        $diffModel = new Diffusion($pdo);
                        $diffModel->updateStatus($targetId, $status);
                        $successMessage = 'Statut mis à jour.';
                        break;
    
                    case 'delete':
                        $diffModel = new Diffusion($pdo);
                        if ($targetId && $diffModel->delete($targetId)) {
                            $successMessage = 'Diffusion supprimée.';
                        } else {
                            $errorMessage = 'Erreur lors de la suppression.';
                        }
                        break;
                }
            }
    
            $data       = $diffusionController->listAll();
            $diffusions = $data['diffusions'];
            $pageTitle  = 'Diffusions — Admin';
    
            include __DIR__ . '/views/admin/diffusions-list.php';
            break;
        // ── LISTE DES CATÉGORIES ────────────────────────────────
        case 'admin-categories':
            if (empty($_SESSION['user_id']) || $_SESSION['role_id'] !== 1) {
                header('Location: /login'); exit;
            }
    
            $successMessage = null;
            $errorMessage   = null;
    
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $action   = $_POST['action'] ?? '';
                $targetId = (int)($_POST['id'] ?? 0);
    
                switch ($action) {
    
                    case 'create':
                        $name = trim($_POST['name'] ?? '');
                        $slug = trim($_POST['slug'] ?? '');
                        if ($name && $slug) {
                            // Normaliser le slug : minuscules, tirets
                            $slug = strtolower(preg_replace('/[^a-z0-9-]/', '-', $slug));
                            $categoryModel->create($name, $slug);
                            $successMessage = 'Catégorie créée.';
                        } else {
                            $errorMessage = 'Nom et slug sont requis.';
                        }
                        break;
    
                    case 'delete':
                        if ($targetId && $categoryModel->delete($targetId)) {
                            $successMessage = 'Catégorie supprimée.';
                        } else {
                            $errorMessage = 'Erreur lors de la suppression.';
                        }
                        break;
                }
            }
    
            // Charger les catégories avec le nombre d'articles
            $allCats = $categoryModel->getAll();
            $categoriesAdmin = array_map(function($cat) use ($categoryModel) {
                $cat['article_count'] = $categoryModel->getArticleCount($cat['id']);
                return $cat;
            }, $allCats);
    
            $pageTitle = 'Catégories — Admin';
    
            include __DIR__ . '/views/admin/categories-list.php';
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
