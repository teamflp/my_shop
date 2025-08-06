<?php

namespace models;

use PDO;

class Product
{
    private PDO $conn;
    private string $table = 'products';

    public function __construct()
    {
        $this->conn = Database::getInstance()->getConnection();
    }

    /**
     * Crée un nouveau produit.
     */
    public function create(string $name, string $description, float $price, int $category_id, int $stock, ?string $image = null): bool
    {
        $query = "INSERT INTO " . $this->table . " (name, description, price, category_id, stock, image) VALUES (:name, :description, :price, :category_id, :stock, :image)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
        $stmt->bindParam(':stock', $stock, PDO::PARAM_INT);
        $stmt->bindParam(':image', $image);

        return $stmt->execute();
    }

    /**
     * Récupère tous les produits.
     * @return array
     */
    public function readAll(): array
    {
        $query = "SELECT p.id, p.name, p.description, p.price, p.stock, p.image, c.name as category_name 
                  FROM " . $this->table . " p 
                  LEFT JOIN categories c ON p.category_id = c.id 
                  ORDER BY p.created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère un produit par son ID.
     * @param int $id
     * @return array|false
     */
    public function readOne(int $id): false|array
    {
        // Ajout de p.category_id pour faciliter l'édition
        $query = "SELECT p.id, p.name, p.description, p.price, p.stock, p.image, p.category_id, c.name as category_name 
                  FROM " . $this->table . " p 
                  LEFT JOIN categories c ON p.category_id = c.id 
                  WHERE p.id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère les produits avec pagination.
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function readPaginated(int $limit, int $offset): array
    {
        $query = "SELECT p.id, p.name, p.description, p.price, p.stock, p.image, c.name as category_name 
                  FROM " . $this->table . " p 
                  LEFT JOIN categories c ON p.category_id = c.id 
                  ORDER BY p.created_at DESC
                  LIMIT :limit OFFSET :offset";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countAll()
    {
        $query = "SELECT COUNT(*) as count FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['count'];
    }

    /**
     * Met à jour un produit.
     */
    public function update(int $id, string $name, string $description, float $price, int $category_id, int $stock, ?string $image = null): bool
    {
        // Ne met à jour l'image que si une nouvelle est fournie
        $imageQueryPart = '';
        if ($image !== null) {
            $imageQueryPart = ', image = :image';
        }

        $query = "UPDATE " . $this->table . " SET name = :name, description = :description, price = :price, category_id = :category_id, stock = :stock" . $imageQueryPart . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
        $stmt->bindParam(':stock', $stock, PDO::PARAM_INT);

        if ($image !== null) {
            $stmt->bindParam(':image', $image);
        }

        return $stmt->execute();
    }

    /**
     * Récupère plusieurs produits par leurs IDs.
     * @param array $ids
     * @return array
     */
    public function getProductsByIds(array $ids): array
    {
        if (empty($ids)) {
            return [];
        }
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $query = "SELECT p.id, p.name, p.description, p.price, p.stock, p.image, c.name as category_name 
                  FROM " . $this->table . " p 
                  LEFT JOIN categories c ON p.category_id = c.id 
                  WHERE p.id IN ($placeholders)";
        $stmt = $this->conn->prepare($query);
        $stmt->execute($ids);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère les produits d'une catégorie spécifique.
     * @return array
     */
    public function readByCategory(int $category_id): array
    {
        $query = "SELECT p.id, p.name, p.description, p.price, p.image, c.name as category_name 
                  FROM " . $this->table . " p 
                  LEFT JOIN categories c ON p.category_id = c.id 
                  WHERE p.category_id = :category_id 
                  ORDER BY p.created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Supprime un produit.
     */
    public function delete(int $id): bool
    {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    /**
     * Décrémente le stock d'un produit.
     */
    public function decrementStock(int $productId, int $quantity): bool
    {
        // On s'assure de ne pas avoir de stock négatif
        $query = "UPDATE " . $this->table . " SET stock = stock - :quantity WHERE id = :id AND stock >= :quantity";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
        $stmt->bindParam(':id', $productId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount() > 0; // Retourne true si la mise à jour a eu lieu
    }
}