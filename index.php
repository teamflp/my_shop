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

    case 'order_success':
        // Affiche la page de confirmation de commande
        require_once __DIR__ . '/views/order_success.php';
        break;

    case 'home':
    default:
        $controller->listProducts();
        break;
}
