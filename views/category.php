<?php
$pageTitle = htmlspecialchars($category['name'] ?? 'Catégorie') . ' - Le Monde';
include __DIR__ . '/layout/header.php';
?>

<!-- CATEGORY HEADER -->
<div class="container">
  <h1 class="section-title-lg">
    <?php echo htmlspecialchars($category['name']); ?>
  </h1>
  <p class="section-subtitle">
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
            <div class="thumb-inner gradient-hero-1" style="background-image: url('<?php echo htmlspecialchars($article['image_url'] ?? ''); ?>');">
            </div>
          </div>
          <div class="ckicker"><?php echo htmlspecialchars($article['category_name'] ?? 'Actualités'); ?></div>
          <div class="card-title"><?php echo htmlspecialchars($article['title']); ?></div>
          <div class="card-desc"><?php echo htmlspecialchars(substr($article['description'] ?? '', 0, 150) . '...'); ?></div>
          <div class="card-date">
            <span class="text-secondary"><?php echo getTimeAgo($article['published_at']); ?> · <?php echo date('d M Y', strtotime($article['published_at'])); ?></span>
          </div>
          <a href="?page=article&id=<?php echo $article['id']; ?>" class="link-block link-block-sm">Lire plus →</a>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p>Aucun article dans cette catégorie pour le moment.</p>
    <?php endif; ?>
  </div>
</div>

<?php include __DIR__ . '/layout/footer.php'; ?>
