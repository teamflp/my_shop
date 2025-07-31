<?php

namespace models;

use PDO;

class Category
{
    private $conn;
    private $table = 'categories';

    public function __construct()
    {
        $this->conn = Database::getInstance()->getConnection();
    }

    // Create
    public function create($name, $parent_id = null)
    {
        $query = "INSERT INTO " . $this->table . " (name, parent_id) VALUES (:name, :parent_id)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':parent_id', $parent_id);

        return $stmt->execute();
    }

    // Read all
    public function readAll()
    {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Read one
    public function readOne($id)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Update
    public function update($id, $name, $parent_id = null)
    {
        $query = "UPDATE " . $this->table . " SET name = :name, parent_id = :parent_id WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':parent_id', $parent_id);

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
}