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
     * Get count of products
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
     * Get count of categories
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
     * Get count of users
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
     * Get all statistics for dashboard
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
}