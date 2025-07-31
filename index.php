<?php
require_once 'init.php';

use controllers\ProductController;

$controller = new ProductController();

// Simple router for public pages
$page = $_GET['page'] ?? 'home';

switch ($page) {
    case 'product':
        $controller->showProduct();
        break;

    case 'home':
    default:
        $controller->listProducts();
        break;
}
