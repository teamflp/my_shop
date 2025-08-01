<?php require_once __DIR__ . '/../includes/header.php'; ?>

<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
            <h3 class="mb-0"><i class="bi bi-folder2-open"></i> Gestion des Catégories</h3>
            <a href="admin.php?action=add_category" class="btn btn-light">
                <i class="bi bi-plus-circle"></i> Ajouter une Catégorie
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="bg-light">
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Catégorie Parente</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($categories)): ?>
                            <tr>
                                <td colspan="4" class="text-center py-4">
                                    <i class="bi bi-emoji-frown" style="font-size: 2rem;"></i>
                                    <p class="mt-2">Aucune catégorie trouvée.</p>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($categories as $category): ?>
                            <tr>
                                <td><?= htmlspecialchars($category['id']) ?></td>
                                <td>
                                    <i class="bi bi-folder"></i> <?= htmlspecialchars($category['name']) ?>
                                </td>
                                <td>
                                    <?php if (!empty($category['parent_id'])): ?>
                                        <span class="badge badge-secondary">
                                            <i class="bi bi-diagram-3"></i> ID: <?= htmlspecialchars($category['parent_id']) ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="badge badge-light">Catégorie principale</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="admin.php?action=edit_category&id=<?= $category['id'] ?>" class="btn btn-sm btn-info">
                                            <i class="bi bi-pencil"></i> Modifier
                                        </a>
                                        <a href="admin.php?action=delete_category&id=<?= $category['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie?')">
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
