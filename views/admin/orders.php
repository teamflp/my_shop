<?php require_once __DIR__ . '/includes/header.php'; ?>

<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
            <h3 class="mb-0"><i class="bi bi-receipt"></i> Gestion des Commandes</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="bg-light">
                        <tr>
                            <th># Commande</th>
                            <th>Client</th>
                            <th>Date</th>
                            <th>Statut</th>
                            <th class="text-end">Total</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($orders)): ?>
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <p class="mb-0">Aucune commande n'a été trouvée.</p>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($orders as $order): ?>
                            <tr>
                                <td><strong><?= htmlspecialchars($order['id']) ?></strong></td>
                                <td><?= htmlspecialchars($order['customer_name'] ?? 'Client supprimé') ?></td>
                                <td><?= date('d/m/Y H:i', strtotime($order['created_at'])) ?></td>
                                <td>
                                    <?php
                                        $status_class = 'bg-secondary';
                                        if ($order['status'] === 'expediee') $status_class = 'bg-primary';
                                        if ($order['status'] === 'livree') $status_class = 'bg-success';
                                        if ($order['status'] === 'annulee') $status_class = 'bg-danger';
                                    ?>
                                    <span class="badge <?= $status_class ?> p-2">
                                        <?= htmlspecialchars(ucfirst(str_replace('_', ' ', $order['status']))) ?>
                                    </span>
                                </td>
                                <td class="text-end fw-bold"><?= number_format($order['total_price'], 2, ',', ' ') ?> €</td>
                                <td class="text-center">
                                    <a href="admin.php?action=view_order&id=<?= $order['id'] ?>" class="btn btn-sm btn-info">
                                        <i class="bi bi-eye"></i> Voir
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>