<?php require_once __DIR__ . '/../includes/header.php'; ?>

<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-header bg-success text-white">
            <h3 class="mb-0"><i class="bi bi-folder2-open"></i> <?php echo isset($category) ? 'Modifier' : 'Ajouter'; ?> une catégorie</h3>
        </div>
        <div class="card-body p-4">
            <form method="post">
                <div class="form-group mb-4">
                    <label for="name"><i class="bi bi-tag"></i> Nom de la catégorie:</label>
                    <input type="text" name="name" id="name" class="form-control" value="<?= htmlspecialchars($category['name'] ?? '') ?>" placeholder="Nom de la catégorie" required>
                </div>
                
                <div class="form-group mb-4">
                    <label for="parent_id"><i class="bi bi-diagram-3"></i> Catégorie parente:</label>
                    <select name="parent_id" id="parent_id" class="form-control">
                        <option value="">Aucune (catégorie principale)</option>
                        <?php foreach ($categories as $cat): ?>
                            <?php if (isset($category) && $category['id'] == $cat['id']) continue; // Une catégorie ne peut pas être sa propre parente ?>
                            <option value="<?= $cat['id'] ?>" <?php echo (isset($category) && $category['parent_id'] == $cat['id']) ? 'selected' : ''; ?>>
                                <?= htmlspecialchars($cat['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <small class="form-text text-muted">
                        <i class="bi bi-info-circle"></i> Sélectionnez une catégorie parente pour créer une sous-catégorie.
                    </small>
                </div>
                
                <div class="d-flex justify-content-between">
                    <a href="admin.php?action=categories" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Retour
                    </a>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-save"></i> Enregistrer la catégorie
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
