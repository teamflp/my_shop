<?php
require_once 'init.php';

use models\Auth;
use controllers\ProductController;
use controllers\CategoryController;

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

    // Default to dashboard
    default:
        require_once 'views/admin_dashboard.php';
        break;
}
