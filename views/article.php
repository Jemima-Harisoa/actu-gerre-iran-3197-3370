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
    Publié le <?php echo date('d M Y', strtotime($article['published_at'])); ?> à <?php echo date('H:i', strtotime($article['published_at'])); ?> &nbsp;·&nbsp; Mis à jour le <?php echo date('d M Y', strtotime($article['updated_at'])); ?>
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
  <div style="margin: 30px 0; display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
    <?php foreach (array_slice($images, 1) as $img): ?>
    <div style="border-radius: 4px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
      <img src="<?php echo htmlspecialchars($img['image_url']); ?>" alt="<?php echo htmlspecialchars($img['caption'] ?? ''); ?>" style="width: 100%; height: 250px; object-fit: cover;">
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
<section style="background: #f8f9fa; padding: 40px 20px; margin-top: 40px;">
  <div style="max-width: 1000px; margin: 0 auto;">
    <h2 style="font-family: 'Playfair Display', serif; font-size: 32px; margin-bottom: 30px; font-weight: 700;">À lire aussi</h2>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px;">
      <?php foreach ($otherArticles as $suggested): ?>
      <div style="background: white; border-radius: 4px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
        <div style="overflow: hidden; height: 200px; background: #e0e0e0;">
          <img src="<?php echo htmlspecialchars($suggested['image_url'] ?? ''); ?>" alt="<?php echo htmlspecialchars($suggested['title']); ?>" style="width: 100%; height: 100%; object-fit: cover;">
        </div>
        <div style="padding: 16px;">
          <div style="font-size: 12px; color: #666; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">
            <?php echo htmlspecialchars($suggested['category_name'] ?? 'Actualités'); ?>
          </div>
          <h3 style="font-family: 'Playfair Display', serif; font-size: 18px; margin-bottom: 10px; line-height: 1.3;">
            <?php echo htmlspecialchars($suggested['title']); ?>
          </h3>
          <p style="font-size: 14px; color: #666; line-height: 1.5; margin-bottom: 12px;">
            <?php echo htmlspecialchars(substr($suggested['description'] ?? '', 0, 100)) . '...'; ?>
          </p>
          <a href="?page=article&id=<?php echo $suggested['id']; ?>" style="color: #0057a8; text-decoration: none; font-weight: 600; font-size: 14px;">
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
