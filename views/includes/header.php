<?php
// We need to use Auth class, so let's make sure it's available
// This is a bit of a hack, but since we call this from different depths, it's safer
if (file_exists(__DIR__ . '/../../init.php')) {
    require_once __DIR__ . '/../../init.php';
}
use models\Auth;
?>

<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ma Boutique</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="index.php"><i class="bi bi-shop"></i> Ma Boutique</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a class="nav-link" href="index.php"><i class="bi bi-house-door"></i> Accueil</a></li>
                <?php if (Auth::isLoggedIn()): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="bi bi-person-circle"></i> <?= $_SESSION['username'] ?>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="profile.php"><i class="bi bi-gear"></i> Gérer mon compte</a>
                            <?php if (Auth::isAdmin()): ?>
                                <a class="dropdown-item" href="admin.php"><i class="bi bi-speedometer2"></i> Tableau de bord</a>
                            <?php endif; ?>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="logout.php"><i class="bi bi-box-arrow-right"></i> Déconnexion</a>
                        </div>
                    </li>
                    <?php if (Auth::isAdmin()): ?>
                        <li class="nav-item"><a class="nav-link" href="admin.php"><i class="bi bi-speedometer2"></i> Tableau de bord</a></li>
                    <?php endif; ?>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="signin.php"><i class="bi bi-person"></i> Connexion</a></li>
                    <li class="nav-item"><a class="nav-link" href="signup.php"><i class="bi bi-person-plus"></i> Inscription</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<main class="py-4">
