-- Script d'authentification backoffice pour la base de données 

-- Création de la table des rôles pour différencier les types d'utilisateurs
CrEATE TABLE IF NOT EXISTS role (
    id SERIAL PRIMARY KEY,
    name VARCHAR(50) UNIQUE NOT NULL
);

-- Création de l'utilisateur backoffice avec un mot de passe sécurisé
CREATE TABLE IF NOT EXISTS users (
    id SERIAL PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    role_id INT NOT NULL DEFAULT 0 REFERENCES role(id) , -- 0: utilisateur normal
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS sessions (
    id SERIAL PRIMARY KEY,
    user_id INTEGER REFERENCES users(id) ON DELETE CASCADE,
    session_token VARCHAR(255) UNIQUE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    expires_at TIMESTAMP NOT NULL
);

-- Exemple d'insertion d'un utilisateur (le mot de passe doit être hashé avant l'insertion) 
INSERT INTO users (username, password_hash) VALUES ('admin', 'hashed_password_here');