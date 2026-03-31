<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle ?? 'Le Monde – Actualités'); ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;0,900;1,400;1,700&family=Source+Serif+4:ital,opsz,wght@0,8..60,300;0,8..60,400;0,8..60,600;1,8..60,300;1,8..60,400&family=Source+Sans+3:wght@300;400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <link rel="stylesheet" href="inc/css/style.css">
    <link rel="stylesheet" href="inc/css/editor.css">
</head>
<body>

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
      <label>Catégorie</label>
      <input type="text" name="category" class="form-control">
    </div>

    <!-- Image principale -->
    <div class="form-group">
      <label>Image principale</label>
      <input type="file" name="hero" class="form-control">
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

    <button type="submit" class="btn btn-primary mt-30">Publier</button>

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
</body>
</html>