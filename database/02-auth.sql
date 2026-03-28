-- Script d'authentification backoffice pour la base de données 


-- Création de l'utilisateur backoffice avec un mot de passe sécurisé
CREATE TABLE IF NOT EXISTS backoffice_users (
    id SERIAL PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS backoffice_sessions (
    id SERIAL PRIMARY KEY,
    user_id INTEGER REFERENCES backoffice_users(id) ON DELETE CASCADE,
    session_token VARCHAR(255) UNIQUE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    expires_at TIMESTAMP NOT NULL
);

-- Exemple d'insertion d'un utilisateur (le mot de passe doit être hashé avant l'insertion) 
INSERT INTO backoffice_users (username, password_hash) VALUES ('admin', 'hashed_password_here');