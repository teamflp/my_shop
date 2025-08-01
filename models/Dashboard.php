<?php

namespace models;

use PDO;

class Dashboard
{
    private $conn;

    public function __construct()
    {
        $this->conn = Database::getInstance()->getConnection();
    }

    /**
     * Obtient le nombre de produits
     * @return int
     */
    public function getProductCount(): int
    {
        $query = "SELECT COUNT(*) as count FROM products";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int)$result['count'];
    }

    /**
     * Obtient le nombre de catégories
     * @return int
     */
    public function getCategoryCount(): int
    {
        $query = "SELECT COUNT(*) as count FROM categories";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int)$result['count'];
    }

    /**
     * Obtient le nombre d'utilisateurs
     * @return int
     */
    public function getUserCount(): int
    {
        $query = "SELECT COUNT(*) as count FROM users";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int)$result['count'];
    }

    /**
     * Obtient toutes les statistiques pour le tableau de bord
     * @return array
     */
    public function getStatistics(): array
    {
        return [
            'product_count' => $this->getProductCount(),
            'category_count' => $this->getCategoryCount(),
            'user_count' => $this->getUserCount()
        ];
    }

    /**
     * Récupère les derniers utilisateurs inscrits
     * @param int $limit Le nombre d'utilisateurs à récupérer
     * @return array
     */
    public function getLatestUsers(int $limit = 5): array
    {
        $query = "SELECT username, created_at FROM users ORDER BY created_at DESC LIMIT :limit";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}