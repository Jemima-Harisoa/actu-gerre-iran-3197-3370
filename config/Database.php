<?php
/**
 * Configuration de la base de données
 */
class Database {
    private $host = 'localhost';
    private $db_name = 'iran_actu';
    private $user = 'root';
    private $password = '';
    private $charset = 'utf8mb4';
    private $pdo;

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
