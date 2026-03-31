<article class="article-card">
    <a href="<?= BASE_URL ?>/article/<?php echo $article['id']; ?>" class="card-link">
        <div class="card-image">
            <img src="<?php echo htmlspecialchars($article['image_url']); ?>" alt="">
        </div>
        <div class="card-content">
            <span class="card-category"><?php echo htmlspecialchars($article['category_name']); ?></span>
            <h3 class="card-title"><?php echo htmlspecialchars($article['title']); ?></h3>
            <p class="card-excerpt"><?php echo htmlspecialchars($article['description']); ?></p>
            <div class="card-meta">
                <span class="card-author"><?php echo htmlspecialchars($article['author']); ?></span>
                <span class="card-date"><?php echo date('d/m/Y', strtotime($article['published_at'])); ?></span>
            </div>
        </div>
    </a>
</article>
