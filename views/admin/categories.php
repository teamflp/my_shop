<?php require_once __DIR__ . '/../includes/header.php'; ?>

<div class="container">
    <h2>Manage Categories</h2>
    <a href="admin.php?action=add_category" class="btn btn-primary mb-3">Add New Category</a>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Parent ID</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($categories as $category): ?>
            <tr>
                <td><?= htmlspecialchars($category['id']) ?></td>
                <td><?= htmlspecialchars($category['name']) ?></td>
                <td><?= htmlspecialchars($category['parent_id'] ?? 'N/A') ?></td>
                <td>
                    <a href="admin.php?action=edit_category&id=<?= $category['id'] ?>" class="btn btn-sm btn-info">Edit</a>
                    <a href="admin.php?action=delete_category&id=<?= $category['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
