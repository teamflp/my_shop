<?php require_once __DIR__ . '/../includes/header.php'; ?>

<div class="container">
    <h2>Manage Products</h2>
    <a href="admin.php?action=add_product" class="btn btn-primary mb-3">Add New Product</a>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Price</th>
                <th>Category</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $product): ?>
            <tr>
                <td><?= htmlspecialchars($product['id']) ?></td>
                <td><?= htmlspecialchars($product['name']) ?></td>
                <td><?= htmlspecialchars($product['price']) ?></td>
                <td><?= htmlspecialchars($product['category_name']) ?></td>
                <td>
                    <?php if (!empty($product['image'])): ?>
                        <img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" style="max-width: 100px;">
                    <?php endif; ?>
                </td>
                <td>
                    <a href="admin.php?action=edit_product&id=<?= $product['id'] ?>" class="btn btn-sm btn-info">Edit</a>
                    <a href="admin.php?action=delete_product&id=<?= $product['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
