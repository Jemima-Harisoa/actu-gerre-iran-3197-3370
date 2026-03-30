<?php

/**
 * Contrôleur d'authentification
 */

require_once 'model/Users.php';

class AuthenticationController
{
    private Users $usersModel;
    private \PDO $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->usersModel = new Users($pdo);
    }

    /**
     * Authentifie un utilisateur avec son nom d'utilisateur et son mot de passe
     *
     * @param string $username
     * @param string $password
     * @return bool
     */
    public function authenticate(string $username, string $password): bool
    {
        $user = $this->usersModel->getByUsername($username);

        if ($user && password_verify($password, $user['password_hash'])) {
            // Authentification réussie, on peut stocker les informations de l'utilisateur en session
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role_id'] = $user['role_id'];
            return true;
        }

        return false;
    }

    /**
     * Déconnecte l'utilisateur en détruisant la session
     */
    public function logout(): void
    {
        session_unset();
        session_destroy();
    }
}