<?php
require_once __DIR__ . '/bootstrap.php';
require_once __DIR__ . '/config/Database.php';
require_once __DIR__ . '/model/Article.php';
require_once __DIR__ . '/model/Category.php';

$searchTerm = $_GET['q'] ?? '';
$page = (int)($_GET['page'] ?? 1);

if (empty($searchTerm)) {
    // Rediriger vers l'accueil si la recherche est vide
    header('Location: ' . BASE_URL . '/');
    exit;
}

// Initialiser la connexion à la base de données
$db = new Database();
$pdo = $db->connect();

if (!$pdo) {
    die('Erreur : impossible de se connecter à la base de données');
}

$limit = 10;
$offset = ($page - 1) * $limit;

$articleModel = new Article($pdo);
$articles = $articleModel->search($searchTerm, $limit, $offset);

// Données pour la vue
$pageTitle = 'Résultats de recherche pour "' . htmlspecialchars($searchTerm) . '"';
$categoryModel = new Category($pdo);
$categories = $categoryModel->getAll();
$activeSlug = null; // Pas de slug actif pour la recherche

include __DIR__ . '/views/search_results.php';
