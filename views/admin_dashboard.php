<?php require_once 'admin/includes/header.php'; ?>

<h1 class="mt-4">Dashboard</h1>
<p>Welcome to the admin dashboard. Here are some stats about your shop:</p>

<div class="row">
    <div class="col-xl-3 col-md-6">
        <div class="card bg-primary text-white mb-4">
            <div class="card-body">
                <h3><?= htmlspecialchars($user_count) ?></h3>
                <p>Total Users</p>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="admin.php?action=manage-users">View Details</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card bg-warning text-white mb-4">
            <div class="card-body">
                <h3><?= htmlspecialchars($product_count) ?></h3>
                <p>Total Products</p>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="admin.php?action=products">View Details</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card bg-success text-white mb-4">
            <div class="card-body">
                <h3><?= htmlspecialchars($category_count) ?></h3>
                <p>Total Categories</p>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="admin.php?action=categories">View Details</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'admin/includes/footer.php'; ?>
