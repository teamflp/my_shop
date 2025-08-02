<?php

namespace models;

use PDO;

class Order
{
    private PDO $conn;

    public function __construct()
    {
        $this->conn = Database::getInstance()->getConnection();
    }

    /**
     * Crée une nouvelle commande et ses articles associés dans une transaction.
     *
     * @param int $userId
     * @param array $cartItems
     * @param float $totalPrice
     * @param string $shippingAddress
     * @return bool
     */
    public function create(int $userId, array $cartItems, float $totalPrice, string $shippingAddress): bool
    {
        $this->conn->beginTransaction();

        try {
            $query = "INSERT INTO orders (user_id, total_price, shipping_address) VALUES (:user_id, :total_price, :shipping_address)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $stmt->bindParam(':total_price', $totalPrice);
            $stmt->bindParam(':shipping_address', $shippingAddress);
            $stmt->execute();
            $orderId = $this->conn->lastInsertId();

            $query_items = "INSERT INTO order_items (order_id, product_id, quantity, price_at_purchase) VALUES (:order_id, :product_id, :quantity, :price)";
            $stmt_items = $this->conn->prepare($query_items);

            foreach ($cartItems as $item) {
                $stmt_items->bindParam(':order_id', $orderId, PDO::PARAM_INT);
                $stmt_items->bindParam(':product_id', $item['id'], PDO::PARAM_INT);
                $stmt_items->bindParam(':quantity', $item['quantity'], PDO::PARAM_INT);
                $stmt_items->bindParam(':price', $item['price']);
                $stmt_items->execute();
            }

            // 3. Valider la transaction
            $this->conn->commit();
            return true;

        } catch (\Exception $e) {
            // En cas d'erreur, annuler toutes les opérations
            $this->conn->rollBack();
            // Idéalement, logguer l'erreur $e->getMessage()
            return false;
        }
    }

    /**
     * Récupère toutes les commandes d'un utilisateur spécifique.
     */
    public function getOrdersByUserId(int $userId): array
    {
        $query = "SELECT * FROM orders WHERE user_id = :user_id ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère les articles d'une commande spécifique, avec le nom du produit.
     */
    public function getOrderItems(int $orderId): array
    {
        $query = "SELECT oi.quantity, oi.price_at_purchase, p.name as product_name
                  FROM order_items oi
                  LEFT JOIN products p ON oi.product_id = p.id
                  WHERE oi.order_id = :order_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':order_id', $orderId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère toutes les commandes pour le panneau d'administration.
     * Joint avec la table des utilisateurs pour obtenir le nom du client.
     */
    public function getAllOrders(): array
    {
        $query = "SELECT o.id, o.total_price, o.status, o.created_at, u.username as customer_name
                  FROM orders o
                  LEFT JOIN users u ON o.user_id = u.id
                  ORDER BY o.created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère une commande spécifique par son ID, avec les infos du client.
     */
    public function getOrderById(int $orderId): array|false
    {
        $query = "SELECT o.*, u.username as customer_name, u.email as customer_email
                  FROM orders o
                  LEFT JOIN users u ON o.user_id = u.id
                  WHERE o.id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $orderId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Met à jour le statut d'une commande.
     */
    public function updateStatus(int $orderId, string $status): bool
    {
        // Liste des statuts valides pour la sécurité
        $allowed_statuses = ['en_attente', 'expediee', 'livree', 'annulee'];
        if (!in_array($status, $allowed_statuses)) {
            return false;
        }

        $query = "UPDATE orders SET status = :status WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':id', $orderId, PDO::PARAM_INT);

        return $stmt->execute();
    }
}