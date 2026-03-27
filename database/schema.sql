-- ============================================
-- Base de données Iran Actu - Schema SQL
-- ============================================

-- Créer la base de données
CREATE DATABASE IF NOT EXISTS iran_actu;
USE iran_actu;

-- ============================================
-- Table Categories (Rubriques)
-- ============================================
CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    slug VARCHAR(100) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- Table Articles
-- ============================================
CREATE TABLE IF NOT EXISTS articles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    description VARCHAR(500),
    content LONGTEXT,
    author VARCHAR(150),
    image_url VARCHAR(500),
    is_featured BOOLEAN DEFAULT 0,
    published_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE,
    INDEX idx_category (category_id),
    INDEX idx_published (published_at),
    INDEX idx_featured (is_featured)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- Table Statuts (Pour la diffusion en direct)
-- ============================================
CREATE TABLE IF NOT EXISTS statuts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE,
    description VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- Table Diffusion (En Direct)
-- Référence la table statuts
-- ============================================
CREATE TABLE IF NOT EXISTS diffusion (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(500) NOT NULL,
    status_id INT NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (status_id) REFERENCES statuts(id) ON DELETE RESTRICT,
    INDEX idx_status (status_id),
    INDEX idx_created (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- Table Article Images (Images multiples)
-- ============================================
CREATE TABLE IF NOT EXISTS article_images (
    id INT AUTO_INCREMENT PRIMARY KEY,
    article_id INT NOT NULL,
    image_url VARCHAR(500) NOT NULL,
    caption VARCHAR(500),
    position INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (article_id) REFERENCES articles(id) ON DELETE CASCADE,
    INDEX idx_article (article_id),
    INDEX idx_position (position)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- Insérer les catégories par défaut
-- ============================================
INSERT INTO categories (name, slug) VALUES
('À la une', 'a-la-une'),
('International', 'international'),
('Politique', 'politique'),
('Société', 'societe'),
('Économie', 'economie'),
('Culture', 'culture'),
('Idées', 'idees'),
('Planète', 'planete'),
('Sciences', 'sciences'),
('Sport', 'sport'),
('Tech', 'tech'),
('M Le Mag', 'm-le-mag');

-- ============================================
-- Insérer des articles de test (Guerre en Iran)
-- ============================================
INSERT INTO articles (category_id, title, description, content, author, image_url, is_featured, published_at) VALUES
(
    2,
    'Guerre en Iran : les suites incertaines de la domination militaire incontestable des Américains et des Israéliens',
    'Une semaine après le début de l\'opération « Fureur épique », Israël et les États-Unis peuvent se prévaloir de nombreux succès, sans pertes majeures.',
    '<p><strong>Une semaine après le début de l\'opération « Fureur épique »</strong>, Israël et les États-Unis peuvent se prévaloir de nombreux succès, sans pertes majeures. Mais ils n\'ont toujours pas établi d\'objectif clair, alors que la situation demeure chaotique dans la région.</p><p>Ce devait être le quartier général de la riposte iranienne, en cas d\'attaque d\'Israël ou des États-Unis. Un bunker au cœur de Téhéran, enterré plusieurs dizaines de mètres sous terre. Il a été bombardé en ouverture de la guerre, le matin du samedi 18 février, alors des frappes tuaient Ali Khamenei, le Guide suprême, et de nombreux hauts responsables du régime.</p>',
    'Luc Bonnier, Piotr Smolar',
    'https://via.placeholder.com/760x430?text=Teheran+Iran+War',
    1,
    '2025-05-27 18:42:00'
),
(
    3,
    'La vie politique en Iran : enjeux et transformations après la crise',
    'Une semaine après le début de l\'opération « Fureur épique », Israël et les États-Unis peuvent se prévaloir de nombreux succès, sans pertes majeures.',
    '<p><strong>Une semaine après le début de l\'opération « Fureur épique »</strong>, Israël et les États-Unis peuvent se prévaloir de nombreux succès, sans pertes majeures. Mais ils n\'ont toujours pas établi d\'objectif clair, alors que la situation demeure chaotique dans la région.</p><p>Ce devait être le quartier général de la riposte iranienne, en cas d\'attaque d\'Israël ou des États-Unis. Un bunker au cœur de Téhéran, enterré plusieurs dizaines de mètres sous terre. Il a été bombardé en ouverture de la guerre, le matin du samedi 18 février, alors des frappes tuaient Ali Khamenei, le Guide suprême, et de nombreux hauts responsables du régime.</p>',
    'Correspondant Politique',
    'https://via.placeholder.com/760x430?text=Politique+Iran',
    0,
    '2025-05-26 15:30:00'
),
(
    2,
    'Les États-Unis bombardent les milices pro-iraniennes en Irak et en Syrie',
    'Une nouvelle vague de frappes de grande ampleur sur les positions pro-iraniennes.',
    '<p>Les États-Unis bombardent les milices pro-iraniennes en Irak et en Syrie après une série de missiles vers d\'Iran...</p>',
    'Correspondants Moyen-Orient',
    'https://via.placeholder.com/760x430?text=Moyen+Orient',
    0,
    '2025-05-25 10:15:00'
);

-- ============================================
-- Insérer des images multiples pour les articles
-- ============================================
INSERT INTO article_images (article_id, image_url, caption, position) VALUES
(1, 'https://via.placeholder.com/760x430?text=Teheran+1', 'Vue de Téhéran', 0),
(1, 'https://via.placeholder.com/760x430?text=Teheran+2', 'Centre ville', 1),
(1, 'https://via.placeholder.com/760x430?text=Teheran+3', 'Monument historique', 2),
(2, 'https://via.placeholder.com/760x430?text=Politique+1', 'Parlement iranien', 0),
(2, 'https://via.placeholder.com/760x430?text=Politique+2', 'Débat politique', 1);

-- ============================================
-- Insérer les statuts par défaut
-- ============================================
INSERT INTO statuts (name, description) VALUES
('en_cours', 'Actualité en cours - En direct'),
('fini', 'Actualité terminée - Archived'),
('a_predire', 'Actualité à venir - À prédire');

-- ============================================
-- Insérer des diffusions de test
-- ============================================
INSERT INTO diffusion (title, status_id) VALUES
('Guerre en Iran : nouvelles frappes sur Téhéran dans la nuit du vendredi au samedi', 2),
('Moyen-Orient : Israël annonce une trêve humanitaire de 8 heures à Gaza', 1),
('Ukraine : la France va livrer 12 chasseurs Mirage 2000 supplémentaires à Kiev', 3),
('Économie : la BCE maintient ses taux directeurs inchangés pour le troisième trimestre', 1);
