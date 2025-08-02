<?php

namespace controllers;

use models\Auth;
use models\Order;

class OrderController
{
    /**
     * Affiche la liste de toutes les commandes pour l'administrateur.
     */
    public function adminList(): void
    {
        Auth::isAdmin() or die('Forbidden');

        $orderModel = new Order();
        $orders = $orderModel->getAllOrders();

        require_once __DIR__ . '/../views/admin/orders.php';
    }

    /**
     * Affiche les détails d'une commande spécifique pour l'administrateur.
     */
    public function adminViewOrder(): void
    {
        Auth::isAdmin() or die('Forbidden');

        if (!isset($_GET['id'])) {
            header('Location: admin.php?action=manage-orders');
            exit();
        }

        $orderId = (int)$_GET['id'];
        $orderModel = new Order();
        $order = $orderModel->getOrderById($orderId);

        if (!$order) {
            // Gérer le cas où la commande n'existe pas
            header('Location: admin.php?action=manage-orders');
            exit();
        }

        $order['items'] = $orderModel->getOrderItems($orderId);

        require_once __DIR__ . '/../views/admin/order_details.php';
    }

    /**
     * Met à jour le statut d'une commande.
     */
    public function adminUpdateStatus(): void
    {
        Auth::isAdmin() or die('Forbidden');

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id'], $_POST['status'])) {
            $orderId = (int)$_POST['order_id'];
            $status = $_POST['status'];
            (new Order())->updateStatus($orderId, $status);
        }
        header('Location: admin.php?action=view_order&id=' . $orderId . '&update=success');
        exit();
    }
}