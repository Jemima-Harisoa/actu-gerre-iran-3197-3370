<?php
$pageTitle = htmlspecialchars($category['name'] ?? 'Catégorie') . ' - Le Monde';
include __DIR__ . '/layout/header.php';
?>

<!-- CATEGORY HEADER -->
<div style="max-width: 1000px; margin: 0 auto; padding: 40px 20px;">
  <h1 style="font-family: 'Playfair Display', serif; font-size: 48px; font-weight: 700; margin-bottom: 15px;">
    <?php echo htmlspecialchars($category['name']); ?>
  </h1>
  <p style="font-size: 16px; color: #666; line-height: 1.6; max-width: 600px;">
    Découvrez nos actualités dans la rubrique "<?php echo htmlspecialchars($category['name']); ?>" - Tous les articles sélectionnés pour vous.
  </p>
</div>

<!-- ARTICLES GRID -->
<div class="section">
  <div class="grid3">
    <?php if (!empty($articles)): ?>
      <?php foreach ($articles as $article): ?>
        <div class="card">
          <div class="thumb">
            <div class="thumb-inner" style="background: linear-gradient(140deg, #1a2535, #2e4258); background-image: url('<?php echo htmlspecialchars($article['image_url'] ?? ''); ?>');">
            </div>
          </div>
          <div class="ckicker"><?php echo htmlspecialchars($article['category_name'] ?? 'Actualités'); ?></div>
          <div class="card-title"><?php echo htmlspecialchars($article['title']); ?></div>
          <div class="card-desc"><?php echo htmlspecialchars(substr($article['description'] ?? '', 0, 150) . '...'); ?></div>
          <a href="?page=article&id=<?php echo $article['id']; ?>" style="margin-top: 12px; display: block; color: #0057a8; text-decoration: none; font-weight: 600;">Lire plus →</a>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p>Aucun article dans cette catégorie pour le moment.</p>
    <?php endif; ?>
  </div>
</div>

<?php include __DIR__ . '/layout/footer.php'; ?>
