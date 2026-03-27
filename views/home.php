<?php
$pageTitle = 'Le Monde – Actualités';
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
            <div class="thumb-inner" style="background: linear-gradient(140deg, #1a2535, #2e4258); background-image: url('<?php echo htmlspecialchars($article['image_url'] ?? ''); ?>');">
            </div>
          </div>
          <div class="ckicker"><?php echo htmlspecialchars($article['category_name'] ?? 'Actualités'); ?></div>
          <div class="card-title"><?php echo htmlspecialchars($article['title']); ?></div>
          <div class="card-desc"><?php echo htmlspecialchars(substr($article['description'] ?? '', 0, 150) . '...'); ?></div>
          <div style="font-size: 12px; color: #999; margin-top: 12px; margin-bottom: 12px;">
            <?php echo getTimeAgo($article['published_at']); ?> · <?php echo date('d M Y', strtotime($article['published_at'])); ?>
          </div>
          <a href="?page=article&id=<?php echo $article['id']; ?>" style="margin-top: 12px; display: block; color: #0057a8; text-decoration: none; font-weight: 600;">Lire plus →</a>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p>Aucun article disponible pour le moment.</p>
    <?php endif; ?>
  </div>
</div>

<?php include __DIR__ . '/layout/footer.php'; ?>
