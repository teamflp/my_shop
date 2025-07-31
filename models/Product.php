<?php

namespace models;

use PDO;

class Product
{
    private $conn;
    private $table = 'products';

    public function __construct()
    {
        $this->conn = Database::getInstance()->getConnection();
    }

    // Create
    public function create($name, $description, $price, $category_id, $image = null)
    {
        $query = "INSERT INTO " . $this->table . " (name, description, price, category_id, image) VALUES (:name, :description, :price, :category_id, :image)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':category_id', $category_id);
        $stmt->bindParam(':image', $image);

        return $stmt->execute();
    }

    // Read all
    public function readAll()
    {
        $query = "SELECT p.id, p.name, p.description, p.price, p.image, c.name as category_name FROM " . $this->table . " p LEFT JOIN categories c ON p.category_id = c.id ORDER BY p.created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Read one
    public function readOne($id)
    {
        $query = "SELECT p.id, p.name, p.description, p.price, p.image, c.name as category_name FROM " . $this->table . " p LEFT JOIN categories c ON p.category_id = c.id WHERE p.id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Update
    public function update($id, $name, $description, $price, $category_id, $image = null)
    {
        $query = "UPDATE " . $this->table . " SET name = :name, description = :description, price = :price, category_id = :category_id, image = :image WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':category_id', $category_id);
        $stmt->bindParam(':image', $image);

        return $stmt->execute();
    }

    // Delete
    public function delete($id)
    {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // Read by category
    public function readByCategory($category_id)
    {
        $query = "SELECT p.id, p.name, p.description, p.price, p.image, c.name as category_name FROM " . $this->table . " p LEFT JOIN categories c ON p.category_id = c.id WHERE p.category_id = :category_id ORDER BY p.created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':category_id', $category_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}