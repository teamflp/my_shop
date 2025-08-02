<?php require_once __DIR__ . '/../admin/includes/header.php'; ?>

<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
            <h3 class="mb-0"><i class="bi bi-people"></i> Gestion des Utilisateurs</h3>
            <a href="admin.php?action=add_user" class="btn btn-light">
                <i class="bi bi-person-plus"></i> Ajouter un Utilisateur
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="bg-light">
                        <tr>
                            <th>ID</th>
                            <th>Nom d'utilisateur</th>
                            <th>Email</th>
                            <th>Rôle</th>
                            <th>Date de création</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($users)): ?>
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <i class="bi bi-emoji-frown" style="font-size: 2rem;"></i>
                                    <p class="mt-2">Aucun utilisateur trouvé.</p>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($users as $user): ?>
                            <tr>
                                <td><?= htmlspecialchars($user['id']) ?></td>
                                <td>
                                    <i class="bi bi-person"></i> <?= htmlspecialchars($user['username']) ?>
                                    <?php if ($user['id'] == $_SESSION['user_id']): ?>
                                        <span class="badge badge-secondary">Vous</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= htmlspecialchars($user['email']) ?></td>
                                <td>
                                    <?php if ($user['is_admin']): ?>
                                        <span class="badge badge-danger">
                                            <i class="bi bi-shield-lock"></i> Administrateur
                                        </span>
                                    <?php else: ?>
                                        <span class="badge badge-secondary">
                                            <i class="bi bi-person"></i> Utilisateur
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <i class="bi bi-calendar"></i> 
                                    <?= date('d/m/Y H:i', strtotime($user['created_at'])) ?>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="admin.php?action=edit_user&id=<?= $user['id'] ?>" class="btn btn-sm btn-info">
                                            <i class="bi bi-pencil"></i> Modifier
                                        </a>
                                        <?php if ($user['id'] != $_SESSION['user_id']): ?>
                                            <a href="admin.php?action=delete_user&id=<?= $user['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur?')">
                                                <i class="bi bi-trash"></i> Supprimer
                                            </a>
                                        <?php endif; ?>
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
