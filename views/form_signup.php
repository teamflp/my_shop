<?php require_once 'includes/header.php'; ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h3 class="mb-0"><i class="bi bi-person-plus-fill"></i> <?= LABEL_REGISTRATION ?></h3>
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
                    
                    <form action="signup.php" method="post">
                        <div class="form-group mb-3">
                            <label for="username"><i class="bi bi-person"></i> <?= LABEL_USERNAME ?></label>
                            <input type="text" name="username" id="username" class="form-control" placeholder="Choisissez un nom d'utilisateur" value="<?= isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '' ?>" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="email"><i class="bi bi-envelope"></i> <?= LABEL_EMAIL ?></label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="Votre adresse e-mail" value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="password"><i class="bi bi-lock"></i> <?= LABEL_PASSWORD ?></label>
                            <input type="password" name="password" id="password" class="form-control" placeholder="Créez un mot de passe" required>
                            <small class="form-text text-muted">
                                <?= LABEL_PASSWORD_HINT ?>
                            </small>
                        </div>
                        <div class="form-group mb-4">
                            <label for="password_confirm"><i class="bi bi-lock-fill"></i> <?= LABEL_PASSWORD_CONFIRM ?></label>
                            <input type="password" name="password_confirm" id="password_confirm" class="form-control" placeholder="Confirmez votre mot de passe" required>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="bi bi-check2-circle"></i> <?= LABEL_SIGNUP ?>
                            </button>
                        </div>
                    </form>
                </div>
                <div class="card-footer bg-light text-center">
                    <p class="mb-0"><?= LABEL_ALREADY_REGISTERED ?> <a href="signin.php" class="text-decoration-none"><?= LABEL_SIGNIN ?></a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
