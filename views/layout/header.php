<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle ?? 'Le Monde – Actualités'); ?></title>
    <meta name="description" content="<?php echo htmlspecialchars($pageTitle ?? 'Le Monde – Actualités'); ?>">
    <?php
      $featherFile = __DIR__ . '/../../inc/js/feather.min.js';
      $styleFile = __DIR__ . '/../../inc/css/style.css';
      $faviconFile = __DIR__ . '/../../inc/img/placeholder/default.svg';
      $featherVersion = file_exists($featherFile) ? filemtime($featherFile) : time();
      $styleVersion = file_exists($styleFile) ? filemtime($styleFile) : time();
      $faviconVersion = file_exists($faviconFile) ? filemtime($faviconFile) : time();
    ?>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;0,900;1,400;1,700&family=Source+Serif+4:ital,opsz,wght@0,8..60,300;0,8..60,400;0,8..60,600;1,8..60,300;1,8..60,400&family=Source+Sans+3:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="icon" type="image/svg+xml" href="<?php echo BASE_URL; ?>/inc/img/placeholder/default.svg?v=<?php echo $faviconVersion; ?>">
    <script defer src="<?php echo BASE_URL; ?>/inc/js/feather.min.js?v=<?php echo $featherVersion; ?>"></script>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/inc/css/style.css?v=<?php echo $styleVersion; ?>">
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
  <div class="nav-logo"><a href="<?php echo BASE_URL !== '' ? BASE_URL : '/'; ?>">Le Monde</a></div>
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
    
    <li class="<?php echo isset($activeSlug) && $activeSlug === 'a-la-une' ? 'active' : ''; ?>">
      <a href="<?php echo BASE_URL !== '' ? BASE_URL : '/'; ?>">
        À la une
      </a>
    </li>

    <?php foreach ($categories as $cat): ?>
      <li class="<?php echo isset($activeSlug) && $cat['slug'] === $activeSlug ? 'active' : ''; ?>">
        <a href="<?php echo BASE_URL; ?>/categorie/<?php echo urlencode($cat['slug']); ?>">
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
