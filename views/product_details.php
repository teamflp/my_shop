<?php require_once __DIR__ . '/includes/header.php'; ?>

<div class="container py-5">
	<?php if (isset($product) && $product): ?>
		<div class="row align-items-start gx-5 gy-4">
			<!-- Image du produit -->
			<div class="col-lg-6">
				<img class="img-fluid rounded-4 shadow-sm w-100"
				     src="<?= htmlspecialchars($product['image'] ?? 'https://via.placeholder.com/700x500.png?text=Image+non+disponible') ?>"
				     alt="<?= htmlspecialchars($product['name']) ?>">
			</div>

			<!-- Détails du produit -->
			<div class="col-lg-6">
				<!-- Fil d'ariane -->
				<nav aria-label="breadcrumb" class="mb-2">
					<ol class="breadcrumb bg-transparent p-0 small">
						<li class="breadcrumb-item"><a href="index.php" class="text-decoration-none text-primary">Boutique</a></li>
						<li class="breadcrumb-item active" aria-current="page"><?= htmlspecialchars($product['category_name']) ?></li>
					</ol>
				</nav>

				<h1 class="display-5 fw-bold"><?= htmlspecialchars($product['name']) ?></h1>

				<div class="display-6 text-primary mb-3">
					<?= number_format($product['price'], 2, ',', ' ') ?> €
				</div>

				<p class="text-muted lead mb-4"><?= nl2br(htmlspecialchars($product['description'])) ?></p>

				<!-- Stock & formulaire -->
				<div class="card bg-light border-0 rounded-4 p-3 mb-4">
					<?php if ($product['stock'] > 0): ?>
						<div class="alert alert-success d-flex align-items-center small p-2 mb-3">
							<i class="bi bi-check-circle-fill me-2"></i>
							En stock (<?= $product['stock'] ?> restants)
						</div>

						<form action="cart.php?action=add" method="post" class="d-flex align-items-end gap-2">
							<input type="hidden" name="product_id" value="<?= $product['id'] ?>">
							<div class="flex-shrink-0" style="width: 80px;">
								<label for="quantity" class="form-label small mb-1">Quantité</label>
								<input class="form-control text-center"
								       id="quantity"
								       name="quantity"
								       type="number"
								       value="0"
								       min="1"
								       max="<?= $product['stock'] ?>">
							</div>
							<button class="btn btn-primary btn-lg flex-grow-1 rounded-pill shadow-sm" type="submit">
								<i class="bi bi-cart-plus me-2"></i> Ajouter au panier
							</button>
						</form>
					<?php else: ?>
						<div class="alert alert-danger mb-0">
							<h5 class="alert-heading"><i class="bi bi-x-circle-fill me-2"></i> En rupture de stock</h5>
							<p class="mb-0 small">Ce produit est momentanément indisponible.</p>
						</div>
					<?php endif; ?>
				</div>

				<!-- Interrupteur et section d'infos techniques -->
				<div class="form-check form-switch mb-2">
					<input class="form-check-input" type="checkbox" id="techInfoSwitch">
					<label class="form-check-label" for="techInfoSwitch">Afficher les infos techniques</label>
				</div>
				<div id="techInfoSection" class="collapse">
					<div class="card card-body small text-muted">
						<ul class="list-unstyled mb-0">
							<li><strong>SKU:</strong> PRD-<?= str_pad($product['id'], 5, '0', STR_PAD_LEFT) ?></li>
							<li><strong>Catégorie:</strong> <?= htmlspecialchars($product['category_name']) ?></li>
							<li><strong>Poids:</strong> 0.75kg (estimation)</li>
							<li><strong>Dimensions:</strong> 25 x 15 x 10 cm (estimation)</li>
						</ul>
					</div>
				</div>

			</div>
		</div>
	<?php else: ?>
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center py-5">
                <div class="alert alert-danger p-5 shadow-sm">
                    <h2><i class="bi bi-exclamation-triangle-fill me-2"></i> Produit non trouvé</h2>
                    <p class="lead">Le produit que vous recherchez n'existe pas ou a été retiré.</p>
                    <hr>
                    <a href="index.php" class="btn btn-primary btn-lg rounded-pill shadow-sm">
                        <i class="bi bi-arrow-left me-2"></i> Retour à l'accueil
                    </a>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const techInfoSwitch = document.getElementById('techInfoSwitch');
    const techInfoSection = new bootstrap.Collapse(document.getElementById('techInfoSection'), {
        toggle: false
    });
    techInfoSwitch.addEventListener('change', function () {
        techInfoSection.toggle();
    });
});
</script>
