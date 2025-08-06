<?php require_once __DIR__ . '/../admin/includes/header.php'; ?>

<div class="container py-4">
    <?php if (isset($_GET['update']) && $_GET['update'] === 'success'): ?>
        <div class="alert alert-success">
            L'utilisateur a été mis à jour avec succès.
        </div>
    <?php endif; ?>

    <div class="card shadow-sm">
        <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
            <h3 class="mb-0"><i class="bi bi-people"></i> Gestion des Utilisateurs</h3>
        </div>
        <div class="card-body">
            <form action="admin.php?action=update_user_status" method="post">
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle">
                        <thead class="thead-light">
                            <tr>
                                <th>Utilisateur</th>
                                <th>Email</th>
                                <th class="text-center">Admin</th>
                                <th class="text-center">Actif</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($allUsers as $user): ?>
                            <tr>
                                <td><?= htmlspecialchars($user['username']) ?></td>
                                <td><?= htmlspecialchars($user['email']) ?></td>

                                <!-- Rôle (is_admin) -->
                                <td class="text-center">
                                    <input type="hidden" name="role[<?= $user['id'] ?>]" value="user"> <!-- Valeur par défaut si la case n'est pas cochée -->
                                    <label class="switch">
                                        <input type="checkbox" name="role[<?= $user['id'] ?>]" value="admin"
                                            <?= ($user['is_admin'] == 1) ? 'checked' : '' ?>
                                            <?= ($user['id'] == ($_SESSION['user_id'] ?? 0)) ? 'disabled' : '' ?>>
                                        <span class="slider"></span>
                                    </label>
                                </td>

                                <!-- Statut -->
                                <td class="text-center">
                                    <input type="hidden" name="status[<?= $user['id'] ?>]" value="suspended"> <!-- Valeur par défaut -->
                                    <label class="switch">
                                        <input type="checkbox" name="status[<?= $user['id'] ?>]" value="active"
                                            <?= ($user['status'] === 'active') ? 'checked' : '' ?>
                                            <?= ($user['id'] == ($_SESSION['user_id'] ?? 0)) ? 'disabled' : '' ?>>
                                        <span class="slider"></span>
                                    </label>
                                </td>

                                <td class="text-end">
                                    <button type="submit" name="update_user" value="<?= $user['id'] ?>" class="btn btn-primary btn-sm" <?= ($user['id'] == ($_SESSION['user_id'] ?? 0)) ? 'disabled' : '' ?>>
                                        Mettre à jour
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
