<?php

namespace controllers;

use models\Cart;
use models\Auth;
use models\Product;

class CartController
{
    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productId = filter_input(INPUT_POST, 'product_id', FILTER_VALIDATE_INT);
            $quantity = filter_input(INPUT_POST, 'quantity', FILTER_VALIDATE_INT, ['options' => ['default' => 1, 'min_range' => 1]]);

            if ($productId) {
                Cart::add($productId, $quantity);
            }
        }
        // Redirige vers la page précédente pour une meilleure expérience utilisateur
        header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? 'index.php'));
        exit();
    }

    public function update()
    {
        // Gère la mise à jour de plusieurs quantités depuis le formulaire du panier
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['quantities'])) {
            foreach ($_POST['quantities'] as $productId => $quantity) {
                $productId = (int)$productId;
                $quantity = (int)$quantity;
                if ($productId > 0) {
                    Cart::update($productId, $quantity);
                }
            }
        }
        header('Location: cart.php');
        exit();
    }

    public function remove()
    {
        $productId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if ($productId) {
            Cart::remove($productId);
        }
        header('Location: cart.php');
        exit();
    }

    public function view(): void
    {
        $cartData = Cart::getDetailedContents();
        // Extrait les clés 'items' et 'total' en variables $items et $total pour la vue
        extract($cartData);
        require_once __DIR__ . '/../views/cart.php';
    }

    public function summary()
    {
        // Renvoie un résumé du panier en JSON pour les mises à jour dynamiques (ex: icône du panier)
        header('Content-Type: application/json');
        echo json_encode([
            'itemCount' => Cart::count(),
            'total' => Cart::getDetailedContents()['total']
        ]);
        exit();
    }

    public function checkout()
    {
        // Étape 1: Exiger que l'utilisateur soit connecté
        if (!Auth::isLoggedIn()) {
            // Rediriger vers la page de connexion, puis revenir au panier après connexion
            header('Location: login.php?redirect=cart');
            exit();
        }

        $cartData = Cart::getDetailedContents();

        // Ne pas autoriser le checkout si le panier est vide
        if (empty($cartData['items'])) {
            header('Location: cart.php');
            exit();
        }

        $errors = [];
        $user = Auth::user(); // Récupérer les informations de l'utilisateur connecté

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Étape 2: Valider l'adresse de livraison du formulaire
            $shippingAddress = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_SPECIAL_CHARS);

            if (empty($shippingAddress)) {
                $errors[] = "L'adresse de livraison est requise.";
            }

            if (empty($errors)) {
                // Étape 3: Créer la commande en utilisant le modèle Order
                $orderModel = new \models\Order();
                $orderCreated = $orderModel->create($user['id'], $cartData['items'], $cartData['total'], $shippingAddress);

                if ($orderCreated) {
                    // Étape 4: Décrémenter le stock, vider le panier et rediriger
                $productModel = new Product();
                    foreach ($cartData['items'] as $item) {
                        $productModel->decrementStock($item['id'], $item['quantity']);
                    }
                    Cart::clear();
                    header('Location: index.php?page=order_success');
                    exit();
                } else {
                    $errors[] = "Une erreur est survenue lors de la création de votre commande. Veuillez réessayer.";
                }
            }
        }

        // Si c'est une requête GET, afficher la page de checkout
        extract($cartData);
        // On passe aussi les erreurs et les données de l'utilisateur à la vue
        require_once __DIR__ . '/../views/checkout.php';
    }
}
