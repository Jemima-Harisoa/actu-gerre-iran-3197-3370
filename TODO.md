# Docker 
## Installation de Docker
    - [ ] Docker compose environnement developpement :
        - [ ] image de base :
            - [ ] mysql 9.1 pour la base de données
            - [ ] apache 2.4 pour le serveur web
        - [ ] hot reload : mis ajour de l'environnement de développement pour permettre le rechargement automatique du code sans redémarrer les conteneurs. 
        - [ ] docker-compose.dev.yml : rechargement automatique du code sans redémarrer les conteneurs 

    - [ ] Script de lancement :
        - [ ] start.sh : lancement de l'environnement de développement
        - [ ] stop.sh : arret de l'environnement de développement 
        - [ ] script d'execution sql sans recharger les conteneurs => integrer les script de test au fur et a mesur et valider les changements dans la base de données sans redémarrer les conteneurs.

# Base de données MysQL
    - [ ] Conception de la base de données :
        - [ ] tables : articles, categories, images, videos, utilisateurs
        - [ ] relations : un article peut appartenir à une catégorie, un article peut avoir plusieurs images et vidéos associées, un utilisateur peut créer plusieurs articles.
    - [ ] Script de création de la base de données :
        - [ ] create_database.sql : script SQL pour créer la base de données et les tables nécessaires
    - [ ] Script d'insertion de données initial :
        - [ ] insert_data.sql : script SQL pour insérer des données d'exemple dans la base de données pour les tests et le développement.

# Front Office
- [ ] Affichage des articles avec images et vidéos :
    - [ ] Page d'accueil présentant les derniers articles
        - [ ] Data
        - [ ] Affichage
        - [ ] Integration
        - [ ] Fonctionnalités

    - [ ] Page de détail pour chaque article avec contenu complet, images et vidéos associées
        - [ ] Data
        - [ ] Affichage
        - [ ] Integration
        - [ ] Fonctionnalités

    - [ ] Catégories d'articles (politique, économie, culture, etc.) 
        - [ ] Data
        - [ ] Affichage
        - [ ] Integration
        - [ ] Fonctionnalités

- [ ] Barre de recherche pour trouver des articles spécifiques :
    - [ ] Filtrage des articles par mots-clés ou catégories
        - [ ] Data
        - [ ] Affichage
        - [ ] Integration
        - [ ] Fonctionnalités

    - [ ] Affichage des résultats de recherche avec liens vers les articles correspondants
        - [ ] Data
        - [ ] Affichage
        - [ ] Integration
        - [ ] Fonctionnalités

# Back Office
- [ ] Système d'authentification pour sécuriser l'accès à l'administration :
    - [ ] Formulaire de connexion pour les administrateurs
        - [ ] Data
        - [ ] Affichage
        - [ ] Integration
        - [ ] Fonctionnalités

    - [ ] Validation des identifiants et gestion des sessions pour maintenir la connexion de l'administrateur
        - [ ] Data
        - [ ] Affichage
        - [ ] Integration
        - [ ] Fonctionnalités

- [ ] Interface d'administration pour la gestion du contenu :
    - [ ] Formulaire de création et de modification d'articles avec champs pour le titre, le contenu, les images et les vidéos
        - [ ] Data
        - [ ] Affichage
        - [ ] Integration
        - [ ] Fonctionnalités

    - [ ] Liste des articles existants avec options de modification et de suppression
        - [ ] Data
        - [ ] Affichage
        - [ ] Integration
        - [ ] Fonctionnalités

    - [ ] Gestion des catégories d'articles
        - [ ] Data
        - [ ] Affichage
        - [ ] Integration
        - [ ] Fonctionnalités
