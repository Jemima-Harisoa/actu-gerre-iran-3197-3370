<?php
/**
 * Contrôleur Admin - gestion des articles 
 */
require_once __DIR__.'/../model/Articles.php';
require_once __DIR__.'/../model/Category.php';
require_once __DIR__.'/../model/Status.php';

class AdminArticleController {
    private Article $articleModel;
    private Category $categoryModel;
    private Statut $statutModel;
    private \PDO $pdo;

    public function __construct(\PDO $pdo) {
        $this->pdo = $pdo;
        $this->articleModel = new Article($pdo);
        $this->categoryModel = new Category($pdo);
        $this->statutModel = new Statut($pdo);
    }

    /**
     * Vérifie que l'utilisateur a le rôle admin avant d'autoriser l'accès à la page.
     * Si l'utilisateur n'est pas admin, redirige vers la page d'accueil ou affiche une erreur.
     */
    private function checkRole(): void {
        if (empty($_SESSION['user_id'] || $_SESSION['role'] !== '1')){
            // Rediriger vers la page d'accueil ou afficher une erreur
            header('Location: ' . BASE_URL . '/login');
            exit;
        }
    }

    /**
     * Récupère les données nécessaires pour afficher le formulaire de création d'article.
     */
    public function getFormData(): array {
        $this->checkRole();
        return ['categories' => $this->categoryModel->getAll(), 'statuts' => $this->statutModel->getAll()];
    }

    /**
     * Traite les données du formulaire de création d'article et sauvegarde l'article dans la base de données.
     * Retourne id de l'article si la sauvegarde a réussi, false sinon.
     */
    public function store(array $postData, array $fileData): bool|int
    {
        $this->checkRole();

        // Validation basique
        if (empty($postData['title']) || empty($postData['content']) || empty($postData['category_id'])) {
            return false;
        }

        // Gérer l'image principale (upload simple)
        $imageUrl = $this->handleImageUpload($fileData);

        // Déterminer le statut selon le bouton cliqué
        // Le formulaire enverra action=publish ou action=draft
        $publishedAt = ($postData['action'] === 'publish') ? date('Y-m-d H:i:s') : null;

        $data = [
            'category_id'  => (int) $postData['category_id'],
            'title'        => trim($postData['title']),
            'description'  => trim($postData['description'] ?? ''),
            'content'      => $postData['content'], // HTML de TinyMCE
            'author'       => $_SESSION['username'], // depuis la session
            'image_url'    => $imageUrl,
            'is_featured'  => isset($postData['is_featured']) ? 1 : 0,
            'published_at' => $publishedAt
        ];

        return $this->articleModel->create($data);
    }

    /**
     * Gère l'upload de l'image principale
     * Retourne l'URL de l'image ou une chaîne vide
     */
    private function handleImageUpload(array $fileData): string
    {
        // Pas d'image uploadée
        if (empty($fileData['image']['name'])) {
            return '';
        }

        $uploadDir = __DIR__ . '/../inc/uploads/';
        
        // Créer le dossier si il n'existe pas
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        // Générer un nom unique pour éviter les collisions
        $extension = pathinfo($fileData['image']['name'], PATHINFO_EXTENSION);
        $filename   = uniqid('img_') . '.' . $extension;
        $destination = $uploadDir . $filename;

        if (move_uploaded_file($fileData['image']['tmp_name'], $destination)) {
            return '/uploads/' . $filename;
        }

        return '';
    }
}