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
