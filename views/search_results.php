<?php
include __DIR__ . '/layout/header.php';
?>

<main id="main-content">
  <h1 class="sr-only">Résultats de recherche</h1>

  <!-- SEARCH RESULTS GRID -->
  <div class="section">
    <div class="sect-header">
      <h2>Résultats pour "<?php echo htmlspecialchars($searchTerm); ?>"</h2>
      <p class="text-secondary"><?php echo count($articles); ?> résultat(s) trouvé(s)</p>
    </div>

    <?php if (!empty($articles)): ?>
      <div class="grid3">
        <?php foreach ($articles as $article): ?>
          <div class="card">
            <div class="thumb">
              <div class="thumb-inner gradient-hero-1" style="background-image: url('<?php echo htmlspecialchars(getImageUrl($article['image_url'] ?? '')); ?>');">
              </div>
            </div>
            <div class="ckicker"><?php echo htmlspecialchars($article['category_name'] ?? 'Actualités'); ?></div>
            <div class="card-title"><a href="<?= BASE_URL ?>/<?php echo $article['id']; ?>/article/<?php echo generateSlug($article['title']); ?>"><?php echo htmlspecialchars($article['title']); ?></a></div>
            <div class="card-desc"><?php echo htmlspecialchars(substr($article['description'] ?? '', 0, 150) . '...'); ?></div>
            <div class="card-date">
              <span class="text-secondary"><?php echo getTimeAgo($article['published_at']); ?> · <?php echo date('d M Y', strtotime($article['published_at'])); ?></span>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php else: ?>
      <div class="section">
        <p>Aucun article ne correspond à votre recherche.</p>
      </div>
    <?php endif; ?>
  </div>

</main>

<?php include __DIR__ . '/layout/footer.php'; ?>
