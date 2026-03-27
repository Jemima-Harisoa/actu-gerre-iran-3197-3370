<?php
$pageTitle = htmlspecialchars($article['title'] ?? 'Article') . ' - Le Monde';
include __DIR__ . '/layout/header.php';
?>

<!-- ARTICLE -->
<div class="article-wrap">

  <div class="kicker">
    <span><?php echo htmlspecialchars($article['category_name'] ?? 'Actualités'); ?></span>
    <span class="bullet">/</span>
    <span class="hot"><?php echo htmlspecialchars(substr($article['category_name'], 0, 10)); ?></span>
  </div>

  <h1 class="article-title"><?php echo htmlspecialchars($article['title']); ?></h1>

  <div class="byline">Par <a href="#"><?php echo htmlspecialchars($article['author'] ?? 'Rédaction'); ?></a></div>
  <div class="article-meta">
    <svg data-feather="clock"></svg>
    Publié le <?php echo date('d M Y', strtotime($article['published_at'])); ?> à <?php echo date('H:i', strtotime($article['published_at'])); ?> <span class="text-muted">(<?php echo getTimeAgo($article['published_at']); ?>)</span> &nbsp;·&nbsp; Mis à jour le <?php echo date('d M Y', strtotime($article['updated_at'])); ?>
  </div>

  <div class="article-actions">
    <button class="act-btn"><svg data-feather="share-2"></svg> Partager</button>
    <button class="act-btn"><svg data-feather="bookmark"></svg> Sauvegarder</button>
    <button class="act-btn"><svg data-feather="message-circle"></svg> Commenter <span class="count">0</span></button>
    <button class="act-btn"><svg data-feather="gift"></svg> Offrir</button>
    <span class="act-spacer"></span>
    <button class="act-btn"><svg data-feather="printer"></svg></button>
    <button class="act-btn"><svg data-feather="type"></svg></button>
  </div>

  <!-- Hero -->
  <div class="hero" style="background-image: url('<?php echo htmlspecialchars($heroImage); ?>'); background-size: cover; background-position: center;">
    <div class="hero-caption-text"><?php echo htmlspecialchars($article['title']); ?> | Article</div>
  </div>
  <div class="caption">
    <?php echo htmlspecialchars($heroCaption); ?>
  </div>

  <!-- Galerie d'images supplémentaires -->
  <?php if (count($images) > 1): ?>
  <div class="mt-30" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
    <?php foreach (array_slice($images, 1) as $img): ?>
    <div class="img-rounded">
      <img src="<?php echo htmlspecialchars($img['image_url']); ?>" alt="<?php echo htmlspecialchars($img['caption'] ?? ''); ?>" class="img-cover">
      <?php if (!empty($img['caption'])): ?>
      <p style="padding: 12px; font-size: 13px; line-height: 1.5; background: #f5f5f5;"><?php echo htmlspecialchars($img['caption']); ?></p>
      <?php endif; ?>
    </div>
    <?php endforeach; ?>
  </div>
  <?php endif; ?>

  <div class="sub-tag"><svg data-feather="lock"></svg> Contenu disponible</div>

  <div class="body">
    <?php echo $article['content']; ?>
  </div>

</div><!-- /article-wrap -->

<!-- AUTRES ARTICLES (SUGGESTIONS) -->
<?php if (!empty($otherArticles)): ?>
<section class="section-hero">
  <div class="container">
    <h2 class="section-title">À lire aussi</h2>
    <div class="cards-grid-featured">
      <?php foreach ($otherArticles as $suggested): ?>
      <div class="card-featured">
        <div class="img-bg">
          <img src="<?php echo htmlspecialchars($suggested['image_url'] ?? ''); ?>" alt="<?php echo htmlspecialchars($suggested['title']); ?>" class="img-cover">
        </div>
        <div class="card-featured-content">
          <div class="card-featured-kicker">
            <?php echo htmlspecialchars($suggested['category_name'] ?? 'Actualités'); ?>
          </div>
          <h3 class="card-featured-title">
            <?php echo htmlspecialchars($suggested['title']); ?>
          </h3>
          <p class="card-featured-desc">
            <?php echo htmlspecialchars(substr($suggested['description'] ?? '', 0, 100)) . '...'; ?>
          </p>
          <a href="?page=article&id=<?php echo $suggested['id']; ?>" class="link-primary link-block-sm">
            Lire l'article →
          </a>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<?php include __DIR__ . '/layout/footer.php'; ?>
