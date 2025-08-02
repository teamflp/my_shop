<?php require_once __DIR__ . '/includes/header.php'; ?>

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0"><i class="bi bi-receipt-cutoff"></i> Détails de la Commande #<?= htmlspecialchars($order['id']) ?></h3>
        <a href="admin.php?action=manage-orders" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Retour à la liste
        </a>
    </div>

    <?php if (isset($_GET['update']) && $_GET['update'] === 'success'): ?>
        <div class="alert alert-success">
            Le statut de la commande a été mis à jour avec succès.
        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Articles de la commande</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Produit</th>
                                    <th class="text-center">Quantité</th>
                                    <th class="text-right">Prix Unitaire</th>
                                    <th class="text-right">Sous-total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($order['items'] as $item): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($item['product_name'] ?? 'Produit supprimé') ?></td>
                                        <td class="text-center"><?= $item['quantity'] ?></td>
                                        <td class="text-right"><?= number_format($item['price_at_purchase'], 2, ',', ' ') ?> €</td>
                                        <td class="text-right font-weight-bold"><?= number_format($item['quantity'] * $item['price_at_purchase'], 2, ',', ' ') ?> €</td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr class="bg-light">
                                    <td colspan="3" class="text-right"><strong>Total de la commande</strong></td>
                                    <td class="text-right font-weight-bold h5"><?= number_format($order['total_price'], 2, ',', ' ') ?> €</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="bi bi-person-circle"></i> Informations Client</h5>
                </div>
                <div class="card-body">
                    <p><strong>Nom :</strong> <?= htmlspecialchars($order['customer_name'] ?? 'N/A') ?></p>
                    <p><strong>Email :</strong> <?= htmlspecialchars($order['customer_email'] ?? 'N/A') ?></p>
                </div>
            </div>

            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="bi bi-truck"></i> Adresse de Livraison</h5>
                </div>
                <div class="card-body">
                    <p><?= nl2br(htmlspecialchars($order['shipping_address'])) ?></p>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="bi bi-toggles"></i> Mettre à jour le Statut</h5>
                </div>
                <div class="card-body">
                    <form action="admin.php?action=update_order_status" method="post">
                        <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                        <div class="form-group">
                            <label for="status">Statut de la commande</label>
                            <select name="status" id="status" class="form-control">
                                <option value="en_attente" <?= $order['status'] === 'en_attente' ? 'selected' : '' ?>>En attente</option>
                                <option value="expediee" <?= $order['status'] === 'expediee' ? 'selected' : '' ?>>Expédiée</option>
                                <option value="livree" <?= $order['status'] === 'livree' ? 'selected' : '' ?>>Livrée</option>
                                <option value="annulee" <?= $order['status'] === 'annulee' ? 'selected' : '' ?>>Annulée</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">
                            <i class="bi bi-save"></i> Mettre à jour
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>