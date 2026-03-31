<?php include __DIR__ . '/../layout/admin-header.php' ?>

<div class="admin-container">

    <!-- En-tête de page -->
    <div class="admin-page-header">
        <h1>Rédiger un article</h1>
        <p>Créez et publiez un article dans le fil d'actualité.</p>
    </div>

    <?php if (!empty($errorMessage)): ?>
        <div class="alert alert-danger">
            <svg data-feather="alert-circle"></svg>
            <?php echo htmlspecialchars($errorMessage); ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($successMessage)): ?>
        <div class="alert alert-success">
            <svg data-feather="check-circle"></svg>
            <?php echo htmlspecialchars($successMessage); ?>
        </div>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data">

        <!-- Carte : Informations générales -->
        <div class="admin-card">
            <div class="admin-card__title">
                <svg data-feather="file-text"></svg>
                Informations générales
            </div>

            <div class="form-group">
                <label for="title">Titre de l'article</label>
                <input type="text" id="title" name="title" class="form-control"
                       placeholder="Entrez le titre de l'article…" required>
            </div>

            <div class="form-group">
                <label for="description">Description courte</label>
                <input type="text" id="description" name="description" class="form-control"
                       placeholder="Résumé visible dans les listes d'articles…">
            </div>

            <div class="form-group">
                <label for="category_id">Catégorie</label>
                <select id="category_id" name="category_id" class="form-control" required>
                    <option value="" disabled selected>— Choisir une catégorie —</option>
                    <?php foreach ($categoriesForSelect as $cat): ?>
                        <option value="<?= $cat['id'] ?>">
                            <?= htmlspecialchars($cat['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <!-- Carte : Contenu -->
        <div class="admin-card">
            <div class="admin-card__title">
                <svg data-feather="edit-3"></svg>
                Contenu de l'article
            </div>

            <!-- Toolbar -->
            <div class="editor-toolbar">
                <button type="button" onclick="fmt('bold')" title="Gras">
                    <strong>B</strong>
                </button>
                <button type="button" onclick="fmt('italic')" title="Italique">
                    <em>I</em>
                </button>
                <button type="button" onclick="fmt('underline')" title="Souligné">
                    <u>U</u>
                </button>
                <div class="toolbar-sep"></div>
                <button type="button" onclick="fmt('insertUnorderedList')" title="Liste à puces">
                    <svg data-feather="list" width="12" height="12"></svg> Liste
                </button>
                <button type="button" onclick="insertLink()" title="Lien">
                    <svg data-feather="link" width="12" height="12"></svg> Lien
                </button>
                <div class="toolbar-sep"></div>
                <button type="button" onclick="insertImage()" title="Image par URL">
                    <svg data-feather="image" width="12" height="12"></svg> Image URL
                </button>
                <button type="button" onclick="insertVideo()" title="Vidéo YouTube">
                    <svg data-feather="youtube" width="12" height="12"></svg> Vidéo
                </button>
            </div>

            <!-- Zone éditeur -->
            <div id="editor" class="editor-content" contenteditable="true"></div>
            <textarea name="content" id="content" hidden></textarea>
        </div>

        <!-- Carte : Médias -->
        <div class="admin-card">
            <div class="admin-card__title">
                <svg data-feather="image"></svg>
                Image principale
            </div>

            <div class="form-group">
                <label for="image">Fichier image (jpg, png, webp)</label>
                <input type="file" id="image" name="image" class="form-control"
                       accept="image/jpeg,image/png,image/webp">
            </div>

            <div class="form-group">
                <label>
                    <input type="checkbox" name="is_featured" value="1">
                    &nbsp;Mettre en avant (À la une)
                </label>
            </div>
        </div>

        <!-- Actions -->
        <div class="editor-actions">
            <button type="submit" name="action" value="publish">
                <svg data-feather="send"></svg>
                Publier
            </button>
            <button type="submit" name="action" value="draft">
                <svg data-feather="save"></svg>
                Enregistrer brouillon
            </button>
        </div>

    </form>

    <!-- Aperçu brouillon -->
    <?php if (!empty($previewArticle)): ?>
        <div class="preview-section">
            <div class="preview-label">
                <svg data-feather="eye"></svg>
                Aperçu du brouillon
            </div>
            <div class="preview-frame">
                <?php
                    $article      = $previewArticle;
                    $heroImage    = $article['image_url'] ?? '';
                    $heroCaption  = $article['description'] ?? '';
                    $images       = [];
                    $otherArticles = [];
                    $isPreview    = true;
                    include __DIR__ . '/preview.php';
                ?>
            </div>
        </div>
    <?php endif; ?>

</div>

<script>
function fmt(cmd) {
    document.execCommand(cmd, false, null);
}

function insertLink() {
    const url = prompt("URL du lien");
    const text = prompt("Texte du lien");
    if (url && text) {
        document.execCommand('insertHTML', false, `<a href="${url}">${text}</a>`);
    }
}

function insertImage() {
    const url = prompt("URL de l'image");
    if (url) document.execCommand('insertImage', false, url);
}

function insertVideo() {
    const url = prompt("Lien YouTube embed (ex: https://www.youtube.com/embed/ID)");
    if (url) {
        document.execCommand('insertHTML', false,
            `<iframe src="${url}" frameborder="0" allowfullscreen style="width:100%;height:320px;"></iframe>`
        );
    }
}

document.querySelector("form").addEventListener("submit", function () {
    document.getElementById("content").value = document.getElementById("editor").innerHTML;
});
</script>

<?php include __DIR__ . '/../layout/admin-footer.php' ?>