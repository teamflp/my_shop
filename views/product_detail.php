<?php require_once 'includes/header.php'; ?>

<div class="container py-5">
    <!-- Breadcrumb navigation -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb bg-light p-3 shadow-sm rounded">
            <li class="breadcrumb-item"><a href="index.php" class="text-decoration-none"><i class="bi bi-house-door"></i> Accueil</a></li>
            <li class="breadcrumb-item"><a href="index.php" class="text-decoration-none"><i class="bi bi-grid-3x3-gap-fill"></i> Produits</a></li>
            <li class="breadcrumb-item active" aria-current="page"><i class="bi bi-box-seam"></i> <?= htmlspecialchars($product['name']) ?></li>
        </ol>
    </nav>

    <div class="row">
        <!-- Product Image Gallery -->
        <div class="col-lg-6 mb-4">
            <div class="product-gallery">
                <div class="ribbon ribbon-top-right"><span>Nouveau</span></div>
                <div class="main-image-container shadow-lg rounded overflow-hidden">
                    <img src="<?= htmlspecialchars($product['image'] ?? IMAGES_DIR . 'placeholder.png') ?>" 
                         class="img-fluid main-product-image" 
                         alt="<?= htmlspecialchars($product['name']) ?>">
                </div>
                
                <!-- Thumbnails (for demonstration) -->
                <div class="d-flex justify-content-center mt-3">
                    <div class="thumbnail-container active mx-2">
                        <img src="<?= htmlspecialchars($product['image'] ?? IMAGES_DIR . 'placeholder.png') ?>" 
                             class="img-thumbnail" alt="Thumbnail 1">
                    </div>
                    <div class="thumbnail-container mx-2">
                        <img src="<?= htmlspecialchars($product['image'] ?? IMAGES_DIR . 'placeholder.png') ?>" 
                             class="img-thumbnail" alt="Thumbnail 2">
                    </div>
                    <div class="thumbnail-container mx-2">
                        <img src="<?= htmlspecialchars($product['image'] ?? IMAGES_DIR . 'placeholder.png') ?>" 
                             class="img-thumbnail" alt="Thumbnail 3">
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Product Details -->
        <div class="col-lg-6">
            <div class="product-details bg-white p-4 rounded shadow-sm">
                <h1 class="product-title mb-2"><?= htmlspecialchars($product['name']) ?></h1>
                
                <div class="d-flex align-items-center mb-3">
                    <span class="badge badge-pill badge-primary p-2 mr-3">
                        <i class="bi bi-tag-fill"></i> <?= htmlspecialchars($product['category_name']) ?>
                    </span>
                    <div class="product-rating">
                        <div class="stars">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-half"></i>
                        </div>
                        <span class="rating-count">(4.5/5 - 24 avis)</span>
                    </div>
                </div>
                
                <div class="product-price mb-4">
                    <span class="current-price"><?= htmlspecialchars($product['price']) ?> €</span>
                    <span class="original-price">129.99 €</span>
                    <span class="discount-badge">-20%</span>
                </div>
                
                <div class="product-description mb-4">
                    <h5><i class="bi bi-info-circle"></i> Description</h5>
                    <div class="description-content">
                        <?= nl2br(htmlspecialchars($product['description'])) ?>
                    </div>
                </div>
                
                <div class="product-availability mb-3">
                    <span class="stock-status in-stock">
                        <i class="bi bi-check-circle-fill"></i> En stock
                    </span>
                    <span class="delivery-info">
                        <i class="bi bi-truck"></i> Livraison estimée: 2-4 jours ouvrables
                    </span>
                </div>
                
                <div class="product-actions mb-4">
                    <div class="quantity-selector">
                        <button class="quantity-btn minus"><i class="bi bi-dash"></i></button>
                        <input type="number" min="1" value="1" class="quantity-input">
                        <button class="quantity-btn plus"><i class="bi bi-plus"></i></button>
                    </div>
                    
                    <button class="btn btn-primary btn-lg add-to-cart-btn">
                        <i class="bi bi-cart-plus"></i> Ajouter au panier
                    </button>
                    
                    <button class="btn btn-outline-danger wishlist-btn">
                        <i class="bi bi-heart"></i>
                    </button>
                </div>
                
                <div class="product-benefits">
                    <div class="benefit-item">
                        <i class="bi bi-truck"></i>
                        <div class="benefit-text">
                            <h6>Livraison gratuite</h6>
                            <p>Pour toute commande > 50€</p>
                        </div>
                    </div>
                    <div class="benefit-item">
                        <i class="bi bi-arrow-repeat"></i>
                        <div class="benefit-text">
                            <h6>Retours sous 30 jours</h6>
                            <p>Satisfait ou remboursé</p>
                        </div>
                    </div>
                    <div class="benefit-item">
                        <i class="bi bi-shield-check"></i>
                        <div class="benefit-text">
                            <h6>Garantie 2 ans</h6>
                            <p>Sur tous nos produits</p>
                        </div>
                    </div>
                </div>
                
                <div class="product-share mt-4">
                    <h6>Partager ce produit:</h6>
                    <div class="social-icons">
                        <a href="#" class="social-icon"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="social-icon"><i class="bi bi-twitter"></i></a>
                        <a href="#" class="social-icon"><i class="bi bi-pinterest"></i></a>
                        <a href="#" class="social-icon"><i class="bi bi-envelope"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
