<?php
$pageTitle = 'Chronique de Guerre Iran – Actualités';
include __DIR__ . '/layout/header.php';
?>

<!-- ARTICLES GRID -->
<div class="section">
  <div class="sect-header">
    <h2>Dernières actualités</h2>
    <a href="#" class="see-all">Voir tout <svg data-feather="arrow-right"></svg></a>
  </div>
  <div class="grid3">
    <?php if (!empty($articles)): ?>
      <?php foreach ($articles as $article): ?>
        <div class="card">
          <div class="thumb">
            <div class="thumb-inner gradient-hero-1" style="background-image: url('<?php echo htmlspecialchars(getImageUrl($article['image_url'] ?? '')); ?>');">
            </div>
          </div>
          <div class="ckicker"><?php echo htmlspecialchars($article['category_name'] ?? 'Actualités'); ?></div>
          <div class="card-title"><a href="<?php echo BASE_URL; ?>/<?php echo $article['id']; ?>/article/<?php echo generateSlug($article['title']); ?>"><?php echo htmlspecialchars($article['title']); ?></a></div>
          <div class="card-desc"><?php echo htmlspecialchars(substr($article['description'] ?? '', 0, 150) . '...'); ?></div>
          <div class="card-date">
            <span class="text-secondary"><?php echo getTimeAgo($article['published_at']); ?> · <?php echo date('d M Y', strtotime($article['published_at'])); ?></span>
          </div>
          
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p>Aucun article disponible pour le moment.</p>
    <?php endif; ?>
  </div>
</div>

<?php include __DIR__ . '/layout/footer.php'; ?>
