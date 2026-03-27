<?php
/**
 * Panneau d'Administration Simple
 * admin/index.php
 * 
 * Interface basique pour gérer les articles et actualités en direct
 */

session_start();

require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../model/Article.php';
require_once __DIR__ . '/../model/Diffusion.php';
require_once __DIR__ . '/../model/Statut.php';
require_once __DIR__ . '/../model/Category.php';

$database = new Database();
$pdo = $database->connect();

if (!$pdo) {
    die('Erreur de connexion à la base de données');
}

$articleModel = new Article($pdo);
$diffusionModel = new Diffusion($pdo);
$categoryModel = new Category($pdo);
$statutModel = new Statut($pdo);

// Traiter les soumissions de formulaires
$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    if ($action === 'create_article') {
        try {
            $data = [
                'category_id' => $_POST['category_id'],
                'title' => $_POST['title'],
                'description' => $_POST['description'],
                'content' => $_POST['content'],
                'author' => $_POST['author'] ?? 'Rédaction',
                'image_url' => $_POST['image_url'] ?? '',
                'is_featured' => isset($_POST['is_featured']) ? 1 : 0,
                'published_at' => date('Y-m-d H:i:s')
            ];
            
            if ($articleModel->create($data)) {
                $message = '✅ Article créé avec succès !';
            }
        } catch (Exception $e) {
            $error = '❌ Erreur lors de la création : ' . $e->getMessage();
        }
    }
    
    if ($action === 'create_diffusion') {
        try {
            $diffusionModel->create($_POST['title'], $_POST['status'] ?? 'en_cours');
            $message = '✅ Actualité créée avec succès !';
        } catch (Exception $e) {
            $error = '❌ Erreur lors de la création : ' . $e->getMessage();
        }
    }
    
    if ($action === 'delete_article') {
        try {
            $articleModel->delete($_POST['id']);
            $message = '✅ Article supprimé avec succès !';
        } catch (Exception $e) {
            $error = '❌ Erreur lors de la suppression : ' . $e->getMessage();
        }
    }
    
    if ($action === 'update_diffusion_status') {
        try {
            $diffusionModel->updateStatus($_POST['id'], $_POST['status']);
            $message = '✅ Statut mis à jour !';
        } catch (Exception $e) {
            $error = '❌ Erreur : ' . $e->getMessage();
        }
    }
}

$articles = $articleModel->getAll(100);
$diffusions = $diffusionModel->getAll();
$categories = $categoryModel->getAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panneau d'Administration - Le Monde</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f5f5;
            color: #333;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        header {
            background: #0a0a0a;
            color: #fff;
            padding: 20px;
            margin-bottom: 30px;
            border-radius: 4px;
        }

        h1 {
            margin-bottom: 10px;
        }

        .nav-tabs {
            display: flex;
            gap: 10px;
            margin: 20px 0;
            border-bottom: 2px solid #ddd;
        }

        .nav-tabs button {
            padding: 10px 20px;
            background: #f0f0f0;
            border: none;
            cursor: pointer;
            font-size: 14px;
            border-bottom: 3px solid transparent;
            transition: all 0.3s;
        }

        .nav-tabs button.active {
            background: #fff;
            border-bottom-color: #0a0a0a;
            font-weight: 600;
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        .form-group {
            margin: 15px 0;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
        }

        input,
        select,
        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-family: inherit;
        }

        textarea {
            min-height: 150px;
            resize: vertical;
        }

        button {
            background: #0057a8;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            transition: background 0.3s;
        }

        button:hover {
            background: #004494;
        }

        .success {
            background: #d4edda;
            color: #155724;
            padding: 12px;
            border-radius: 4px;
            margin-bottom: 20px;
        }

        .error {
            background: #f8d7da;
            color: #721c24;
            padding: 12px;
            border-radius: 4px;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            border-radius: 4px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        th,
        td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        th {
            background: #f8f9fa;
            font-weight: 600;
        }

        tr:hover {
            background: #f5f5f5;
        }

        .btn-small {
            padding: 5px 10px;
            font-size: 12px;
            margin: 0 2px;
        }

        .btn-delete {
            background: #dc3545;
        }

        .btn-delete:hover {
            background: #c82333;
        }

        .btn-edit {
            background: #ffc107;
            color: #000;
        }

        .btn-edit:hover {
            background: #e0a800;
        }

        .status {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 3px;
            font-size: 12px;
            font-weight: 600;
        }

        .status.en_cours {
            background: #cce5ff;
            color: #004499;
        }

        .status.fini {
            background: #d4edda;
            color: #155724;
        }

        .status.a_predire {
            background: #fff3cd;
            color: #856404;
        }

        .two-col {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        @media (max-width: 768px) {
            .two-col {
                grid-template-columns: 1fr;
            }

            .nav-tabs {
                flex-wrap: wrap;
            }
        }
    </style>
</head>
<body>

<div class="container">

    <header>
        <h1>🔧 Panneau d'Administration</h1>
        <p>Gestion des articles et actualités en direct</p>
        <p style="margin-top: 10px; font-size: 12px;">
            <a href="../index.php" style="color: #fff; text-decoration: underline;">← Retour au site</a>
        </p>
    </header>

    <?php if ($message): ?>
        <div class="success"><?php echo $message; ?></div>
    <?php endif; ?>
    
    <?php if ($error): ?>
        <div class="error"><?php echo $error; ?></div>
    <?php endif; ?>

    <!-- TABS -->
    <div class="nav-tabs">
        <button class="tab-btn active" onclick="showTab('articles')">📰 Articles (<?php echo count($articles); ?>)</button>
        <button class="tab-btn" onclick="showTab('diffusions')">⚡ En Direct (<?php echo count($diffusions); ?>)</button>
        <button class="tab-btn" onclick="showTab('ajouter-article')">➕ Nouvel Article</button>
        <button class="tab-btn" onclick="showTab('ajouter-diffusion')">➕ Nouvelle Actualité</button>
    </div>

    <!-- TAB: ARTICLES -->
    <div id="articles" class="tab-content active">
        <h2>Articles</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Titre</th>
                    <th>Catégorie</th>
                    <th>Auteur</th>
                    <th>Publié</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($articles as $art): ?>
                <tr>
                    <td><?php echo $art['id']; ?></td>
                    <td><?php echo htmlspecialchars(substr($art['title'], 0, 40)); ?></td>
                    <td><?php echo $art['category_name'] ?? 'N/A'; ?></td>
                    <td><?php echo htmlspecialchars($art['author'] ?? 'Rédaction'); ?></td>
                    <td><?php echo date('d/m/Y H:i', strtotime($art['published_at'])); ?></td>
                    <td>
                        <button class="btn-small btn-edit" onclick="editArticle(<?php echo $art['id']; ?>)">✏️ Éditer</button>
                        <button class="btn-small btn-delete" onclick="deleteArticle(<?php echo $art['id']; ?>)">🗑️ Supprimer</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- TAB: DIFFUSIONS (EN DIRECT) -->
    <div id="diffusions" class="tab-content">
        <h2>Actualités En Direct</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Titre</th>
                    <th>Statut</th>
                    <th>Créé</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($diffusions as $diff): ?>
                <tr>
                    <td><?php echo $diff['id']; ?></td>
                    <td><?php echo htmlspecialchars(substr($diff['title'], 0, 60)); ?></td>
                    <td>
                        <span class="status <?php echo $diff['status_name']; ?>">
                            <?php echo ucfirst(str_replace('_', ' ', $diff['status_name'])); ?>
                        </span>
                    </td>
                    <td><?php echo date('d/m/Y H:i', strtotime($diff['created_at'])); ?></td>
                    <td>
                        <select onchange="changeDiffusionStatus(<?php echo $diff['id']; ?>, this.value)" style="width: auto; padding: 5px;">
                            <option value="en_cours" <?php echo $diff['status_name'] === 'en_cours' ? 'selected' : ''; ?>>En cours</option>
                            <option value="fini" <?php echo $diff['status_name'] === 'fini' ? 'selected' : ''; ?>>Fini</option>
                            <option value="a_predire" <?php echo $diff['status_name'] === 'a_predire' ? 'selected' : ''; ?>>À prédire</option>
                        </select>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- TAB: AJOUTER ARTICLE -->
    <div id="ajouter-article" class="tab-content">
        <h2>Ajouter un Nouvel Article</h2>
        <form method="POST">
            <input type="hidden" name="action" value="create_article">
            <div class="two-col">
                <div>
                    <div class="form-group">
                        <label for="title">Titre *</label>
                        <input type="text" id="title" name="title" required>
                    </div>
                    <div class="form-group">
                        <label for="category">Catégorie *</label>
                        <select id="category" name="category_id" required>
                            <option value="">-- Sélectionnez une catégorie --</option>
                            <?php foreach ($categories as $cat): ?>
                            <option value="<?php echo $cat['id']; ?>"><?php echo htmlspecialchars($cat['name']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="author">Auteur</label>
                        <input type="text" id="author" name="author" value="Rédaction">
                    </div>
                    <div class="form-group">
                        <label for="image_url">URL Image</label>
                        <input type="url" id="image_url" name="image_url" placeholder="https://...">
                    </div>
                </div>
                <div>
                    <div class="form-group">
                        <label for="description">Description courte *</label>
                        <textarea id="description" name="description" required></textarea>
                    </div>
                    <div class="form-group">
                        <label>
                            <input type="checkbox" id="is_featured" name="is_featured" value="1"> Mettre en avant
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="content">Contenu (HTML) *</label>
                <textarea id="content" name="content" required style="min-height: 300px;"></textarea>
            </div>

            <button type="submit">✅ Créer l'article</button>
        </form>
    </div>

    <!-- TAB: AJOUTER DIFFUSION (EN DIRECT) -->
    <div id="ajouter-diffusion" class="tab-content">
        <h2>Ajouter une Nouvelle Actualité</h2>
        <form method="POST">
            <input type="hidden" name="action" value="create_diffusion">
            <div class="form-group">
                <label for="diffusion_title">Titre de l'actualité *</label>
                <input type="text" id="diffusion_title" name="title" required placeholder="Ex: Nouvelle actualité en Iran...">
            </div>

            <div class="form-group">
                <label for="diffusion_status">Statut *</label>
                <select id="diffusion_status" name="status" required>
                    <?php 
                    $allStatuts = $statutModel->getAll();
                    foreach ($allStatuts as $statut): 
                    ?>
                    <option value="<?php echo htmlspecialchars($statut['name']); ?>" 
                        <?php echo $statut['name'] === 'en_cours' ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($statut['name']); ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <button type="submit">✅ Créer l'actualité</button>
        </form>
    </div>
        </form>
    </div>

</div>

<script>
function showTab(tabName) {
    // Hide all tabs
    const tabs = document.querySelectorAll('.tab-content');
    tabs.forEach(tab => tab.classList.remove('active'));

    // Remove active from all buttons
    const buttons = document.querySelectorAll('.tab-btn');
    buttons.forEach(btn => btn.classList.remove('active'));

    // Show selected tab
    document.getElementById(tabName).classList.add('active');

    // Mark button as active
    event.target.classList.add('active');
}

function submitForm(event) {
    // Si le formulaire a une classe 'auto-submit', on le laisse faire son POST normal
    if (event && event.preventDefault) {
        event.preventDefault();
    }
    // Pour les formulaires classiques, on laisse le navigateur gérer le POST
    return true;
}

function changeDiffusionStatus(id, status) {
    // Créer un formulaire caché et le soumettre
    const form = document.createElement('form');
    form.method = 'POST';
    form.innerHTML = `
        <input type="hidden" name="action" value="update_diffusion_status">
        <input type="hidden" name="id" value="${id}">
        <input type="hidden" name="status" value="${status}">
    `;
    document.body.appendChild(form);
    form.submit();
}

function deleteArticle(id) {
    if (confirm('Êtes-vous sûr(e) de vouloir supprimer cet article ?')) {
        // Créer un formulaire caché et le soumettre
        const form = document.createElement('form');
        form.method = 'POST';
        form.innerHTML = `
            <input type="hidden" name="action" value="delete_article">
            <input type="hidden" name="id" value="${id}">
        `;
        document.body.appendChild(form);
        form.submit();
    }
}

function editArticle(id) {
    alert('Fonction édition à implémenter. ID: ' + id);
}
</script>

</body>
</html>
