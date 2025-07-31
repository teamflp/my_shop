<?php
require_once 'init.php';

use controllers\CartController;

$controller = new CartController();

$action = $_REQUEST['action'] ?? 'view';

switch ($action) {
    case 'add':
        $controller->add();
        break;
    case 'update':
        $controller->update();
        break;
    case 'remove':
        $controller->remove();
        break;
    case 'view':
    default:
        $controller->view();
        break;
}
