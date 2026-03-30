<?php
/**
 * Configuration de la base de données
 */
class Database {
    private $host;
    private $db_name;
    private $user;
    private $password;
    private $charset;
    private $pdo;
    
    public function __construct() {
        $this->host     = getenv('DB_HOST')     ?: 'db';
        $this->db_name  = getenv('DB_NAME')     ?: 'iran_actu';
        $this->user     = getenv('DB_USER')     ?: 'root';
        $this->password = getenv('DB_PASSWORD') ?: '';
        $this->charset  = getenv('DB_CHARSET')  ?: 'utf8mb4';
    }

    public function connect() {
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->db_name . ';charset=' . $this->charset;
        
        try {
            $this->pdo = new PDO($dsn, $this->user, $this->password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci"
            ]);
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