<?php require_once __DIR__ . '/../admin/includes/header.php'; ?>

<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h3 class="mb-0"><i class="bi bi-box-seam"></i> Gestion des Produits</h3>
            <a href="admin.php?action=add_product" class="btn btn-light">
                <i class="bi bi-plus-circle"></i> Ajouter un Produit
            </a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th>Nom</th>
                            <th>Prix</th>
                            <th>Catégorie</th>
                            <th>Stock</th>
                            <th>Image</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($products)): ?>
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <i class="bi bi-info-circle" style="font-size: 2rem;"></i>
                                    <p class="mt-2">Aucun produit trouvé.</p>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($products as $product): ?>
                            <tr>
                                <td><?= htmlspecialchars($product['name']) ?></td>
                                <td><?= number_format($product['price'], 2, ',', ' ') ?> €</td>
                                <td>
                                    <span class="badge bg-secondary">
                                        <i class="bi bi-tag-fill"></i> <?= htmlspecialchars($product['category_name']) ?>
                                    </span>
                                </td>
                                <td><?= htmlspecialchars($product['stock']) ?></td>
                                <td>
                                    <?php if (!empty($product['image'])): ?>
                                        <img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="img-thumbnail img-fluid" style="max-width: 80px; max-height: 80px;">
                                    <?php else: ?>
                                        <span class="text-muted"><i class="bi bi-image"></i> Pas d'image</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="admin.php?action=edit_product&id=<?= $product['id'] ?>" class="btn btn-sm btn-primary me-2">
                                        <i class="bi bi-pencil-square me-1"></i> Modifier
                                    </a>
                                    <a href="admin.php?action=delete_product&id=<?= $product['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce produit ?')">
                                        <i class="bi bi-trash me-1"></i> Supprimer
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php if (isset($total_pages) && $total_pages > 1): ?>
        <div class="card-footer bg-white">
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center mb-0">
                    <!-- Bouton Précédent -->
                    <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                        <a class="page-link" href="admin.php?action=products&page=<?= $page - 1 ?>">Précédent</a>
                    </li>

                    <!-- Liens des pages -->
                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <li class="page-item <?= ($page == $i) ? 'active' : '' ?>">
                            <a class="page-link" href="admin.php?action=products&page=<?= $i ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>

                    <!-- Bouton Suivant -->
                    <li class="page-item <?= ($page >= $total_pages) ? 'disabled' : '' ?>">
                        <a class="page-link" href="admin.php?action=products&page=<?= $page + 1 ?>">Suivant</a>
                    </li>
                </ul>
            </nav>
        </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
