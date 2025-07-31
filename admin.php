<?php
require_once 'init.php';

use models\Auth;
use controllers\DashboardController;
use controllers\ProductController;
use controllers\CategoryController;
use controllers\UserController;

// Check if user is admin
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

    // Category Actions
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
        
    // User Actions
    case 'users':
        (new UserController())->adminList();
        break;
    case 'add_user':
        (new UserController())->addUser();
        break;
    case 'edit_user':
        (new UserController())->editUser();
        break;
    case 'delete_user':
        (new UserController())->deleteUser();
        break;

    // Default to dashboard
    default:
        (new DashboardController())->show();
        break;
}
