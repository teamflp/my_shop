<?php require_once 'includes/header.php'; ?>

<div class="container py-5">
    <!-- Hero Section -->
    <div class="jumbotron bg-light rounded-lg shadow-sm mb-5 p-4">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="display-4 mb-3"><i class="bi bi-shop"></i> Notre Boutique</h1>
                <p class="lead">Découvrez notre sélection de produits de qualité à des prix compétitifs.</p>
                <div class="input-group mt-4 w-75">
                    <input type="text" class="form-control form-control-lg" placeholder="Rechercher des produits..." aria-label="Rechercher">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="button"><i class="bi bi-search"></i> Rechercher</button>
                    </div>
                </div>
            </div>
            <div class="col-md-4 d-none d-md-block text-center">
                <i class="bi bi-bag-check" style="font-size: 8rem; color: #007bff;"></i>
            </div>
        </div>
    </div>
    
    <!-- Category Filter -->
    <div class="mb-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2><i class="bi bi-grid-3x3-gap-fill"></i> Nos Produits</h2>
            <div class="btn-group">
                <button type="button" class="btn btn-outline-primary active">Tous</button>
                <button type="button" class="btn btn-outline-primary">Nouveautés</button>
                <button type="button" class="btn btn-outline-primary">Promotions</button>
            </div>
        </div>
        <hr>
    </div>
    
    <!-- Products Grid -->
    <div class="row">
        <?php if (empty($products)): ?>
            <div class="col-12 text-center py-5">
                <i class="bi bi-emoji-frown" style="font-size: 3rem;"></i>
                <p class="lead mt-3">Aucun produit trouvé.</p>
                <a href="index.php" class="btn btn-outline-primary mt-2">Retour à l'accueil</a>
            </div>
        <?php else: ?>
            <?php foreach ($products as $product): ?>
                <div class="col-md-4 col-lg-3 mb-4">
                    <div class="card product-card h-100 border-0 shadow-sm">
                        <?php if (rand(0, 1)): ?>
                            <div class="ribbon ribbon-top-right"><span>Nouveau</span></div>
                        <?php endif; ?>
                        
                        <div class="product-image-wrapper">
                            <img src="<?= htmlspecialchars($product['image'] ?? IMAGES_DIR . 'placeholder.png') ?>" 
                                 class="card-img-top product-image" 
                                 alt="<?= htmlspecialchars($product['name']) ?>">
                            <div class="product-overlay">
                                <a href="index.php?page=product&id=<?= $product['id'] ?>" class="btn btn-light btn-sm">
                                    <i class="bi bi-eye"></i> Voir détails
                                </a>
                            </div>
                        </div>
                        
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-start">
                                <h5 class="card-title product-title"><?= htmlspecialchars($product['name']) ?></h5>
                                <span class="badge badge-pill badge-primary">
                                    <?= htmlspecialchars($product['category_name'] ?? 'Sans catégorie') ?>
                                </span>
                            </div>
                            
                            <p class="card-text text-muted product-description">
                                <?= substr(htmlspecialchars($product['description'] ?? ''), 0, 80) ?>...
                            </p>
                            
                            <div class="d-flex justify-content-between align-items-center mt-auto">
                                <div class="price-tag">
                                    <span class="h4 text-primary mb-0 font-weight-bold">
                                        <?= htmlspecialchars($product['price']) ?> €
                                    </span>
                                </div>
                                <a href="index.php?page=product&id=<?= $product['id'] ?>" class="btn btn-outline-primary">
                                    <i class="bi bi-cart-plus"></i> Acheter
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
