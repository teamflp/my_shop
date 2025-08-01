<?php require_once 'includes/header.php'; ?>

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
    <!-- ... (le reste du haut du tableau de bord reste inchangé) ... -->
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
                            <p class="h2 text-primary"><?= $stats['product_count'] ?? 0 ?></p>
                        </div>
                        <div class="col-md-4">
                            <p class="h2 text-success"><?= $stats['category_count'] ?? 0 ?></p>
                        </div>
                        <div class="col-md-4">
                            <p class="h2 text-info"><?= $stats['user_count'] ?? 0 ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-5"> <div class="card shadow-sm"> <div class="card-header bg-light"> <i class="bi bi-person-plus"></i> Derniers Inscrits</div> <div class="card-body"> <?php if (!empty($latestUsers)): ?> <ul class="list-group list-group-flush"> <?php foreach ($latestUsers as $user): ?> <li class="list-group-item d-flex justify-content-between align-items-center"> <?= htmlspecialchars($user['username']) ?> <span class="badge bg-secondary"><?= date("d/m/Y", strtotime($user['created_at'])) ?></span> </li> <?php endforeach; ?> </ul> <?php else: ?> <p class="text-center text-muted">Aucun.</p> <?php endif; ?> </div></div></div>
    </div>

    <!-- Section de gestion des utilisateurs CORRIGÉE -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <i class="bi bi-people-fill"></i> Gestion des Utilisateurs
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover align-middle">
                            <thead class="thead-light">
                                <tr>
                                    <th>Utilisateur</th>
                                    <th>Email</th>
                                    <th class="text-center">Admin</th>
                                    <th class="text-center">Actif</th>
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($allUsers as $user): ?>
                                <tr>
                                    <!-- Un formulaire par ligne pour une soumission individuelle -->
                                    <form action="admin.php?action=update_user_status" method="post">
                                        <td><?= htmlspecialchars($user['username']) ?></td>
                                        <td><?= htmlspecialchars($user['email']) ?></td>

                                        <!-- Rôle (is_admin) -->
                                        <td class="text-center">
                                            <input type="hidden" name="role[<?= $user['id'] ?>]" value="user"> <!-- Valeur par défaut si la case n'est pas cochée -->
                                            <label class="switch">
                                                <input type="checkbox" name="role[<?= $user['id'] ?>]" value="admin" 
                                                    <?= ($user['is_admin'] == 1) ? 'checked' : '' ?> 
                                                    <?= ($user['id'] == ($_SESSION['user_id'] ?? 0)) ? 'disabled' : '' ?>>
                                                <span class="slider"></span>
                                            </label>
                                        </td>

                                        <!-- Statut -->
                                        <td class="text-center">
                                            <input type="hidden" name="status[<?= $user['id'] ?>]" value="suspended"> <!-- Valeur par défaut -->
                                            <label class="switch">
                                                <input type="checkbox" name="status[<?= $user['id'] ?>]" value="active" 
                                                    <?= ($user['status'] === 'active') ? 'checked' : '' ?> 
                                                    <?= ($user['id'] == ($_SESSION['user_id'] ?? 0)) ? 'disabled' : '' ?>>
                                                <span class="slider"></span>
                                            </label>
                                        </td>

                                        <!-- Action -->
                                        <td class="text-end">
                                            <button type="submit" name="update_user" value="<?= $user['id'] ?>" class="btn btn-primary btn-sm" <?= ($user['id'] == ($_SESSION['user_id'] ?? 0)) ? 'disabled' : '' ?>>
                                                Mettre à jour
                                            </button>
                                        </td>
                                    </form>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>