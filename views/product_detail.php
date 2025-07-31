<?php require_once 'includes/header.php'; ?>

<div class="container">
    <div class="row">
        <div class="col-md-6">
            <img src="<?= htmlspecialchars($product['image'] ?? 'assets/images/placeholder.png') ?>" class="img-fluid" alt="<?= htmlspecialchars($product['name']) ?>">
        </div>
        <div class="col-md-6">
            <h2><?= htmlspecialchars($product['name']) ?></h2>
            <p class="text-muted">Category: <?= htmlspecialchars($product['category_name']) ?></p>
            <h3>$<?= htmlspecialchars($product['price']) ?></h3>
            <p><?= nl2br(htmlspecialchars($product['description'])) ?></p>

            <!-- Add to cart button (not functional yet) -->
            <a href="#" class="btn btn-success">Add to Cart</a>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
