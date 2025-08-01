<?php require_once __DIR__ . '/includes/header.php'; ?>

    <h2>Manage Users</h2>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Admin Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
            <tr>
                <td><?= htmlspecialchars($user['id']) ?></td>
                <td><?= htmlspecialchars($user['username']) ?></td>
                <td><?= htmlspecialchars($user['email']) ?></td>
                <td>
                    <form action="admin.php?action=update_user_status" method="post" class="form-inline">
                        <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                        <select name="is_admin" class="form-control form-control-sm">
                            <option value="1" <?= $user['is_admin'] ? 'selected' : '' ?>>Admin</option>
                            <option value="0" <?= !$user['is_admin'] ? 'selected' : '' ?>>User</option>
                        </select>
                        <button type="submit" class="btn btn-sm btn-primary ml-2">Update</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
