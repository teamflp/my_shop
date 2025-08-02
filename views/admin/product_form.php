<?php require_once __DIR__ . '/../admin/includes/header.php'; ?>

<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h3 class="mb-0"><i class="bi bi-box-seam"></i> <?php echo isset($product) ? 'Modifier' : 'Ajouter'; ?> un produit</h3>
        </div>
        <div class="card-body p-4">
            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        <?php foreach ($errors as $error): ?>
                            <li><?= $error ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
            
            <form method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="name"><i class="bi bi-tag"></i> Nom du produit:</label>
                            <input type="text" name="name" id="name" class="form-control" value="<?= htmlspecialchars($product['name'] ?? '') ?>" placeholder="Nom du produit" required>
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="price"><i class="bi bi-currency-euro"></i> Prix:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">€</span>
                                </div>
                                <input type="number" step="0.01" name="price" id="price" class="form-control" value="<?= htmlspecialchars($product['price'] ?? '') ?>" placeholder="0.00" required>
                            </div>
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="category_id"><i class="bi bi-folder2"></i> Catégorie:</label>
                            <select name="category_id" id="category_id" class="form-control" required>
                                <option value="">Sélectionner une catégorie</option>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?= $category['id'] ?>" <?php echo (isset($product) && $product['category_id'] == $category['id']) ? 'selected' : ''; ?>>
                                        <?= htmlspecialchars($category['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="image"><i class="bi bi-image"></i> Image:</label>
                            <input type="file" name="image" id="image" class="form-control">
                            <?php if (isset($product) && !empty($product['image'])): ?>
                                <div class="mt-2">
                                    <p class="mb-1">Image actuelle:</p>
                                    <div class="border p-2 d-inline-block">
                                        <img src="<?= htmlspecialchars($product['image']) ?>" alt="" class="img-thumbnail" style="max-width: 150px;">
                                    </div>
                                    <input type="hidden" name="existing_image" value="<?= htmlspecialchars($product['image']) ?>">
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                
                <div class="form-group mb-4">
                    <label for="description"><i class="bi bi-text-paragraph"></i> Description:</label>
                    <textarea name="description" id="description" class="form-control" rows="5" placeholder="Description détaillée du produit" required><?= htmlspecialchars($product['description'] ?? '') ?></textarea>
                </div>
                
                <div class="d-flex justify-content-between">
                    <a href="admin.php?action=products" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Retour
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Enregistrer le produit
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
