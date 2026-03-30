<?php
$pageTitle = htmlspecialchars($category['name'] ?? 'Catégorie') . ' - Le Monde';
include __DIR__ . '/layout/header.php';
?>

<!-- LOGIN FORM -->

<form action="" method="post">
    <div class="container">
        <h1 class="section-title-lg">Connexion</h1>
        <p class="section-subtitle">Veuillez entrer vos identifiants pour vous connecter à votre compte.</p>
    
        <?php if (!empty($errorMessage)): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($errorMessage); ?></div>
        <?php endif; ?>
    
        <div class="form-group">
        <label for="username">Nom d'utilisateur</label>
        <input type="text" id="username" name="username" class="form-control" required>
        </div>
    
        <div class="form-group">
        <label for="password">Mot de passe</label>
        <input type="password" id="password" name="password" class="form-control" required>
        </div>
    
        <button type="submit" class="btn btn-primary">Se connecter</button>
    </div>
</form>

<?php include __DIR__ . '/layout/footer.php'; ?>


