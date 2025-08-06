<?php

namespace models;

use PDO;

/**
 * Classe statique pour gérer le panier d'achat en session.
 */
class Cart
{
    /**
     * Initialise le panier en session s'il n'existe pas.
     */
    private static function init(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
    }

    /**
     * Ajoute un produit au panier ou met à jour sa quantité.
     */
    public static function add(int $productId, int $quantity = 1): void
    {
        self::init();
        $productModel = new Product();
        $product = $productModel->readOne($productId);

        if (!$product || $quantity <= 0) {
            return; // Le produit n'existe pas ou la quantité est invalide
        }

        $currentQuantity = $_SESSION['cart'][$productId] ?? 0;
        $newQuantity = $currentQuantity + $quantity;

        // Vérifie la quantité par rapport au stock disponible
        if ($newQuantity > $product['stock']) {
            $_SESSION['cart'][$productId] = $product['stock'];
        } else {
            $_SESSION['cart'][$productId] = $newQuantity;
        }
    }

    /**
     * Met à jour la quantité d'un produit dans le panier.
     */
    public static function update(int $productId, int $quantity): void
    {
        self::init();
        if (!isset($_SESSION['cart'][$productId])) {
            return;
        }

        if ($quantity <= 0) {
            self::remove($productId);
            return;
        }

        $productModel = new Product();
        $product = $productModel->readOne($productId);

        if (!$product) {
            self::remove($productId); // Le produit n'existe plus, on le retire
            return;
        }

        // Ajuste la quantité si elle dépasse le stock
        $_SESSION['cart'][$productId] = min($quantity, $product['stock']);
    }

    /**
     * Supprime un produit du panier.
     */
    public static function remove(int $productId): void
    {
        self::init();
        unset($_SESSION['cart'][$productId]);
    }

    /**
     * Récupère le contenu détaillé du panier avec les informations des produits.
     * @return array Un tableau contenant les 'items' et le 'total'.
     */
    public static function getDetailedContents(): array
    {
        self::init();
        if (empty($_SESSION['cart'])) {
            return ['items' => [], 'total' => 0];
        }

        $productModel = new Product();
        $productIds = array_keys($_SESSION['cart']);

        // Cette méthode doit être ajoutée au modèle Product pour l'efficacité
        $products = $productModel->getProductsByIds($productIds);

        $items = [];
        $total = 0;

        foreach ($products as $product) {
            $productId = $product['id'];

            if (!isset($_SESSION['cart'][$productId])) continue; // Le produit a pu être retiré entre temps

            $quantity = $_SESSION['cart'][$productId];

            // Sécurité : si le produit est en rupture de stock, on le retire du panier
            if ($product['stock'] <= 0) {
                self::remove($productId);
                continue;
            }

            // Sécurité : si la quantité demandée dépasse le stock, on l'ajuste
            if ($quantity > $product['stock']) {
                $quantity = $product['stock'];
                $_SESSION['cart'][$productId] = $quantity;
            }

            $subtotal = $product['price'] * $quantity;
            $items[] = [
                'id' => $productId,
                'name' => $product['name'],
                'price' => $product['price'],
                'image' => $product['image'],
                'quantity' => $quantity,
                'stock' => $product['stock'],
                'subtotal' => $subtotal
            ];
            $total += $subtotal;
        }

        return ['items' => $items, 'total' => $total];
    }

    /**
     * Compte le nombre total d'articles dans le panier.
     * @return int
     */
    public static function count(): int
    {
        self::init();
        return empty($_SESSION['cart']) ? 0 : array_sum($_SESSION['cart']);
    }

    /**
     * Vide complètement le panier.
     */
    public static function clear(): void
    {
        self::init();
        $_SESSION['cart'] = [];
    }

}
