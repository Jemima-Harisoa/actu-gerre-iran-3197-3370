<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle ?? 'Chronique de Guerre Iran – Actualités'); ?></title>
    <meta name="description" content="<?php echo htmlspecialchars($pageTitle ?? 'Chronique de Guerre Iran – Actualités'); ?>">
    <?php
      $featherFile = __DIR__ . '/../../inc/js/feather.min.js';
      $styleFile = __DIR__ . '/../../inc/css/style.css';
      $faviconFile = __DIR__ . '/../../inc/img/placeholder/default.svg';
      $featherVersion = file_exists($featherFile) ? filemtime($featherFile) : time();
      $styleVersion = file_exists($styleFile) ? filemtime($styleFile) : time();
      $faviconVersion = file_exists($faviconFile) ? filemtime($faviconFile) : time();
    ?>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;0,900;1,400;1,700&family=Source+Serif+4:ital,opsz,wght@0,8..60,300;0,8..60,400;0,8..60,600;1,8..60,300;1,8..60,400&family=Source+Sans+3:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="icon" type="image/svg+xml" href="<?= BASE_URL ?>/inc/img/placeholder/default.svg?v=<?php echo $faviconVersion; ?>">
    <script defer src="<?= BASE_URL ?>/inc/js/feather.min.js?v=<?php echo $featherVersion; ?>"></script>
    <link rel="stylesheet" href="<?= BASE_URL ?>/inc/css/style.css?v=<?php echo $styleVersion; ?>">
    <script>
        function toggleSearch() {
            const searchContainer = document.getElementById('search-bar-container');
            searchContainer.classList.toggle('active');
            if (searchContainer.classList.contains('active')) {
                searchContainer.querySelector('input').focus();
            }
        }
    </script>
</head>
<body>

<!-- UTILITY BAR -->
<div class="util-bar">
  <div class="util-bar__left">
    <a href="<?php echo BASE_URL !== '' ? BASE_URL : '/'; ?>" aria-label="Accueil - Chronique de Guerre Iran"><svg data-feather="star"></svg>Chronique de Guerre Iran</a>
    <a href="#" aria-label="Télécharger l'application mobile"><svg data-feather="smartphone"></svg>Application</a>
    <a href="#" aria-label="S'inscrire à nos newsletters"><svg data-feather="mail"></svg>Newsletters</a>
    <a href="#" aria-label="Écouter nos podcasts"><svg data-feather="mic"></svg>Podcasts</a>
  </div>
  <?php if (!empty($_SESSION['user_id'])): ?>
    <div class="util-bar__right">
      <a href="#"><svg data-feather="user"></svg>Mon compte</a>
      <a href="/logout"><svg data-feather="log-out"></svg>Se déconnecter</a>
    </div>
  <?php else: ?>
    <div class="util-bar__right">
      <a href="/login"><svg data-feather="log-in"></svg>Se connecter</a>
      <button class="btn-sub-util">S'abonner</button>
    </div>
  <?php endif;?>
</div>

<!-- MAIN NAV -->
<nav class="main-nav">
  <div class="nav-left">
    <button class="nav-btn" aria-label="Ouvrir le menu de navigation">
      <svg data-feather="menu" aria-hidden="true"></svg>
      <span class="sr-only">Menu</span>
    </button>
    <button class="nav-btn search" onclick="toggleSearch()" aria-label="Ouvrir la barre de recherche">
      <svg data-feather="search" aria-hidden="true"></svg>
      <span class="sr-only">Rechercher</span>
    </button>
  </div>
  <div class="nav-logo"><a href="<?php echo BASE_URL !== '' ? BASE_URL : '/'; ?>" aria-label="Chronique de Guerre Iran - Logo">Chronique de Guerre Iran</a></div>
  <div class="nav-right">
    <div class="search-bar-container" id="search-bar-container">
        <form action="<?= BASE_URL ?>/search.php" method="get">
            <input type="search" name="q" placeholder="Rechercher un article..." class="search-input">
            <button type="submit" class="search-submit-btn" aria-label="Lancer la recherche">
                <svg data-feather="search" aria-hidden="true"></svg>
                <span class="sr-only">Chercher</span>
            </button>
        </form>
    </div>
    <div class="nav-lang">
      <a href="#" aria-label="Français (langue actuelle)" aria-current="page" class="active">FR</a>
      <a href="#" aria-label="English">EN</a>
    </div>
    <button class="btn-sub-nav" aria-label="S'abonner au service">S'abonner</button>
    <button class="nav-icon" aria-label="Ajouter aux favoris"><svg data-feather="bookmark" aria-hidden="true"></svg><span class="sr-only">Favoris</span></button>
    <button class="nav-icon" aria-label="Accéder au profil utilisateur"><svg data-feather="user" aria-hidden="true"></svg><span class="sr-only">Profil</span></button>
  </div>
</nav>

<!-- RUBRIQUE NAV -->
<nav class="rubrique-nav">
  <ul>
    
    <li class="<?php echo isset($activeSlug) && $activeSlug === 'a-la-une' ? 'active' : ''; ?>">
      <a href="<?php echo BASE_URL !== '' ? BASE_URL : '/'; ?>">
        À la une
      </a>
    </li>

    <?php foreach ($categories as $cat): ?>
      <li class="<?php echo isset($activeSlug) && $cat['slug'] === $activeSlug ? 'active' : ''; ?>">
        <a href="<?= BASE_URL ?>/categorie/<?php echo urlencode($cat['slug']); ?>">
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
        <span class="item">Aucune actualité en direct pour le moment</span>
      <?php endif; ?>
    </div>
  </div>
</div>
