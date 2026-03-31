<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle ?? 'Administration'); ?></title>
    <?php
        $styleFile   = __DIR__ . '/../../inc/css/style.css';
        $editorFile  = __DIR__ . '/../../inc/css/editor.css';
        $featherFile = __DIR__ . '/../../inc/js/feather.min.js';
        $styleV   = file_exists($styleFile)   ? filemtime($styleFile)   : time();
        $editorV  = file_exists($editorFile)  ? filemtime($editorFile)  : time();
        $featherV = file_exists($featherFile) ? filemtime($featherFile) : time();
    ?>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=Source+Serif+4:opsz,wght@8..60,300;8..60,400;8..60,600&family=Source+Sans+3:wght@300;400;600;700&display=swap" rel="stylesheet">
    <script defer src="<?= BASE_URL ?>/inc/js/feather.min.js?v=<?= $featherV ?>"></script>
    <link rel="stylesheet" href="<?= BASE_URL ?>/inc/css/style.css?v=<?= $styleV ?>">
    <link rel="stylesheet" href="<?= BASE_URL ?>/inc/css/editor.css?v=<?= $editorV ?>">
</head>
<body class="admin-page">

<!-- ADMIN TOP BAR -->
<div class="admin-topbar">
    <div class="admin-topbar__left">
        <span class="admin-topbar__logo">
            Chronique de Guerre Iran
        </span>
        <span class="admin-topbar__sep">|</span>
        <span class="admin-topbar__badge">
            <svg data-feather="shield" width="11" height="11"></svg>
            Backoffice
        </span>
    </div>
    <div class="admin-topbar__right">
        <span class="admin-topbar__user">
            <svg data-feather="user" width="12" height="12"></svg>
            <?php echo htmlspecialchars($_SESSION['username'] ?? 'Admin'); ?>
        </span>
        <a href="/logout" class="admin-topbar__logout">
            <svg data-feather="log-out" width="12" height="12"></svg>
            Déconnexion
        </a>
    </div>
</div>

<!-- ADMIN NAV -->
<nav class="admin-nav">
    <div class="admin-nav__inner">
        <div class="admin-nav__links">
            <a href="/admin/article" class="admin-nav__link <?= ($_GET['page'] ?? '') === 'admin-article' ? 'active' : '' ?>">
                <svg data-feather="edit-2"></svg>
                Nouvel article
            </a>
            <a href="/admin/articles" class="admin-nav__link">
                <svg data-feather="list"></svg>
                Articles
            </a>
            <a href="/admin/diffusions" class="admin-nav__link">
                <svg data-feather="radio"></svg>
                Diffusions
            </a>
            <a href="/admin/categories" class="admin-nav__link">
                <svg data-feather="tag"></svg>
                Catégories
            </a>
        </div>
        <a href="/" class="admin-nav__site" >
            <svg data-feather="external-link"></svg>
            Voir le site
        </a>
    </div>
</nav>