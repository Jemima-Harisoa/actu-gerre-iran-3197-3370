# Installation et Configuration - Iran Actu

## 📋 Prérequis

- **PHP 7.4+** (recommandé PHP 8.0+)
- **MySQL 5.7+** ou **MariaDB 10.3+**
- **Apache** avec mod_rewrite activé
- **WAMP/LAMP/XAMP** (votre environnement local)

---

## 🚀 Installation Rapide

### 1. **Créer la Base de Données**

Ouvrez **phpMyAdmin** (via WAMP) et exécutez le fichier SQL :

```sql
-- Allez dans : Importer
-- Fichier : database/schema.sql
```

Ou en ligne de commande MySQL :

```bash
mysql -u root -p < database/schema.sql
```

### 2. **Configurer la Connexion MySQL**

Éditez le fichier `config/Database.php` et ajustez les paramètres si nécessaire :

```php
private $host = 'localhost';
private $db_name = 'iran_actu';
private $user = 'root';
private $password = '';  // Votre mot de passe MySQL
```

### 3. **Démarrer l'Application**

Ouvrez votre navigateur et accédez à :

```
http://localhost/TPIran/actu-gerre-iran-3197-3370/
```

ou directement :

```
http://localhost/TPIran/actu-gerre-iran-3197-3370/index.php
```

---

## 📁 Structure du Projet

```
actu-gerre-iran-3197-3370/
├── config/
│   └── Database.php          # Configuration de la BD
├── model/
│   ├── Article.php           # Modèle Article
│   ├── Ticker.php            # Modèle Ticker (En Direct)
│   └── Category.php          # Modèle Catégorie
├── controller/
│   ├── ArticleController.php # Contrôleur Article
│   └── TickerController.php  # Contrôleur Ticker
├── database/
│   ├── schema.sql            # Schéma MySQL
│   └── blablaaa              # Répertoire de données
├── views/
│   └── blablaaa              # Répertoire de vues
├── inc/
│   ├── css/
│   │   └── style.css         # Feuille de styles
│   ├── img/                  # Images
│   └── js/                   # JavaScript
├── index.php                 # Page d'accueil (articles)
├── category.php              # Page catégorie
├── article.php               # Page article complet
├── reference.html            # Template initial (conservé)
└── README.md                 # Ce fichier
```

---

## 🗄️ Structure de la Base de Données

### Table `categories` (Rubriques)
```
‌├─ id (INT, PK)
├─ name (VARCHAR 100)         # Nom de la catégorie
├─ slug (VARCHAR 100)         # URL-friendly (ex: "a-la-une")
├─ created_at (TIMESTAMP)
└─ updated_at (TIMESTAMP)
```

**Catégories prédéfinies :**
- À la une
- International
- Politique
- Société
- Économie
- Culture
- Idées
- Planète
- Sciences
- Sport
- Tech
- M Le Mag

### Table `articles`
```
├─ id (INT, PK)
├─ category_id (INT, FK)
├─ title (VARCHAR 255)        # Titre article
├─ description (VARCHAR 500)  # Résumé court
├─ content (LONGTEXT)         # Contenu complet (HTML)
├─ author (VARCHAR 150)       # Auteur
├─ image_url (VARCHAR 500)    # URL image
├─ is_featured (BOOLEAN)      # Article mis en avant
├─ published_at (TIMESTAMP)
├─ created_at (TIMESTAMP)
└─ updated_at (TIMESTAMP)
```

### Table `ticker` (En Direct)
```
├─ id (INT, PK)
├─ title (VARCHAR 500)        # Titre du ticker
├─ status (ENUM)              # État : 'en_cours', 'fini', 'a_predire'
├─ created_at (TIMESTAMP)
└─ updated_at (TIMESTAMP)
```

**Statuts disponibles :**
- `en_cours` : Actualité en cours de diffusion
- `fini` : Actualité terminée
- `a_predire` : Actualité à venir

---

## 🔧 Ajouter des Articles (SQL ou Panneau Admin)

### Option 1 : Via SQL
```sql
INSERT INTO articles (category_id, title, description, content, author, image_url, is_featured, published_at)
VALUES (2, 'Titre article', 'Résumé court', '<p>Contenu HTML</p>', 'Auteur', 'https://...', 0, NOW());
```

### Option 2 : Via le panneau Admin
Accédez à `http://localhost/TPIran/actu-gerre-iran-3197-3370/admin/` et utilisez le formulaire "Nouvel Article"

## 🎫 Ajouter des Tickers (SQL ou Panneau Admin)

### Option 1 : Via SQL
```sql
INSERT INTO ticker (title, status) VALUES ('Actualité', 'en_cours');
-- Statuts : 'en_cours', 'fini', 'a_predire'
```

### Option 2 : Via le panneau Admin
Accédez à `http://localhost/TPIran/actu-gerre-iran-3197-3370/admin/` et utilisez le formulaire "Nouveau Ticker"

---

## 📱 Pages Disponibles

| URL | Description |
|-----|-------------|
| `/index.php` | Accueil - Tous les articles |
| `/category.php?slug=international` | Articles par catégorie |
| `/article.php?id=1` | Article complet |
| `/reference.html` | Template original (conservé) |

---

## 🎨 Personnalisation

### Styles CSS
Éditez `inc/css/style.css` pour modifier les couleurs et mises en page.

### Modèles Définis
```javascript
--black: #0a0a0a
--white: #fff
--red: #d0011b
--blue: #0057a8
--gray-100: #f5f4f0
```

### Polices
- **Display :** Playfair Display
- **Serif :** Source Serif 4
- **Sans :** Source Sans 3

---

## 🐛 Dépannage

### Erreur "Erreur de connexion à la base de données"
- Vérifiez que MySQL est lancé
- Vérifiez les identifiants dans `config/Database.php`
- Vérifiez que la base `iran_actu` existe

### Pas d'articles affichés
- Vérifiez que des articles ont été insérés dans la table `articles`
- Vérifiez les slugs des catégories

### CSS/Images non chargés
- Vérifiez les chemins relatifs
- Rafraîchissez le cache du navigateur (Ctrl+F5)

---

## 📝 Notes Importantes

**reference.html** a été préservé comme demandé
Un **index.php** complet a été créé avec tous les articles
La gestion du **ticker "en direct"** avec 3 états (en_cours, fini, a_predire)
**12 catégories** déjà incluses et paramétrables
Architecture **MVC** (Model-View-Controller)
**Pagination** supportée pour les articles

---

## 📞 Support

Pour toute question ou problème, consultez les fichiers :
- `model/*.php` - Logique métier
- `controller/*.php` - Traitement des requêtes
- `config/Database.php` - Configuration

---

**Dernière mise à jour :** 2025-05-27
