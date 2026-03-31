<?php include __DIR__ . '/../layout/admin-header.php' ?>

<div class="admin-container">

    <div class="admin-page-header">
        <h1>Articles</h1>
        <p>Gérez les articles publiés et les brouillons.</p>
    </div>

    <?php if (!empty($successMessage)): ?>
        <div class="alert alert-success">
            <svg data-feather="check-circle"></svg>
            <?php echo htmlspecialchars($successMessage); ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($errorMessage)): ?>
        <div class="alert alert-danger">
            <svg data-feather="alert-circle"></svg>
            <?php echo htmlspecialchars($errorMessage); ?>
        </div>
    <?php endif; ?>

    <!-- Actions rapides -->
    <div style="display:flex; justify-content:flex-end; margin-bottom:16px;">
        <a href="/admin/article" class="admin-btn-primary">
            <svg data-feather="plus" width="14" height="14"></svg>
            Nouvel article
        </a>
    </div>

    <!-- Tableau -->
    <div class="admin-card" style="padding:0;">
        <div class="admin-card__title" style="padding:16px 24px; margin:0;">
            <svg data-feather="file-text"></svg>
            <?php echo count($articles); ?> article<?php echo count($articles) > 1 ? 's' : ''; ?>
        </div>

        <?php if (empty($articles)): ?>
            <div style="padding:40px; text-align:center; color:var(--gray-400); font-family:var(--sans); font-size:13px;">
                <svg data-feather="inbox" width="32" height="32" style="display:block;margin:0 auto 12px;stroke:var(--gray-200);"></svg>
                Aucun article pour le moment.
            </div>
        <?php else: ?>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Titre</th>
                    <th>Catégorie</th>
                    <th>Auteur</th>
                    <th>Date</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($articles as $art): ?>
                <tr>
                    <td>
                        <span class="admin-table__title">
                            <?php echo htmlspecialchars($art['title']); ?>
                        </span>
                        <?php if ($art['is_featured']): ?>
                            <span class="admin-badge admin-badge--featured">
                                <svg data-feather="star" width="10" height="10"></svg> Une
                            </span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <span class="admin-badge admin-badge--category">
                            <?php echo htmlspecialchars($art['category_name'] ?? '—'); ?>
                        </span>
                    </td>
                    <td style="font-family:var(--sans);font-size:12px;color:var(--gray-600);">
                        <?php echo htmlspecialchars($art['author'] ?? '—'); ?>
                    </td>
                    <td style="font-family:var(--sans);font-size:12px;color:var(--gray-400);white-space:nowrap;">
                        <?php if (!empty($art['published_at'])): ?>
                            <?php echo date('d M Y', strtotime($art['published_at'])); ?>
                        <?php else: ?>
                            —
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if (!empty($art['published_at'])): ?>
                            <span class="admin-badge admin-badge--published">Publié</span>
                        <?php else: ?>
                            <span class="admin-badge admin-badge--draft">Brouillon</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <div class="admin-table__actions">
                            <!-- Voir -->
                            <a href="/<?php echo $art['id']; ?>/article/<?php echo generateSlug($art['title']); ?>"
                               class="admin-action-btn" title="Voir" target="_blank">
                                <svg data-feather="eye" width="13" height="13"></svg>
                            </a>

                            <!-- Éditer -->
                            <a href="/admin/article/edit?id=<?php echo $art['id']; ?>"
                               class="admin-action-btn" title="Éditer">
                                <svg data-feather="edit-2" width="13" height="13"></svg>
                            </a>

                            <!-- Publier / Dépublier -->
                            <form method="post" action="/admin/articles" style="display:inline;">
                                <input type="hidden" name="action" value="toggle_publish">
                                <input type="hidden" name="id" value="<?php echo $art['id']; ?>">
                                <button type="submit" class="admin-action-btn"
                                        title="<?php echo !empty($art['published_at']) ? 'Dépublier' : 'Publier'; ?>">
                                    <svg data-feather="<?php echo !empty($art['published_at']) ? 'eye-off' : 'send'; ?>"
                                         width="13" height="13"></svg>
                                </button>
                            </form>

                            <!-- Mettre à la une -->
                            <form method="post" action="/admin/articles" style="display:inline;">
                                <input type="hidden" name="action" value="toggle_featured">
                                <input type="hidden" name="id" value="<?php echo $art['id']; ?>">
                                <button type="submit" class="admin-action-btn <?php echo $art['is_featured'] ? 'admin-action-btn--active' : ''; ?>"
                                        title="<?php echo $art['is_featured'] ? 'Retirer de la une' : 'Mettre à la une'; ?>">
                                    <svg data-feather="star" width="13" height="13"></svg>
                                </button>
                            </form>

                            <!-- Supprimer -->
                            <form method="post" action="/admin/articles" style="display:inline;"
                                  onsubmit="return confirm('Supprimer cet article ?')">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?php echo $art['id']; ?>">
                                <button type="submit" class="admin-action-btn admin-action-btn--danger" title="Supprimer">
                                    <svg data-feather="trash-2" width="13" height="13"></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>
    </div>
</div>

<?php include __DIR__ . '/../layout/admin-footer.php' ?>