<?php require_once 'includes/header.php'; ?>

<div class="container">
    <h2>Admin Dashboard</h2>
    <p>Welcome to the admin dashboard. From here you can manage your shop's products and categories.</p>

    <div class="list-group">
        <a href="admin.php?action=products" class="list-group-item list-group-item-action">
            Manage Products
        </a>
        <a href="admin.php?action=categories" class="list-group-item list-group-item-action">
            Manage Categories
        </a>
        <a href="admin.php?action=manage-users" class="list-group-item list-group-item-action">
            Manage Users
        </a>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
