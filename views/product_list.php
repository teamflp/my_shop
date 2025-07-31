<?php require_once 'includes/header.php'; ?>

<div class="container">
    <h1>Our Products</h1>
    <div class="row">
        <?php if (empty($products)): ?>
            <p>No products found.</p>
        <?php else: ?>
            <?php foreach ($products as $product): ?>
                <div class="col-md-4">
                    <div class="card mb-4">
                        <img src="<?= htmlspecialchars($product['image'] ?? 'assets/images/placeholder.png') ?>" class="card-img-top" alt="<?= htmlspecialchars($product['name']) ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($product['name']) ?></h5>
                            <p class="card-text">$<?= htmlspecialchars($product['price']) ?></p>
                            <a href="index.php?page=product&id=<?= $product['id'] ?>" class="btn btn-primary">View Details</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
