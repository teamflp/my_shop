<?php

namespace models;

class Cart
{
    public static function init()
    {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
    }

    public static function add($product_id, $quantity = 1)
    {
        self::init();
        // If product already in cart, update quantity
        if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id] += $quantity;
        } else {
            $_SESSION['cart'][$product_id] = $quantity;
        }
    }

    public static function update($product_id, $quantity)
    {
        self::init();
        if (isset($_SESSION['cart'][$product_id])) {
            if ($quantity > 0) {
                $_SESSION['cart'][$product_id] = $quantity;
            } else {
                self::remove($product_id);
            }
        }
    }

    public static function remove($product_id)
    {
        self::init();
        unset($_SESSION['cart'][$product_id]);
    }

    public static function getContents()
    {
        self::init();
        return $_SESSION['cart'];
    }

    public static function clear()
    {
        $_SESSION['cart'] = [];
    }

    public static function getDetailedContents()
    {
        self::init();
        $cart_contents = self::getContents();
        if (empty($cart_contents)) {
            return [];
        }

        $productModel = new Product();
        $product_ids = array_keys($cart_contents);

        // This is not the most efficient way for a large number of products,
        // but for this project it's fine. A single query with IN() would be better.
        $products = [];
        foreach ($product_ids as $id) {
            $product = $productModel->readOne($id);
            if ($product) {
                $product['quantity'] = $cart_contents[$id];
                $products[] = $product;
            }
        }
        return $products;
    }
}
