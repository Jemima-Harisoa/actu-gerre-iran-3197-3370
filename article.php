<?php
/**
 * Page article complet
 * article.php
 */

session_start();

require_once __DIR__ . '/config/Database.php';
require_once __DIR__ . '/model/Article.php';
require_once __DIR__ . '/model/Category.php';
require_once __DIR__ . '/controller/ArticleController.php';
require_once __DIR__ . '/controller/DiffusionController.php';

$database = new Database();
$pdo = $database->connect();

if (!$pdo) {
    die('Erreur de connexion à la base de données');
}

$articleController = new ArticleController($pdo);
$categoryModel = new Category($pdo);
$diffusionController = new DiffusionController($pdo);

// Récupérer l'article_id depuis l'URL
$article_id = isset($_GET['id']) ? (int)$_GET['id'] : null;

if (!$article_id) {
    die('Article non spécifié');
}

// Récupérer toutes les données
$data = $articleController->view($article_id);

if (isset($data['error'])) {
    die($data['error']);
}

$article = $data['article'];
$images = $data['images'];
$otherArticles = $data['otherArticles'];
$categories = $categoryModel->getAll();
$diffusions = $diffusionController->getActive()['diffusions'];

// Déterminer l'image du héros
$heroImage = '';
if (!empty($images)) {
    $heroImage = $images[0]['image_url'];
} elseif (!empty($article['image_url'])) {
    $heroImage = $article['image_url'];
}

// Déterminer la légende du héros
$heroCaption = '';
if (!empty($images) && !empty($images[0]['caption'])) {
    $heroCaption = $images[0]['caption'];
} else {
    $heroCaption = $article['description'] ?? '';
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($article['title']); ?> - Chronique de Guerre Iran</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;0,900;1,400;1,700&family=Source+Serif+4:ital,opsz,wght@0,8..60,300;0,8..60,400;0,8..60,600;1,8..60,300;1,8..60,400&family=Source+Sans+3:wght@300;400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <link rel="stylesheet" href="inc/css/style.css">
</head>
<body>

<!-- UTILITY BAR -->
<div class="util-bar">
  <div class="util-bar__left">
    <a href="#"><svg data-feather="star"></svg>Chronique de Guerre Iran</a>
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
  <div class="nav-logo"><a href="index.php">Chronique de Guerre Iran</a></div>
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
      <li class="<?php echo $cat['slug'] === 'international' ? 'active' : ''; ?>">
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

<!-- ARTICLE -->
<div class="article-wrap">

  <div class="kicker">
    <span><?php echo htmlspecialchars($article['category_name'] ?? 'Actualités'); ?></span>
    <span class="bullet">/</span>
    <span class="hot"><?php echo htmlspecialchars(substr($article['category_name'], 0, 10)); ?></span>
  </div>

  <h1 class="article-title"><?php echo htmlspecialchars($article['title']); ?></h1>

  <div class="byline">Par <a href="#"><?php echo htmlspecialchars($article['author'] ?? 'Rédaction'); ?></a></div>
  <div class="article-meta">
    <svg data-feather="clock"></svg>
    Publié le <?php echo date('d M Y', strtotime($article['published_at'])); ?> à <?php echo date('H:i', strtotime($article['published_at'])); ?> &nbsp;·&nbsp; Mis à jour le <?php echo date('d M Y', strtotime($article['updated_at'])); ?>
  </div>

  <div class="article-actions">
    <button class="act-btn"><svg data-feather="share-2"></svg> Partager</button>
    <button class="act-btn"><svg data-feather="bookmark"></svg> Sauvegarder</button>
    <button class="act-btn"><svg data-feather="message-circle"></svg> Commenter <span class="count">0</span></button>
    <button class="act-btn"><svg data-feather="gift"></svg> Offrir</button>
    <span class="act-spacer"></span>
    <button class="act-btn"><svg data-feather="printer"></svg></button>
    <button class="act-btn"><svg data-feather="type"></svg></button>
  </div>

  <!-- Hero -->
  <div class="hero" style="background-image: url('<?php echo htmlspecialchars($heroImage); ?>'); background-size: cover; background-position: center;">
    <div class="hero-caption-text"><?php echo htmlspecialchars($article['title']); ?> | Article</div>
  </div>
  <div class="caption">
    <?php echo htmlspecialchars($heroCaption); ?>
  </div>

  <!-- Galerie d'images supplémentaires -->
  <?php if (count($images) > 1): ?>
  <div style="margin: 30px 0; display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
    <?php foreach (array_slice($images, 1) as $img): ?>
    <div style="border-radius: 4px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
      <img src="<?php echo htmlspecialchars($img['image_url']); ?>" alt="<?php echo htmlspecialchars($img['caption'] ?? ''); ?>" style="width: 100%; height: 250px; object-fit: cover;">
      <?php if (!empty($img['caption'])): ?>
      <p style="padding: 12px; font-size: 13px; line-height: 1.5; background: #f5f5f5;"><?php echo htmlspecialchars($img['caption']); ?></p>
      <?php endif; ?>
    </div>
    <?php endforeach; ?>
  </div>
  <?php endif; ?>

  <div class="sub-tag"><svg data-feather="lock"></svg> Contenu disponible</div>

  <div class="body">
    <?php echo $article['content']; ?>
  </div>

</div><!-- /article-wrap -->

<!-- AUTRES ARTICLES (SUGGESTIONS) -->
<?php if (!empty($otherArticles)): ?>
<section style="background: #f8f9fa; padding: 40px 20px; margin-top: 40px;">
  <div style="max-width: 1000px; margin: 0 auto;">
    <h2 style="font-family: 'Playfair Display', serif; font-size: 32px; margin-bottom: 30px; font-weight: 700;">À lire aussi</h2>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px;">
      <?php foreach ($otherArticles as $suggested): ?>
      <div style="background: white; border-radius: 4px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
        <div style="overflow: hidden; height: 200px; background: #e0e0e0;">
          <img src="<?php echo htmlspecialchars($suggested['image_url'] ?? ''); ?>" alt="<?php echo htmlspecialchars($suggested['title']); ?>" style="width: 100%; height: 100%; object-fit: cover;">
        </div>
        <div style="padding: 16px;">
          <div style="font-size: 12px; color: #666; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">
            <?php echo htmlspecialchars($suggested['category_name'] ?? 'Actualités'); ?>
          </div>
          <h3 style="font-family: 'Playfair Display', serif; font-size: 18px; margin-bottom: 10px; line-height: 1.3;">
            <?php echo htmlspecialchars($suggested['title']); ?>
          </h3>
          <p style="font-size: 14px; color: #666; line-height: 1.5; margin-bottom: 12px;">
            <?php echo htmlspecialchars(substr($suggested['description'] ?? '', 0, 100)) . '...'; ?>
          </p>
          <a href="article.php?id=<?php echo $suggested['id']; ?>" style="color: #0057a8; text-decoration: none; font-weight: 600; font-size: 14px;">
            Lire l'article →
          </a>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<hr class="div" style="margin-top:40px;">

<!-- FOOTER -->
<footer>
  <div class="footer-main">
    <div class="footer-logo">Chronique de Guerre Iran</div>
    <div class="fcol">
      <h4>Chronique de Guerre Iran</h4>
      <a href="index.php"><svg data-feather="home"></svg>À la une</a>
      <a href="#"><svg data-feather="archive"></svg>Archives</a>
      <a href="#"><svg data-feather="mail"></svg>Newsletters</a>
      <a href="#"><svg data-feather="mic"></svg>Podcasts</a>
    </div>
    <div class="fcol">
      <h4>International</h4>
      <a href="category.php?slug=international">Actualités Internationales</a>
      <a href="#">Amériques</a>
      <a href="#">Asie</a>
      <a href="#">Europe</a>
      <a href="#">Moyen-Orient</a>
    </div>
  </div>
  <div class="footer-bottom">
    <span style="color:#2e2e2e;">© Chronique de Guerre Iran 2025</span>
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
