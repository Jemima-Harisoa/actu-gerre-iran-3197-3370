# 🚀 GUIDE AVANCÉ - Fonctionnalités

## 🔐 Authentification (À Implémenter)

Pour sécuriser l'accès à l'admin, vous pouvez ajouter une vérification :

```php
// En haut de admin/index.php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
```

---

## 📌 Ajouter une Nouvelle Catégorie

### Via SQL
```sql
INSERT INTO categories (name, slug) 
VALUES ('Nouvelle Catégorie', 'nouvelle-categorie');
```

### Via PHP
```php
$categoryModel = new Category($pdo);
$categoryModel->create('Nouvelle Catégorie', 'nouvelle-categorie');
```

---

## 🎨 Personnaliser les Couleurs

**Fichier :** `inc/css/style.css`

```css
:root {
  --black: #0a0a0a;      /* Noir principal */
  --white: #fff;         /* Blanc */
  --red: #d0011b;        /* Rouge accent */
  --blue: #0057a8;       /* Bleu accent */
  --gray-100: #f5f4f0;   /* Gris clair */
  --gray-600: #6b6760;   /* Gris moyen */
}
```

---

## 🌐 Multilingue (Template)

### Ajouter le français/anglais dynamiquement

```php
<?php
$language = $_GET['lang'] ?? 'fr';
$translations = [
    'fr' => [
        'home' => 'Accueil',
        'articles' => 'Articles'
    ],
    'en' => [
        'home' => 'Home',
        'articles' => 'Articles'
    ]
];

echo $translations[$language]['home'];
?>
```

---

## 📊 Statistiques

### Articles par Catégorie

```php
<?php
$categories = $categoryModel->getAll();
foreach ($categories as $cat) {
    $count = $categoryModel->getArticleCount($cat['id']);
    echo $cat['name'] . ": " . $count . " articles\n";
}
?>
```

### Tickers par Statut

```php
<?php
$statuses = ['en_cours', 'fini', 'a_predire'];
foreach ($statuses as $status) {
    $tickers = $tickerModel->getByStatus($status);
    echo ucfirst(str_replace('_', ' ', $status)) . ": " . count($tickers) . "\n";
}
?>
```

---

## 🔍 Recherche

### Ajouter une recherche d'articles

```php
// model/Article.php
public function search($keyword) {
    $sql = "SELECT a.*, c.name as category_name FROM articles a
            LEFT JOIN categories c ON a.category_id = c.id
            WHERE a.title LIKE :keyword 
               OR a.description LIKE :keyword
               OR a.content LIKE :keyword
            ORDER BY a.published_at DESC";
    
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindParam(':keyword', '%' . $keyword . '%');
    $stmt->execute();
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
```

### Utiliser la recherche

```php
// search.php
$query = $_GET['q'] ?? '';
if ($query) {
    $results = $articleModel->search($query);
}
```

---

## 📧 Notifications (Email)

### Envoyer une alerte par email

```php
<?php
// Lors de la création d'un article
$to = "admin@example.com";
$subject = "Nouvel article: " . $data['title'];
$message = "Un nouvel article a été publié.";
$headers = "From: noreply@lemonde.com";

mail($to, $subject, $message, $headers);
?>
```

---

## 💾 Export/Import

### Exporter articles en JSON

```php
<?php
header('Content-Type: application/json');
header('Content-Disposition: attachment; filename="articles.json"');

$articles = $articleModel->getAll(1000);
echo json_encode($articles, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
?>
```

### Exporter en CSV

```php
<?php
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="articles.csv"');

$fp = fopen('php://output', 'w');
fputcsv($fp, ['ID', 'Titre', 'Auteur', 'Catégorie', 'Date']);

$articles = $articleModel->getAll(1000);
foreach ($articles as $article) {
    fputcsv($fp, [
        $article['id'],
        $article['title'],
        $article['author'],
        $article['category_name'],
        $article['published_at']
    ]);
}
fclose($fp);
?>
```

---

## 🚨 Gestion d'Erreurs Avancée

### Créer une classe d'exception personnalisée

```php
<?php
class AppException extends Exception {}
class DatabaseException extends AppException {}

try {
    $stmt = $this->pdo->prepare($sql);
    if (!$stmt->execute()) {
        throw new DatabaseException("Erreur execution requête");
    }
} catch (DatabaseException $e) {
    logEvent("DB Error: " . $e->getMessage(), 'ERROR');
    throw $e;
} catch (Exception $e) {
    logEvent("Error: " . $e->getMessage(), 'ERROR');
}
?>
```

---

## ⏰ Cache (Optimisation)

### Implémenter un cache simple

```php
<?php
function getCachedArticles($cache_key, $callback, $expiry = 3600) {
    $cache_file = sys_get_temp_dir() . '/' . $cache_key . '.cache';
    
    // Vérifier si cache existe et est valide
    if (file_exists($cache_file) && (time() - filemtime($cache_file)) < $expiry) {
        return unserialize(file_get_contents($cache_file));
    }
    
    // Générer nouveau cache
    $data = call_user_func($callback);
    file_put_contents($cache_file, serialize($data));
    
    return $data;
}

// Utilisation
$articles = getCachedArticles('articles_home', function() {
    global $articleModel;
    return $articleModel->getFeatured(10);
}, 1800); // 30 min de cache
?>
```

---

## 🎯 SEO

### Ajouter les métadonnées

```php
<!-- article.php -->
<meta name="description" content="<?php echo htmlspecialchars($article['description']); ?>">
<meta name="keywords" content="<?php echo htmlspecialchars($article['category_name']); ?>, Iran, actualités">
<meta property="og:title" content="<?php echo htmlspecialchars($article['title']); ?>">
<meta property="og:description" content="<?php echo htmlspecialchars($article['description']); ?>">
<meta property="og:image" content="<?php echo htmlspecialchars($article['image_url']); ?>">
```

### Générer sitemap.xml

```php
<?php
// sitemap.php
header('Content-Type: application/xml');
echo '<?xml version="1.0" encoding="UTF-8"?>';
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

$articles = $articleModel->getAll(1000);
foreach ($articles as $article) {
    echo '<url>';
    echo '<loc>' . getBaseUrl() . '/article.php?id=' . $article['id'] . '</loc>';
    echo '<lastmod>' . $article['updated_at'] . '</lastmod>';
    echo '</url>';
}

echo '</urlset>';
?>
```

---

## 🔐 Validation Avancée

### Valider les entrées utilisateur

```php
<?php
function validateArticle($data) {
    $errors = [];
    
    if (empty($data['title'])) {
        $errors[] = 'Le titre est requis';
    }
    
    if (strlen($data['title']) < 5) {
        $errors[] = 'Le titre doit faire au moins 5 caractères';
    }
    
    if (strlen($data['content']) < 100) {
        $errors[] = 'Le contenu doit faire au moins 100 caractères';
    }
    
    if (!filter_var($data['image_url'], FILTER_VALIDATE_URL)) {
        $errors[] = 'L\'URL image n\'est pas valide';
    }
    
    return $errors;
}

$errors = validateArticle($data);
if (!empty($errors)) {
    sendJson(['success' => false, 'errors' => $errors], 400);
}
?>
```

---

## 📊 Analytics

### Enregistrer les vues d'articles

```php
// Ajouter une table
CREATE TABLE article_views (
    id INT AUTO_INCREMENT PRIMARY KEY,
    article_id INT,
    viewed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    ip_address VARCHAR(50),
    FOREIGN KEY (article_id) REFERENCES articles(id)
);

// Enregistrer une vue
$ip = $_SERVER['REMOTE_ADDR'];
$sql = "INSERT INTO article_views (article_id, ip_address) VALUES (?, ?)";
$stmt = $pdo->prepare($sql);
$stmt->execute([$article_id, $ip]);
```

---

**Dernière mise à jour :** 27 mai 2025
