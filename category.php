<?php
/**
 * Page de catégorie
 * category.php
 */

session_start();

require_once __DIR__ . '/config/Database.php';
require_once __DIR__ . '/model/Category.php';
require_once __DIR__ . '/controller/ArticleController.php';
require_once __DIR__ . '/controller/DiffusionController.php';

$database = new Database();
$pdo = $database->connect();

if (!$pdo) {
    die('Erreur de connexion à la base de données');
}

$articleController = new ArticleController($pdo);
$diffusionController = new DiffusionController($pdo);
$categoryModel = new Category($pdo);

// Récupérer la catégorie depuis l'URL
$slug = isset($_GET['slug']) ? $_GET['slug'] : 'a-la-une';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Récupérer les données via le contrôleur
$data = $articleController->listByCategory($slug, $page);

if (isset($data['error'])) {
    die($data['error']);
}

$articles = $data['articles'];
$category = $data['category'];
$categories = $categoryModel->getAll();
$diffusions = $diffusionController->getActive()['diffusions'];

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($category['name']); ?> - Le Monde</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;0,900;1,400;1,700&family=Source+Serif+4:ital,opsz,wght@0,8..60,300;0,8..60,400;0,8..60,600;1,8..60,300;1,8..60,400&family=Source+Sans+3:wght@300;400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <link rel="stylesheet" href="inc/css/style.css">
</head>
<body>

<!-- UTILITY BAR -->
<div class="util-bar">
  <div class="util-bar__left">
    <a href="#"><svg data-feather="star"></svg>Le Monde</a>
    <a href="#"><svg data-feather="smartphone"></svg>Application</a>
    <a href="#"><svg data-feather="mail"></svg>Newsletters</a>
    <a href="#"><svg data-feather="mic"></svg>Podcasts</a>
  </div>
  <div class="util-bar__right">
    <a href="#"><svg data-feather="log-in"></svg>Se connecter</a>
    <button class="btn-sub-util">S'abonner</button>
  </div>
</div>

<!-- MAIN NAV -->
<nav class="main-nav">
  <div class="nav-left">
    <button class="nav-btn">
      <svg data-feather="menu"></svg>
      Menu
    </button>
    <button class="nav-btn search">
      <svg data-feather="search"></svg>
      Rechercher
    </button>
  </div>
  <div class="nav-logo"><a href="index.php">Le Monde</a></div>
  <div class="nav-right">
    <div class="nav-lang">
      <a href="#" class="active">FR</a>
      <a href="#">EN</a>
    </div>
    <button class="btn-sub-nav">S'abonner</button>
    <span class="nav-icon"><svg data-feather="bookmark"></svg></span>
    <span class="nav-icon"><svg data-feather="user"></svg></span>
  </div>
</nav>

<!-- RUBRIQUE NAV -->
<nav class="rubrique-nav">
  <ul>
    <?php foreach ($categories as $cat): ?>
      <li class="<?php echo $cat['id'] === $category['id'] ? 'active' : ''; ?>">
        <a href="category.php?slug=<?php echo urlencode($cat['slug']); ?>">
          <?php echo htmlspecialchars($cat['name']); ?>
        </a>
      </li>
    <?php endforeach; ?>
  </ul>
</nav>

<!-- DIFFUSION (EN DIRECT) -->
<div class="ticker">
  <div class="ticker-label">
    <svg data-feather="zap"></svg>
    En direct
  </div>
  <div class="ticker-scroll">
    <div class="ticker-track">
      <?php if (!empty($diffusions)): ?>
        <?php foreach ($diffusions as $diffusion): ?>
          <span class="item"><?php echo htmlspecialchars($diffusion['title']); ?></span>
        <?php endforeach; ?>
        <?php foreach ($diffusions as $diffusion): ?>
          <span class="item"><?php echo htmlspecialchars($diffusion['title']); ?></span>
        <?php endforeach; ?>
      <?php else: ?>
        <span class="item">Aucune actualité en direct</span>
      <?php endif; ?>
    </div>
  </div>
</div>

<!-- PAGE TITLE -->
<div class="section" style="padding-bottom: 20px;">
  <h1 style="font-family: 'Playfair Display', serif; font-size: 48px; font-weight: 900; color: #0a0a0a; margin-bottom: 10px;">
    <?php echo htmlspecialchars($category['name']); ?>
  </h1>
</div>

<!-- ARTICLES GRID -->
<div class="section">
  <div class="grid3">
    <?php if (!empty($articles)): ?>
      <?php foreach ($articles as $art): ?>
        <div class="card">
          <div class="thumb">
            <div class="thumb-inner" style="background: linear-gradient(140deg, #1a2535, #2e4258); background-image: url('<?php echo htmlspecialchars($art['image_url'] ?? ''); ?>');">
            </div>
          </div>
          <div class="ckicker"><?php echo htmlspecialchars($category['name']); ?></div>
          <div class="card-title"><?php echo htmlspecialchars($art['title']); ?></div>
          <div class="card-desc"><?php echo htmlspecialchars(substr($art['description'] ?? '', 0, 150) . '...'); ?></div>
          <a href="article.php?id=<?php echo $art['id']; ?>" style="margin-top: 12px; display: block; color: #0057a8; text-decoration: none; font-weight: 600;">Lire plus →</a>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p style="grid-column: 1 / -1;">Aucun article dans cette catégorie pour le moment.</p>
    <?php endif; ?>
  </div>
</div>

<!-- FOOTER -->
<footer>
  <div class="footer-main">
    <div class="footer-logo">Le Monde</div>
    <div class="fcol">
      <h4>Le Monde</h4>
      <a href="index.php"><svg data-feather="home"></svg>À la une</a>
      <a href="#"><svg data-feather="archive"></svg>Archives</a>
      <a href="#"><svg data-feather="mail"></svg>Newsletters</a>
      <a href="#"><svg data-feather="mic"></svg>Podcasts</a>
    </div>
    <div class="fcol">
      <h4>Catégories</h4>
      <?php foreach (array_slice($categories, 0, 5) as $cat): ?>
        <a href="category.php?slug=<?php echo urlencode($cat['slug']); ?>"><?php echo htmlspecialchars($cat['name']); ?></a>
      <?php endforeach; ?>
    </div>
  </div>
  <div class="footer-bottom">
    <span style="color:#2e2e2e;">© Le Monde 2025</span>
    <div class="footer-bottom-links">
      <a href="#">Mentions légales</a>
      <a href="#">Confidentialité</a>
      <a href="#">CGU</a>
      <a href="#">Cookies</a>
      <a href="#">Contact</a>
    </div>
  </div>
</footer>

<script>feather.replace();</script>
</body>
</html>
