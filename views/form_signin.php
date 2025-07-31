<?php require_once 'includes/header.php'; ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0"><i class="bi bi-person-circle"></i> Connexion</h3>
                </div>
                <div class="card-body p-4">
                    <?php if (!empty($errors)): ?>
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                <?php foreach ($errors as $error): ?>
                                    <li><?= $error ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                    
                    <form action="signin.php" method="post">
                        <div class="form-group mb-3">
                            <label for="email"><i class="bi bi-envelope"></i> <?= LABEL_EMAIL ?></label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="Votre adresse e-mail" value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>" required>
                        </div>
                        <div class="form-group mb-4">
                            <label for="password"><i class="bi bi-lock"></i> <?= LABEL_PASSWORD ?></label>
                            <input type="password" name="password" id="password" class="form-control" placeholder="Votre mot de passe" required>
                            <small class="form-text text-muted">
                                <a href="#" class="text-decoration-none">Mot de passe oublié?</a>
                            </small>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-box-arrow-in-right"></i> <?= LABEL_SIGNIN ?>
                            </button>
                        </div>
                    </form>
                </div>
                <div class="card-footer bg-light text-center">
                    <p class="mb-0">Pas encore de compte? <a href="signup.php" class="text-decoration-none">S'inscrire</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
