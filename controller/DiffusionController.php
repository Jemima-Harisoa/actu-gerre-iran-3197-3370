<?php

require_once __DIR__ . '/../model/Diffusion.php';
require_once __DIR__ . '/../model/Article.php';

/**
 * Contrôleur Diffusion (En Direct)
 */
class DiffusionController {
    private $diffusion;
    private $article;
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->diffusion = new Diffusion($pdo);
        $this->article = new Article($pdo);
    }

    /**
     * Récupère les diffusions actives pour le bandeau de défilement
     */
    public function getActive() {
        $diffusions = $this->diffusion->getActive(8);

        // Fallback utile en dev/demo: si aucune diffusion n'existe,
        // réutiliser les derniers titres d'articles pour alimenter le ticker.
        if (empty($diffusions)) {
            $recentArticles = $this->article->getAll(8, 0);
            $diffusions = array_map(function ($article) {
                return [
                    'id' => 'article_' . ($article['id'] ?? uniqid()),
                    'title' => $article['title'] ?? 'Actualité',
                    'status_id' => 1,
                    'status_name' => 'en_cours',
                    'created_at' => $article['published_at'] ?? date('Y-m-d H:i:s')
                ];
            }, $recentArticles);
        }

        // Dernier filet de sécurité si la base est vide (premier démarrage)
        if (empty($diffusions)) {
            $diffusions = [
                [
                    'id' => 'fallback_1',
                    'title' => 'Suivez les dernières actualités en direct sur la région.',
                    'status_id' => 1,
                    'status_name' => 'en_cours',
                    'created_at' => date('Y-m-d H:i:s')
                ],
                [
                    'id' => 'fallback_2',
                    'title' => 'Le fil live sera alimenté automatiquement dès publication.',
                    'status_id' => 1,
                    'status_name' => 'en_cours',
                    'created_at' => date('Y-m-d H:i:s')
                ]
            ];
        }

        return ['diffusions' => $diffusions];
    }

    /**
     * Récupère tous les diffusions avec pagination
     */
    public function listAll($page = 1) {
        // Valider et sanitizer le numéro de page
        $page = max(1, (int)$page);
        
        $limit = 20;
        $offset = ($page - 1) * $limit;
        
        // NOTE: Le modèle Diffusion->getAll() ne supporte que le LIMIT, pas OFFSET
        // Pour la pagination complète, il faudrait modifier le modèle
        $diffusions = $this->diffusion->getAll($limit);
        
        return [
            'diffusions' => $diffusions,
            'page' => $page
        ];
    }

    /**
     * Récupère les diffusions par statut
     */
    public function getByStatus($status) {
        // Valider le statut
        $validStatuses = ['en_cours', 'fini', 'a_predire'];
        
        // Si c'est un ID (nombre), récupérer son nom
        if (is_numeric($status)) {
            $statusId = (int)$status;
            // Vérifier que l'ID est valide (1, 2, 3)
            if (!in_array($statusId, [1, 2, 3])) {
                return ['error' => 'Statut invalide'];
            }
        } elseif (in_array($status, $validStatuses)) {
            // C'est déjà un nom, utiliser tel quel
        } else {
            return ['error' => 'Statut invalide'];
        }

        $diffusions = $this->diffusion->getByStatus($status);
        return ['diffusions' => $diffusions, 'status' => $status];
    }
}
?>
