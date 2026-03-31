<?php include __DIR__ . '/../layout/admin-header.php' ?>

<main class="container container-sm">

  <h1 class="section-title-lg">Rédiger un article</h1>
  <p class="section-subtitle">Créez un contenu avec texte, images et vidéos.</p>

  <form method="post" enctype="multipart/form-data" class="editor-form">

    <!-- Titre -->
    <div class="form-group">
      <label>Titre</label>
      <input type="text" name="title" class="form-control" required>
    </div>

    <!-- Catégorie -->
    <div class="form-group">
        <select name="category_id" class="form-control" required>
            <?php foreach ($categoriesForSelect as $cat): ?>
                <option value="<?php echo $cat['id']; ?>">
                    <?php echo htmlspecialchars($cat['name']); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <!-- Image principale -->
    <div class="form-group">
      <label>Image principale</label>
      <input type="file" name="image" class="form-control">
    </div>

    <!-- Toolbar -->
    <div class="editor-toolbar">
      <button type="button" onclick="format('bold')">B</button>
      <button type="button" onclick="format('italic')">I</button>
      <button type="button" onclick="format('insertUnorderedList')">• List</button>
      <button type="button" onclick="insertImage()">Image</button>
      <button type="button" onclick="insertVideo()">Vidéo</button>
    </div>

    <!-- Zone éditeur -->
    <div id="editor" class="editor-content" contenteditable="true"></div>

    <!-- Hidden input -->
    <textarea name="content" id="content" hidden></textarea>

    <!-- Action button -->
    <div class="editor-actions">
        <button type="submit" name="action" value="publish">Publier</button>
        <button type="submit" name="action" value="draft">Brouillon</button>
    </div>
  </form>

</main>
<script>
function format(cmd) {
  document.execCommand(cmd, false, null);
}

function insertImage() {
  const url = prompt("URL de l'image");
  if (url) {
    document.execCommand('insertImage', false, url);
  }
}

function insertVideo() {
  const url = prompt("Lien YouTube (embed)");
  if (url) {
    const iframe = `<iframe src="${url}" frameborder="0" allowfullscreen></iframe>`;
    document.execCommand('insertHTML', false, iframe);
  }
}

/* Avant submit → injecter contenu HTML */
document.querySelector("form").addEventListener("submit", function() {
  document.getElementById("content").value = document.getElementById("editor").innerHTML;
});
</script>
<?php include __DIR__ . '/../layout/admin-footer.php' ?>
