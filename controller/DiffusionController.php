<?php

require_once __DIR__ . '/../model/Diffusion.php';

/**
 * Contrôleur Diffusion (En Direct)
 */
class DiffusionController {
    private $diffusion;
    
    public function __construct($pdo) {
        $this->diffusion = new Diffusion($pdo);
    }

    /**
     * Récupère les diffusions actives pour le bandeau de défilement
     */
    public function getActive() {
        $diffusions = $this->diffusion->getActive(8);
        return ['diffusions' => $diffusions];
    }

    /**
     * Récupère tous les diffusions avec pagination
     */
    public function listAll($page = 1) {
        $limit = 20;
        $offset = ($page - 1) * $limit;
        
        $diffusions = $this->diffusion->getAll($limit + $offset);
        
        return [
            'diffusions' => $diffusions,
            'page' => $page
        ];
    }

    /**
     * Récupère les diffusions par statut
     */
    public function getByStatus($status) {
        $valid_statuses = ['en_cours', 'fini', 'a_predire'];
        
        if (!in_array($status, $valid_statuses)) {
            return ['error' => 'Statut invalide'];
        }

        $diffusions = $this->diffusion->getByStatus($status);
        return ['diffusions' => $diffusions, 'status' => $status];
    }
}
?>
