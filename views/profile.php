<?php require_once 'includes/header.php'; ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h3 class="mb-0"><i class="bi bi-person-circle"></i> Gérer mon compte</h3>
                </div>
                <div class="card-body p-4">
                    <?php if ($success): ?>
                        <div class="alert alert-success">
                            <i class="bi bi-check-circle"></i> Votre profil a été mis à jour avec succès.
                        </div>
                    <?php endif; ?>
                    
                    <?php if (!empty($errors)): ?>
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                <?php foreach ($errors as $error): ?>
                                    <li><?= $error ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                    
                    <form method="post">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="username"><i class="bi bi-person"></i> <?= LABEL_USERNAME ?></label>
                                    <input type="text" name="username" id="username" class="form-control" value="<?= htmlspecialchars($user['username']) ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="email"><i class="bi bi-envelope"></i> <?= LABEL_EMAIL ?></label>
                                    <input type="email" name="email" id="email" class="form-control" value="<?= htmlspecialchars($user['email']) ?>" required>
                                </div>
                            </div>
                        </div>
                        
                        <hr class="my-4">
                        <h5><i class="bi bi-lock"></i> Changer de mot de passe</h5>
                        <p class="text-muted small">Laissez ces champs vides si vous ne souhaitez pas changer votre mot de passe.</p>
                        
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="current_password">Mot de passe actuel</label>
                                    <input type="password" name="current_password" id="current_password" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="new_password">Nouveau mot de passe</label>
                                    <input type="password" name="new_password" id="new_password" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="confirm_password">Confirmer le mot de passe</label>
                                    <input type="password" name="confirm_password" id="confirm_password" class="form-control">
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-between mt-4">
                            <a href="index.php" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Retour
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Enregistrer les modifications
                            </button>
                        </div>
                    </form>
                </div>
                
                <?php if ($user['is_admin']): ?>
                <div class="card-footer bg-light">
                    <div class="d-flex justify-content-between align-items-center">
                        <span><i class="bi bi-shield-lock"></i> <strong>Statut:</strong> Administrateur</span>
                        <a href="admin.php" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-speedometer2"></i> Accéder au tableau de bord
                        </a>
                    </div>
                </div>
                <?php endif; ?>
            </div>

            <!-- Section Historique des commandes -->
            <div class="card shadow-sm mt-4">
                <div class="card-header bg-light">
                    <h4 class="mb-0"><i class="bi bi-receipt"></i> Historique de mes commandes</h4>
                </div>
                <div class="card-body">
                    <?php if (empty($orders)): ?>
                        <p class="text-center text-muted">Vous n'avez encore passé aucune commande.</p>
                    <?php else: ?>
                        <div class="accordion" id="ordersAccordion">
                            <?php foreach ($orders as $index => $order): ?>
                                <div class="card mb-2">
                                    <div class="card-header" id="heading<?= $order['id'] ?>">
                                        <h2 class="mb-0">
                                            <button class="btn btn-link btn-block text-left d-flex justify-content-between align-items-center" type="button" data-toggle="collapse" data-target="#collapse<?= $order['id'] ?>" aria-expanded="<?= $index === 0 ? 'true' : 'false' ?>" aria-controls="collapse<?= $order['id'] ?>">
                                                <span>
                                                    <strong>Commande #<?= $order['id'] ?></strong> - <span class="text-muted"><?= date('d/m/Y', strtotime($order['created_at'])) ?></span>
                                                </span>
                                                <span>
                                                    <span class="badge badge-info"><?= htmlspecialchars(ucfirst(str_replace('_', ' ', $order['status']))) ?></span>
                                                    <strong class="ml-3"><?= number_format($order['total_price'], 2, ',', ' ') ?> €</strong>
                                                </span>
                                            </button>
                                        </h2>
                                    </div>

                                    <div id="collapse<?= $order['id'] ?>" class="collapse <?= $index === 0 ? 'show' : '' ?>" aria-labelledby="heading<?= $order['id'] ?>" data-parent="#ordersAccordion">
                                        <div class="card-body">
                                            <h5>Détails de la commande</h5>
                                            <p>
                                                <strong>Adresse de livraison :</strong><br>
                                                <?= nl2br(htmlspecialchars($order['shipping_address'])) ?>
                                            </p>
                                            <hr>
                                            <h6 class="mb-3">Articles commandés :</h6>
                                            <?php if (!empty($order['items'])): ?>
                                                <ul class="list-group list-group-flush">
                                                    <?php foreach ($order['items'] as $item): ?>
                                                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                                            <div>
                                                                <?= htmlspecialchars($item['product_name'] ?? 'Produit supprimé') ?>
                                                                <small class="d-block text-muted">
                                                                    Quantité : <?= $item['quantity'] ?> &times; <?= number_format($item['price_at_purchase'], 2, ',', ' ') ?> €
                                                                </small>
                                                            </div>
                                                            <strong><?= number_format($item['quantity'] * $item['price_at_purchase'], 2, ',', ' ') ?> €</strong>
                                                        </li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>