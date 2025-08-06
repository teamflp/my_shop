<?php require_once __DIR__ . '/includes/header.php'; ?>

    <style>
        .product-card {
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        }
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.1) !important;
        }
        .product-card .card-img-top {
            height: 200px;
            object-fit: cover;
        }
    </style>

    <div class="container my-5">
        <div class="row">
            <div class="col-12 text-center mb-5">
                <h1 class="display-4">Nos Produits</h1>
                <p class="lead text-muted">Découvrez notre sélection de produits de qualité.</p>
            </div>
        </div>

        <div class="row">
            <?php if (isset($products) && !empty($products)): ?>
                <?php foreach ($products as $product): ?>
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                        <div class="card h-100 shadow-sm border-0 product-card">
                            <a href="index.php?page=product&id=<?= htmlspecialchars($product['id']) ?>">
                                <img src="<?= htmlspecialchars($product['image'] ?? 'https://via.placeholder.com/300x200.png?text=Image+non+disponible') ?>"
                                     class="card-img-top"
                                     alt="<?= htmlspecialchars($product['name']) ?>">
                            </a>
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">
                                    <a href="index.php?page=product&id=<?= htmlspecialchars($product['id']) ?>" class="text-dark stretched-link text-decoration-none">
                                        <?= htmlspecialchars($product['name']) ?>
                                    </a>
                                </h5>
                                <div class="mt-auto d-flex justify-content-between align-items-center">
                                <span class="h5 font-weight-bold text-primary mb-0">
                                    <?= number_format($product['price'], 2, ',', ' ') ?> €
                                </span>
                                    <?php if ($product['stock'] > 0): ?>
                                        <span class="badge badge-success"><i class="bi bi-check-circle"></i> En stock</span>
                                    <?php else: ?>
                                        <span class="badge badge-danger"><i class="bi bi-x-circle"></i> Épuisé</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="alert alert-info text-center">
                        <p class="h4"><i class="bi bi-info-circle-fill"></i> Aucun produit n'est disponible pour le moment.</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>