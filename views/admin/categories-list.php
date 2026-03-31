<?php include __DIR__ . '/../layout/admin-header.php' ?>

<div class="admin-container">

    <div class="admin-page-header">
        <h1>Catégories</h1>
        <p>Gérez les rubriques affichées dans la navigation.</p>
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

    <!-- Formulaire ajout -->
    <div class="admin-card">
        <div class="admin-card__title">
            <svg data-feather="plus-circle"></svg>
            Ajouter une catégorie
        </div>
        <form method="post" action="/admin/categories" style="display:flex;gap:12px;align-items:flex-end;">
            <input type="hidden" name="action" value="create">
            <div class="form-group" style="flex:1;margin:0;">
                <label for="new_name">Nom</label>
                <input type="text" id="new_name" name="name" class="form-control"
                       placeholder="Ex: Économie" required>
            </div>
            <div class="form-group" style="flex:1;margin:0;">
                <label for="new_slug">Slug (URL)</label>
                <input type="text" id="new_slug" name="slug" class="form-control"
                       placeholder="ex: economie" required>
            </div>
            <button type="submit" class="admin-btn-primary" style="flex-shrink:0;">
                <svg data-feather="plus" width="13" height="13"></svg>
                Ajouter
            </button>
        </form>
        <p style="font-family:var(--sans);font-size:11px;color:var(--gray-400);margin-top:8px;">
            Le slug doit être en minuscules, sans accents ni espaces (ex: <code>moyen-orient</code>).
        </p>
    </div>

    <!-- Tableau -->
    <div class="admin-card" style="padding:0;">
        <div class="admin-card__title" style="padding:16px 24px;margin:0;">
            <svg data-feather="tag"></svg>
            <?php echo count($categoriesAdmin); ?> catégorie<?php echo count($categoriesAdmin) > 1 ? 's' : ''; ?>
        </div>

        <?php if (empty($categoriesAdmin)): ?>
            <div style="padding:40px;text-align:center;color:var(--gray-400);font-family:var(--sans);font-size:13px;">
                Aucune catégorie pour le moment.
            </div>
        <?php else: ?>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Slug</th>
                    <th>Articles</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categoriesAdmin as $cat): ?>
                <tr>
                    <td>
                        <span class="admin-table__title">
                            <?php echo htmlspecialchars($cat['name']); ?>
                        </span>
                    </td>
                    <td>
                        <code style="font-size:12px;background:var(--gray-100);padding:2px 6px;">
                            <?php echo htmlspecialchars($cat['slug']); ?>
                        </code>
                    </td>
                    <td style="font-family:var(--sans);font-size:12px;color:var(--gray-600);">
                        <?php echo $cat['article_count'] ?? 0; ?> article<?php echo ($cat['article_count'] ?? 0) > 1 ? 's' : ''; ?>
                    </td>
                    <td>
                        <div class="admin-table__actions">
                            <!-- Voir la catégorie -->
                            <a href="/categorie/<?php echo urlencode($cat['slug']); ?>"
                               class="admin-action-btn" title="Voir" target="_blank">
                                <svg data-feather="eye" width="13" height="13"></svg>
                            </a>

                            <!-- Supprimer -->
                            <form method="post" action="/admin/categories" style="display:inline;"
                                  onsubmit="return confirm('Supprimer cette catégorie ? Les articles associés seront également supprimés.')">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?php echo $cat['id']; ?>">
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