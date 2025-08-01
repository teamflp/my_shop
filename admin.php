<?php
require_once 'init.php';

use models\Auth;
use controllers\DashboardController;
use controllers\ProductController;
use controllers\CategoryController;
use controllers\UserController;

/**
 * Si l'utilisateur n'a pas la permission d'accéder à la page admin,
 * il est redirigé vers la page d'accueil.
**/
if (!Auth::isAdmin()) {
    header('Location: index.php');
    exit();
}

$action = $_GET['action'] ?? 'dashboard';

switch ($action) {
    // Actions pour les produits
    case 'products':
        (new ProductController())->adminList();
        break;
    case 'add_product':
        (new ProductController())->add();
        break;
    case 'edit_product':
        (new ProductController())->edit();
        break;
    case 'delete_product':
        (new ProductController())->delete();
        break;

    // Actions pour les catégories
    case 'categories':
        (new CategoryController())->adminList();
        break;
    case 'add_category':
        (new CategoryController())->add();
        break;
    case 'edit_category':
        (new CategoryController())->edit();
        break;
    case 'delete_category':
        (new CategoryController())->delete();
        break;

    // Actions pour les utilisateurs
    case 'update_user_status':
        (new UserController())->updateUserAdminStatus();
        break;

    // Par défaut, afficher le tableau de bord
    case 'dashboard':
    default:
        (new DashboardController())->show();
        break;
}
