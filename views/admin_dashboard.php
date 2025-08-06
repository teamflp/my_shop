<?php require_once __DIR__ . '/admin/includes/header.php'; ?>

<style>
    /* Votre CSS personnalisé pour les interrupteurs */
    .switch {
      position: relative;
      display: inline-block;
      width: 60px;
      height: 34px;
    }
    .switch input {
      opacity: 0;
      width: 0;
      height: 0;
    }
    .slider {
      position: absolute;
      cursor: pointer;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-color: #ccc;
      transition: 0.4s;
      border-radius: 34px;
    }
    .slider:before {
      position: absolute;
      content: "";
      height: 26px;
      width: 26px;
      left: 4px;
      bottom: 4px;
      background-color: white;
      transition: 0.4s;
      border-radius: 50%;
    }
    input:checked + .slider {
      background-color: #4caf50; /* Vert pour ON */
    }
    input:checked + .slider:before {
      transform: translateX(26px);
    }
</style>

<div class="container py-4">
    <div class="jumbotron bg-primary text-white shadow-sm">
        <h1 class="display-4 text-white"><i class="bi bi-speedometer2"></i> Tableau de Bord</h1>
    </div>

    <div class="row mt-4">
        <div class="col-md-7">
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <i class="bi bi-graph-up"></i> Statistiques
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-4">
                            <p class="h2 text-primary"><?= $stats['products'] ?? 0 ?></p>
                            <p class="text-muted">Produits</p>
                        </div>
                        <div class="col-md-4">
                            <p class="h2 text-success"><?= $stats['categories'] ?? 0 ?></p>
                            <p class="text-muted">Catégories</p>
                        </div>
                        <div class="col-md-4">
                            <p class="h2 text-info"><?= $stats['users'] ?? 0 ?></p>
                            <p class="text-muted">Utilisateurs</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <i class="bi bi-person-plus"></i> Derniers Inscrits
                </div>
                <div class="card-body">
                    <?php if (!empty($latestUsers)): ?>
                        <ul class="list-group list-group-flush">
                            <?php foreach ($latestUsers as $user): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <?= htmlspecialchars($user['username']) ?>
                                <span class="badge bg-secondary"><?= date("d/m/Y", strtotime($user['created_at'])) ?></span>
                            </li> <?php endforeach; ?>
                        </ul> <?php else: ?>
                        <p class="text-center text-muted">Aucun.</p>
                   <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
