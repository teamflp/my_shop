<?php
use models\Auth;

// Les fichiers comme index.php ou cart.php incluent déjà init.php,
// qui démarre la session. Cette vérification est une sécurité supplémentaire.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Ma Boutique</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- Votre feuille de style personnalisée -->
    <link rel="stylesheet" href="../../assets/css/styles.css">
    <style>
        /* Assure que le footer reste en bas de la page, même si le contenu est court */
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        main {
            flex: 1;
        }
    </style>
</head>
<body>

<header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <i class="bi bi-shop"></i> Ma Boutique
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Catégories</a>
                    </li>
                </ul>
                <a href="cart.php" class="btn btn-outline-light position-relative me-3">
                    <i class="bi bi-cart-fill"></i>
                    Panier
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="cart-item-count"><?= \models\Cart::count() ?></span>
                </a>

                <!-- Section Admin / Connexion -->
                <ul class="navbar-nav">
                    <?php if (Auth::isAdmin()): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-white" href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-circle"></i> Admin
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="adminDropdown">
                                <li><a class="dropdown-item" href="admin.php"><i class="bi bi-speedometer2 me-2"></i> Tableau de bord</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="admin.php?action=logout"><i class="bi bi-box-arrow-right me-2"></i> Déconnexion</a></li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <a href="admin.php" class="btn btn-primary"><i class="bi bi-person-lock-fill me-1"></i> Connexion</a>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
</header>

<main>
<!-- Le contenu de la page sera inséré ici -->