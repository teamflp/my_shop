<?php require_once 'includes/header.php'; ?>

<div class="container">
    <div class="row">
        <div class="col-md-3">
            <h3>Categories</h3>
            <div class="list-group">
                <a href="index.php" class="list-group-item list-group-item-action">All Products</a>
                <?php foreach ($categories as $category): ?>
                    <a href="index.php?category_id=<?= $category['id'] ?>" class="list-group-item list-group-item-action">
                        <?= htmlspecialchars($category['name']) ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="col-md-9">
            <h1>Our Products</h1>
            <div class="row">
                <?php if (empty($products)): ?>
                    <p>No products found in this category.</p>
                <?php else: ?>
                    <?php foreach ($products as $product): ?>
                        <div class="col-md-4">
                            <div class="card mb-4">
                                <img src="<?= htmlspecialchars($product['image'] ?? 'assets/images/placeholder.png') ?>" class="card-img-top" alt="<?= htmlspecialchars($product['name']) ?>">
                                <div class="card-body">
                                    <h5 class="card-title"><?= htmlspecialchars($product['name']) ?></h5>
                                    <p class="card-text">$<?= htmlspecialchars($product['price']) ?></p>
                                    <a href="index.php?page=product&id=<?= $product['id'] ?>" class="btn btn-primary">View Details</a>
                                    <form action="cart.php?action=add" method="post" class="d-inline">
                                        <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                        <button type="submit" class="btn btn-success">Add to Cart</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
