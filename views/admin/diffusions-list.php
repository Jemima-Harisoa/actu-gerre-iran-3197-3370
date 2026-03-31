<?php include __DIR__ . '/../layout/admin-header.php' ?>

<div class="admin-container">

    <div class="admin-page-header">
        <h1>Diffusions en direct</h1>
        <p>Gérez le fil d'actualités en direct affiché dans le bandeau.</p>
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

    <!-- Formulaire ajout rapide -->
    <div class="admin-card">
        <div class="admin-card__title">
            <svg data-feather="plus-circle"></svg>
            Ajouter une diffusion
        </div>
        <form method="post" action="/admin/diffusions" style="display:flex;gap:12px;align-items:flex-end;">
            <input type="hidden" name="action" value="create">
            <div class="form-group" style="flex:1;margin:0;">
                <label for="new_title">Titre de la diffusion</label>
                <input type="text" id="new_title" name="title" class="form-control"
                       placeholder="Ex: Nouvelles frappes sur Téhéran…" required>
            </div>
            <div class="form-group" style="margin:0;">
                <label for="new_status">Statut</label>
                <select id="new_status" name="status" class="form-control">
                    <option value="en_cours">En cours</option>
                    <option value="a_predire">À venir</option>
                    <option value="fini">Terminé</option>
                </select>
            </div>
            <button type="submit" class="admin-btn-primary" style="flex-shrink:0;">
                <svg data-feather="plus" width="13" height="13"></svg>
                Ajouter
            </button>
        </form>
    </div>

    <!-- Tableau -->
    <div class="admin-card" style="padding:0;">
        <div class="admin-card__title" style="padding:16px 24px;margin:0;">
            <svg data-feather="radio"></svg>
            <?php echo count($diffusions); ?> diffusion<?php echo count($diffusions) > 1 ? 's' : ''; ?>
        </div>

        <?php if (empty($diffusions)): ?>
            <div style="padding:40px;text-align:center;color:var(--gray-400);font-family:var(--sans);font-size:13px;">
                <svg data-feather="inbox" width="32" height="32" style="display:block;margin:0 auto 12px;stroke:var(--gray-200);"></svg>
                Aucune diffusion pour le moment.
            </div>
        <?php else: ?>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Titre</th>
                    <th>Statut</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($diffusions as $diff): ?>
                <tr>
                    <td>
                        <span class="admin-table__title">
                            <?php echo htmlspecialchars($diff['title']); ?>
                        </span>
                    </td>
                    <td>
                        <?php
                            $statusLabels = [
                                'en_cours'  => ['label' => 'En cours',  'class' => 'published'],
                                'a_predire' => ['label' => 'À venir',   'class' => 'draft'],
                                'fini'      => ['label' => 'Terminé',   'class' => 'category'],
                            ];
                            $statusName = $diff['status_name'] ?? 'en_cours';
                            $statusInfo = $statusLabels[$statusName] ?? ['label' => $statusName, 'class' => 'category'];
                        ?>
                        <span class="admin-badge admin-badge--<?php echo $statusInfo['class']; ?>">
                            <?php echo $statusInfo['label']; ?>
                        </span>
                    </td>
                    <td style="font-family:var(--sans);font-size:12px;color:var(--gray-400);white-space:nowrap;">
                        <?php if (!empty($diff['created_at'])): ?>
                            <?php echo date('d M Y à H:i', strtotime($diff['created_at'])); ?>
                        <?php else: ?>
                            —
                        <?php endif; ?>
                    </td>
                    <td>
                        <div class="admin-table__actions">
                            <!-- Changer statut -->
                            <form method="post" action="/admin/diffusions" style="display:inline;">
                                <input type="hidden" name="action" value="update_status">
                                <input type="hidden" name="id" value="<?php echo $diff['id']; ?>">
                                <select name="status" class="form-control"
                                        style="padding:4px 8px;font-size:11px;height:28px;width:auto;"
                                        onchange="this.form.submit()">
                                    <option value="en_cours"  <?php echo $statusName === 'en_cours'  ? 'selected' : ''; ?>>En cours</option>
                                    <option value="a_predire" <?php echo $statusName === 'a_predire' ? 'selected' : ''; ?>>À venir</option>
                                    <option value="fini"      <?php echo $statusName === 'fini'      ? 'selected' : ''; ?>>Terminé</option>
                                </select>
                            </form>

                            <!-- Supprimer -->
                            <form method="post" action="/admin/diffusions" style="display:inline;"
                                  onsubmit="return confirm('Supprimer cette diffusion ?')">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?php echo $diff['id']; ?>">
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