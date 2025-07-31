<?php

namespace controllers;

use models\Cart;

class CartController
{
    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
            $product_id = $_POST['product_id'];
            $quantity = $_POST['quantity'] ?? 1;
            Cart::add($product_id, $quantity);
        }
        // Redirect back to the products page, or to the cart
        header('Location: index.php');
        exit();
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
            Cart::update($_POST['product_id'], $_POST['quantity']);
        }
        header('Location: cart.php');
        exit();
    }

    public function remove()
    {
        if (isset($_GET['id'])) {
            Cart::remove($_GET['id']);
        }
        header('Location: cart.php');
        exit();
    }

    public function view()
    {
        $cart_items = Cart::getDetailedContents();
        require_once __DIR__ . '/../views/cart.php';
    }
}
