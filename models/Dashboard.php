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
     * Obtient toutes les statistiques pour le tableau de bord en une seule requête optimisée.
     * @return array
     */
    public function getStatistics(): array
    {
        $query = "
            SELECT
                (SELECT COUNT(*) FROM products) AS product_count,
                (SELECT COUNT(*) FROM categories) AS category_count,
                (SELECT COUNT(*) FROM users) AS user_count
        ";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Retourne les résultats, en s'assurant que ce sont des entiers.
        return [
            'product_count' => (int)($result['product_count'] ?? 0),
            'category_count' => (int)($result['category_count'] ?? 0),
            'user_count' => (int)($result['user_count'] ?? 0)
        ];
    }

    /**
     * Récupère les derniers utilisateurs inscrits.
     * @param int $limit Le nombre d'utilisateurs à récupérer.
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
