<?php
/**
 * Configuration de la base de données
 */
class Database {
    private $host = 'localhost';
    private $db_name = 'iran_actu';
    private $user = 'root';
    private $password = 'root';
    private $charset = 'utf8mb4';
    private $pdo;
    
    public function __construct() {
        $this->host     = $_ENV['DB_HOST']     ?? 'db';
        $this->db_name  = $_ENV['DB_NAME']      ?? 'iran_actu';
        $this->user     = $_ENV['DB_USER']      ?? 'root';
        $this->password = $_ENV['DB_PASSWORD']  ?? 'root';
        $this->charset  = $_ENV['DB_CHARSET']   ?? 'utf8mb4';
    }

    public function connect() {
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->db_name . ';charset=' . $this->charset;
        
        try {
            $this->pdo = new PDO($dsn, $this->user, $this->password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->pdo;
        } catch (PDOException $e) {
            echo 'Erreur de connexion: ' . $e->getMessage();
            return null;
        }
    }

    public function getPDO() {
        if (!$this->pdo) {
            $this->connect();
        }
        return $this->pdo;
    }
}
?>
