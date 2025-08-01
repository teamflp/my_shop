<?php
require_once 'init.php';

use models\Auth;
use controllers\ProductController;
use controllers\CategoryController;
use controllers\UserController;

// Check if user is admin
if (!Auth::isAdmin()) {
    header('Location: index.php');
    exit();
}

$action = $_GET['action'] ?? 'dashboard';

// Simple router for admin actions
switch ($action) {
    // Product Actions
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
    case 'manage-users':
        (new UserController())->adminListUsers();
        break;
    case 'update_user_status':
        (new UserController())->updateUserAdminStatus();
        break;

    // Default to dashboard
    default:
        $user_count = (new \models\User())->countAll();
        $product_count = (new \models\Product())->countAll();
        $category_count = (new \models\Category())->countAll();
        require_once 'views/admin_dashboard.php';
        break;
}
