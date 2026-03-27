<?php
/**
 * Modèle Statut
 * Gestion des statuts pour les diffusions
 */
class Statut {
    private $pdo;
    
    // Constantes pour les statuts
    const EN_COURS = 1;
    const FINI = 2;
    const A_PREDIRE = 3;
    
    // Mapping des noms
    const NAME_MAP = [
        'en_cours' => self::EN_COURS,
        'fini' => self::FINI,
        'a_predire' => self::A_PREDIRE
    ];
    
    // Mapping inverse
    const ID_MAP = [
        self::EN_COURS => 'en_cours',
        self::FINI => 'fini',
        self::A_PREDIRE => 'a_predire'
    ];
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Récupère tous les statuts
     */
    public function getAll() {
        $sql = "SELECT id, name, description FROM statuts ORDER BY id ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère un statut par ID
     */
    public function getById($id) {
        $sql = "SELECT id, name, description FROM statuts WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère un statut par nom
     */
    public function getByName($name) {
        $sql = "SELECT id, name, description FROM statuts WHERE name = :name";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Convertit un nom de statut en ID
     * @param string $name Nom du statut
     * @return int ID du statut ou 1 par défaut
     */
    public function getIdByName($name) {
        return isset(self::NAME_MAP[$name]) ? self::NAME_MAP[$name] : self::EN_COURS;
    }

    /**
     * Convertit un ID de statut en nom
     * @param int $id ID du statut
     * @return string Nom du statut
     */
    public function getNameById($id) {
        return isset(self::ID_MAP[$id]) ? self::ID_MAP[$id] : 'en_cours';
    }

    /**
     * Valide si un statut existe
     * @param mixed $status ID (int) ou nom (string) du statut
     * @return bool
     */
    public function isValid($status) {
        if (is_numeric($status)) {
            return in_array((int)$status, [self::EN_COURS, self::FINI, self::A_PREDIRE]);
        }
        return isset(self::NAME_MAP[$status]);
    }

    /**
     * Crée un nouveau statut
     */
    public function create($name, $description = '') {
        $sql = "INSERT INTO statuts (name, description, created_at)
                VALUES (:name, :description, NOW())";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        
        return $stmt->execute();
    }

    /**
     * Met à jour un statut
     */
    public function update($id, $name, $description = '') {
        $sql = "UPDATE statuts SET name = :name, description = :description WHERE id = :id";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        
        return $stmt->execute();
    }

    /**
     * Supprime un statut (si pas utilisé)
     */
    public function delete($id) {
        $sql = "DELETE FROM statuts WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
        return $stmt->execute();
    }
}
?>
