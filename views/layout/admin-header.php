<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle ?? 'Administration'); ?></title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/inc/css/style.css">

    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/inc/css/editor.css">

    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+3:wght@300;400;600;700&display=swap" rel="stylesheet">
    <script defer src="<?php echo BASE_URL; ?>/inc/js/feather.min.js"></script>
</head>
<body class="admin-page">

<!-- ADMIN NAV -->
<nav class="admin-nav">
    <div class="admin-nav__logo">
        <a href="/">Chronique de Guerre Iran</a>
        <span class="admin-badge">Admin</span>
    </div>
    <div class="admin-nav__links">
        <a href="/?page=admin-article">
            <svg data-feather="edit"></svg> Nouvel article
        </a>
        <a href="/">
            <svg data-feather="eye"></svg> Voir le site
        </a>
        <a href="/logout">
            <svg data-feather="log-out"></svg> Déconnexion
        </a>
    </div>
</nav>