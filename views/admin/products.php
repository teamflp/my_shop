<?php require_once __DIR__ . '/../includes/header.php'; ?>

<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h3 class="mb-0"><i class="bi bi-box-seam"></i> Gestion des Produits</h3>
            <a href="admin.php?action=add_product" class="btn btn-light">
                <i class="bi bi-plus-circle"></i> Ajouter un Produit
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="bg-light">
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Prix</th>
                            <th>Catégorie</th>
                            <th>Image</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($products)): ?>
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <i class="bi bi-emoji-frown" style="font-size: 2rem;"></i>
                                    <p class="mt-2">Aucun produit trouvé.</p>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($products as $product): ?>
                            <tr>
                                <td><?= htmlspecialchars($product['id']) ?></td>
                                <td><?= htmlspecialchars($product['name']) ?></td>
                                <td><i class="bi bi-currency-euro"></i><?= htmlspecialchars($product['price']) ?></td>
                                <td>
                                    <span class="badge badge-primary">
                                        <i class="bi bi-tag-fill"></i> <?= htmlspecialchars($product['category_name']) ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if (!empty($product['image'])): ?>
                                        <img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="img-thumbnail" style="max-width: 80px; max-height: 80px;">
                                    <?php else: ?>
                                        <span class="text-muted"><i class="bi bi-image"></i> Pas d'image</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="admin.php?action=edit_product&id=<?= $product['id'] ?>" class="btn btn-sm btn-info">
                                            <i class="bi bi-pencil"></i> Modifier
                                        </a>
                                        <a href="admin.php?action=delete_product&id=<?= $product['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce produit?')">
                                            <i class="bi bi-trash"></i> Supprimer
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
