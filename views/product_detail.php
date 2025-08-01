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

            <hr>
            <form action="cart.php?action=add" method="post">
                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                <div class="form-group row">
                    <label for="quantity" class="col-sm-3 col-form-label">Quantity:</label>
                    <div class="col-sm-4">
                        <input type="number" name="quantity" id="quantity" class="form-control" value="1" min="1">
                    </div>
                </div>
                <button type="submit" class="btn btn-success">Add to Cart</button>
            </form>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
