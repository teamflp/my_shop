<?php
require_once __DIR__ . '/includes/header.php';

/**
 * @var array $items Les articles du panier.
 * @var float $total Le montant total du panier.
 */
?>

<div class="bg-light py-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="display-6 fw-bold">
                    <i class="bi bi-cart3 me-2"></i> Votre Panier
                </h1>
                <p class="text-muted">Vérifiez vos articles avant de passer commande.</p>
            </div>
        </div>
    </div>
</div>

<div class="container my-5">
    <?php if (empty($items)): ?>
        <div class="text-center py-5">
            <div class="card border-0 bg-light p-4 p-md-5 shadow-sm rounded-4">
                <div class="card-body">
                    <i class="bi bi-basket2" style="font-size: 4rem; color: #adb5bd;"></i>
                    <h2 class="mt-4">Votre panier est vide</h2>
                    <p class="lead text-muted">Ajoutez des produits pour le remplir !</p>
                    <a href="index.php" class="btn btn-primary btn-lg mt-3 rounded-pill shadow-sm">
                        <i class="bi bi-box-seam me-2"></i> Découvrir nos produits
                    </a>
                </div>
            </div>
        </div>
    <?php else: ?>
        <form action="cart.php?action=update" method="post">
            <div class="row g-5">
                <!-- Liste des articles -->
                <div class="col-lg-8">
                    <div class="card border-0 border-end-1 rounded-4">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0">Articles (<?= count($items) ?>)</h5>
                        </div>
                        <div class="card-body p-0">
                            <?php foreach ($items as $index => $item): ?>
                                <div class="p-3 d-flex align-items-center <?= $index < count($items) - 1 ? 'border-bottom' : '' ?>">
                                    <a href="index.php?page=product&id=<?= $item['id'] ?>" class="flex-shrink-0">
                                        <img src="<?= htmlspecialchars($item['image'] ?? 'https://via.placeholder.com/100x100.png') ?>"
                                             alt="<?= htmlspecialchars($item['name']) ?>"
                                             class="img-fluid rounded shadow-sm"
                                             style="width: 80px; height: 80px; object-fit: cover;">
                                    </a>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-1">
                                            <a href="index.php?page=product&id=<?= $item['id'] ?>" class="text-decoration-none text-dark">
                                                <?= htmlspecialchars($item['name']) ?>
                                            </a>
                                        </h6>
                                        <small class="text-muted"><?= number_format($item['price'], 2, ',', ' ') ?> € l'unité</small>
                                        <div class="d-flex align-items-center mt-2">
                                            <label for="quantity-<?= $item['id'] ?>" class="form-label small me-2 mb-0">Qté :</label>
                                            <input type="number"
                                                   name="quantities[<?= $item['id'] ?>]"
                                                   id="quantity-<?= $item['id'] ?>"
                                                   class="form-control form-control-sm text-center"
                                                   value="<?= $item['quantity'] ?>"
                                                   min="1"
                                                   max="<?= $item['stock'] ?>"
                                                   style="width: 70px;"
                                                   aria-label="Quantité">
                                        </div>
                                    </div>
                                    <div class="text-end ms-3">
                                        <p class="fw-bold mb-1"><?= number_format($item['subtotal'], 2, ',', ' ') ?> €</p>
                                        <a href="cart.php?action=remove&id=<?= $item['id'] ?>"
                                           class="btn btn-sm btn-link text-danger text-decoration-none px-0"
                                           title="Supprimer l'article">
                                            <i class="bi bi-trash3 me-1"></i> Supprimer
                                        </a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="card-footer bg-white text-end border-0 py-3">
                            <button type="submit" class="btn btn-outline-secondary rounded-pill shadow-sm">
                                <i class="bi bi-arrow-clockwise me-1"></i> Mettre à jour le panier
                            </button>
                        </div>
                    </div>

                    <!-- Bouton résumé mobile -->
                    <div class="d-lg-none mt-4">
                        <button class="btn btn-outline-primary w-100 rounded-pill" type="button" data-bs-toggle="collapse" data-bs-target="#orderSummary" aria-expanded="false" aria-controls="orderSummary">
                            <i class="bi bi-receipt-cutoff me-2"></i> Afficher le résumé de la commande
                        </button>
                    </div>
                </div>

                <!-- Résumé commande -->
                <div class="col-lg-4">
                    <div id="orderSummary" class="collapse d-lg-block">
                        <div class="card border-0 shadow-lg rounded-4 position-sticky mt-4 mt-lg-0" style="top: 2rem;">
                            <div class="card-header bg-white py-3">
                                <h5 class="mb-0">Résumé de la commande</h5>
                            </div>
                            <div class="card-body">
                                <ul class="list-group list-group-flush mb-4">
                                    <li class="list-group-item d-flex justify-content-between border-0 px-0 pb-2">
                                        <span>Sous-total</span>
                                        <span><?= number_format($total, 2, ',', ' ') ?> €</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between border-0 px-0 pb-2">
                                        <span>Livraison</span>
                                        <span class="text-success">Gratuite</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between border-0 px-0">
                                        <div>
                                            <strong class="fs-5">Total</strong>
                                            <p class="mb-0 small text-muted">(TVA incluse)</p>
                                        </div>
                                        <span class="fs-5 fw-bold"><?= number_format($total, 2, ',', ' ') ?> €</span>
                                    </li>
                                </ul>

                                <div class="d-grid">
                                    <a href="cart.php?action=checkout" class="btn btn-primary btn-lg rounded-pill shadow-sm">
                                        <i class="bi bi-credit-card-fill me-2"></i> Passer la commande
                                    </a>
                                </div>
                            </div>
                            <div class="card-footer bg-light border-0">
                                <p class="small mb-2">Vous avez un code promo ?</p>
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="CODEPROMO" aria-label="Code promo">
                                    <button class="btn btn-outline-secondary" type="button">Appliquer</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
