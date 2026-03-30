<?php
/**
 * Bootstrap - Initialisation globale de l'application
 * Chargé une seule fois par index.php
 */

session_start();
if (!headers_sent()) {
    header('Content-Type: text/html; charset=utf-8');
}

// Définir la base URL pour les ressources (CSS, JS, images)
// Cela fonctionne même avec les URLs réécrites par .htaccess
define('BASE_URL', '/TPIran/actu-gerre-iran-3197-3370');

// Charger les fonctions utilitaires
require_once __DIR__ . '/inc/helpers.php';

// Chargement de toutes les dépendances
require_once __DIR__ . '/config/Database.php';
require_once __DIR__ . '/model/Article.php';
require_once __DIR__ . '/model/Category.php';
require_once __DIR__ . '/model/Statut.php';
require_once __DIR__ . '/model/Diffusion.php';
require_once __DIR__ . '/model/ArticleImage.php';
require_once __DIR__ . '/controller/ArticleController.php';
require_once __DIR__ . '/controller/DiffusionController.php';
require_once __DIR__ . '/controller/AuthenticationController.php';

// Connexion à la base de données - UNE SEULE FOIS
$database = new Database();
$pdo = $database->connect();

if (!$pdo) {
    die('Erreur de connexion à la base de données');
}

// Créer les instances de controllers (seront réutilisés partout)
$articleController = new ArticleController($pdo);
$diffusionController = new DiffusionController($pdo);
$categoryModel = new Category($pdo);
$statutModel = new Statut($pdo);
$authenticationController = new AuthenticationController($pdo);

// DEBUG: Vérifier si les catégories existent
$debugCategories = $categoryModel->getAll();
if (empty($debugCategories)) {
    error_log('ERREUR: Aucune catégorie trouvée dans la base de données. Vérifiez que schema.sql a été exécuté.');
}

?>
