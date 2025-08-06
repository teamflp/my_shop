<?php
require_once __DIR__ . '/includes/header.php';

/**
 * @var array $items Les articles du panier.
 * @var float $total Le montant total du panier.
 * @var array $errors Les erreurs de validation.
 * @var array $user L'utilisateur connecté.
 */
?>

<div class="container my-5">
    <div class="row">
        <div class="col-12 text-center mb-5">
            <h1 class="display-5">Finaliser la commande</h1>
        </div>
    </div>

    <div class="row g-5">
        <div class="col-md-5 col-lg-4 order-md-last">
            <h4 class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-primary">Votre panier</span>
                <span class="badge bg-primary rounded-pill"><?= \models\Cart::count() ?></span>
            </h4>
            <ul class="list-group mb-3">
                <?php foreach ($items as $item): ?>
                <li class="list-group-item d-flex justify-content-between lh-sm">
                    <div>
                        <h6 class="my-0"><?= htmlspecialchars($item['name']) ?></h6>
                        <small class="text-muted">Quantité: <?= $item['quantity'] ?></small>
                    </div>
                    <span class="text-muted"><?= number_format($item['subtotal'], 2, ',', ' ') ?> €</span>
                </li>
                <?php endforeach; ?>
                <li class="list-group-item d-flex justify-content-between">
                    <span>Total (EUR)</span>
                    <strong><?= number_format($total, 2, ',', ' ') ?> €</strong>
                </li>
            </ul>
        </div>

        <div class="col-md-7 col-lg-8">
            <h4 class="mb-3">Adresse de livraison</h4>

            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        <?php foreach ($errors as $error): ?>
                            <li><?= htmlspecialchars($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <div class="card bg-light border-0 p-3 mb-4">
                <p class="mb-1"><strong>Client :</strong> <?= htmlspecialchars($user['username']) ?></p>
                <p class="mb-0"><strong>Email :</strong> <?= htmlspecialchars($user['email']) ?></p>
            </div>

            <form action="cart.php?action=checkout" method="post" class="needs-validation" novalidate>
                <div class="row g-3">
                    <div class="col-12">
                        <label for="address" class="form-label">Adresse</label>
                        <textarea class="form-control" id="address" name="address" placeholder="1234 Rue Principale..." required rows="3"><?= htmlspecialchars($user['address'] ?? '') ?></textarea>
                        <div class="invalid-feedback">
                            Veuillez entrer votre adresse de livraison.
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                <button class="w-100 btn btn-primary btn-lg" type="submit">Confirmer la commande</button>
            </form>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

<script>
// Script de validation de formulaire Bootstrap 5
// Example starter JavaScript for disabling form submissions if there are invalid fields
(() => {
  'use strict'

  // Fetch all the forms we want to apply custom Bootstrap validation styles to
  const forms = document.querySelectorAll('.needs-validation')

  // Loop over them and prevent submission
  Array.from(forms).forEach(form => {
    form.addEventListener('submit', event => {
      if (!form.checkValidity()) {
        event.preventDefault()
        event.stopPropagation()
      }

      form.classList.add('was-validated')
    }, false)
  })
})()
</script>