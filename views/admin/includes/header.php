<?php
if (file_exists(__DIR__ . '/../../../init.php')) {
    require_once __DIR__ . '/../../../init.php';
}
use models\Auth;

// Rédirection vers la page d'accueil si l'utilisateur n'est pas admin
if (!Auth::isAdmin()) {
    header('Location: ../../index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        #sidebar-wrapper {
            min-height: 100vh;
            width: 260px; /* Largeur professionnelle */
            background-color: #2c3e50; /* Bleu/gris foncé */
            color: #ecf0f1;
            transition: all 0.3s;
            display: flex;
            flex-direction: column;
        }

        .sidebar-heading {
            padding: 1.25rem;
            font-size: 1.5rem;
            font-weight: 700;
            color: #fff;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            text-align: center;
        }
        .sidebar-heading .bi {
            margin-right: 0.75rem;
        }

        #sidebar-wrapper .list-group {
            width: 100%;
            flex-grow: 1; /* Occupe l'espace disponible */
        }

        .list-group-item {
            display: flex;
            align-items: center;
            background-color: transparent;
            color: #bdc3c7;
            border: none;
            padding: 1rem 1.5rem;
            font-size: 1rem;
            font-weight: 500;
            transition: all 0.2s ease-in-out;
        }

        .list-group-item .bi {
            margin-right: 1rem;
            font-size: 1.3rem;
            min-width: 24px; /* Aligner le texte */
            text-align: center;
            color: #3498db; /* Un bleu agréable pour les icônes */
        }

        .list-group-item-action:hover,
        .list-group-item-action:focus,
        .list-group-item.active {
            background-color: #34495e;
            color: #fff;
            text-decoration: none;
        }
        .list-group-item-action:hover .bi,
        .list-group-item-action:focus .bi,
        .list-group-item.active .bi {
            color: #fff;
        }

        /* Couleur spéciale pour les actions importantes/dangereuses */
        .list-group-item.text-danger .bi {
            color: #e74c3c;
        }
        .list-group-item.text-danger:hover {
            background-color: rgba(231, 76, 60, 0.1);
            color: #e74c3c !important;
        }

        .sidebar-footer {
            padding: 1rem 1.5rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            color: #bdc3c7;
            font-size: 0.9rem;
        }
        .sidebar-footer .bi {
            margin-right: 0.75rem;
        }

        #page-content-wrapper {
            /* Fait en sorte que le conteneur de contenu principal
               s'étende pour remplir l'espace restant à côté de la barre latérale. */
            flex-grow: 1;
        }
    </style>
</head>
<body>
<div class="d-flex" id="wrapper">
    <!-- Sidebar -->
    <div id="sidebar-wrapper">
        <div class="sidebar-heading"><i class="bi bi-shield-check"></i> Admin Panel</div>
        <div class="list-group list-group-flush">
            <a href="../admin.php?action=dashboard" class="list-group-item list-group-item-action"><i class="bi bi-speedometer2"></i> Tableau de bord</a>
            <a href="../admin.php?action=products" class="list-group-item list-group-item-action"><i class="bi bi-box-seam"></i> Gérer les Produits</a>
            <a href="../admin.php?action=categories" class="list-group-item list-group-item-action"><i class="bi bi-tags"></i> Gérer les Catégories</a>
            <a href="../admin.php?action=manage-orders" class="list-group-item list-group-item-action"><i class="bi bi-receipt"></i> Gérer les Commandes</a>
            <a href="../admin.php?action=manage-users" class="list-group-item list-group-item-action"><i class="bi bi-people"></i> Gérer les Utilisateurs</a>
            <a href="../index.php" class="list-group-item list-group-item-action"><i class="bi bi-shop"></i> Voir la boutique</a>
            <a href="../logout.php" class="list-group-item list-group-item-action text-danger"><i class="bi bi-box-arrow-right"></i> Déconnexion</a>
        </div>
        <div class="sidebar-footer">
            <div>
                <i class="bi bi-person-circle"></i>
                <span><?= htmlspecialchars($_SESSION['username'] ?? 'Admin') ?></span>
            </div>
        </div>
    </div>
    <!-- /#sidebar -->

    <!-- Page Content -->
    <div id="page-content-wrapper">
        <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="bi bi-person-circle"></i> <?= htmlspecialchars($_SESSION['username'] ?? 'Admin') ?>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="../profile.php"><i class="bi bi-gear"></i> Gérer mon compte</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="../logout.php"><i class="bi bi-box-arrow-right"></i> Déconnexion</a>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
        <div class="container-fluid pt-4 px-0">