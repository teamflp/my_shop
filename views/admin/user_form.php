<?php require_once __DIR__ . '/../includes/header.php'; ?>

<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-header bg-info text-white">
            <h3 class="mb-0"><i class="bi bi-person"></i> <?php echo isset($user) ? 'Modifier' : 'Ajouter'; ?> un utilisateur</h3>
        </div>
        <div class="card-body p-4">
            <form method="post">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="username"><i class="bi bi-person"></i> Nom d'utilisateur:</label>
                            <input type="text" name="username" id="username" class="form-control" value="<?= htmlspecialchars($user['username'] ?? '') ?>" placeholder="Nom d'utilisateur" required>
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="email"><i class="bi bi-envelope"></i> Email:</label>
                            <input type="email" name="email" id="email" class="form-control" value="<?= htmlspecialchars($user['email'] ?? '') ?>" placeholder="Adresse email" required>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="password"><i class="bi bi-lock"></i> Mot de passe:</label>
                            <input type="password" name="password" id="password" class="form-control" placeholder="<?= isset($user) ? 'Laisser vide pour ne pas modifier' : 'Mot de passe' ?>" <?= isset($user) ? '' : 'required' ?>>
                            <?php if (isset($user)): ?>
                                <small class="form-text text-muted">
                                    <i class="bi bi-info-circle"></i> Laissez ce champ vide si vous ne souhaitez pas modifier le mot de passe.
                                </small>
                            <?php endif; ?>
                        </div>
                        
                        <div class="form-group mb-3">
                            <div class="custom-control custom-switch mt-4">
                                <input type="checkbox" class="custom-control-input" id="is_admin" name="is_admin" <?= (isset($user) && $user['is_admin']) ? 'checked' : '' ?>>
                                <label class="custom-control-label" for="is_admin"><i class="bi bi-shield-lock"></i> Administrateur</label>
                                <small class="form-text text-muted">
                                    <i class="bi bi-info-circle"></i> Les administrateurs ont accès à toutes les fonctionnalités de gestion.
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="d-flex justify-content-between mt-4">
                    <a href="admin.php?action=users" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Retour
                    </a>
                    <button type="submit" class="btn btn-info">
                        <i class="bi bi-save"></i> Enregistrer l'utilisateur
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>