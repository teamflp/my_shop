<?php

namespace models;

use PDO;

class User
{
    private $conn;
    private $table = 'users';

    public function __construct()
    {
        $this->conn = Database::getInstance()->getConnection();
    }

    public function create($username, $email, $password)
    {
        // Hash the password for security
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $query = "INSERT INTO " . $this->table . " (username, email, password) VALUES (:username, :email, :password)";

        $stmt = $this->conn->prepare($query);

        // Sanitize input
        $username = htmlspecialchars(strip_tags($username));
        $email = htmlspecialchars(strip_tags($email));

        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashed_password);

        if ($stmt->execute()) {
            return true;
        }

        // Print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);

        return false;
    }

    public function findByEmail($email)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function verifyPassword($user, $password)
    {
        return password_verify($password, $user['password']);
    }

    public function readAll()
    {
        $query = "SELECT id, username, email, is_admin, created_at FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function setAdminStatus($id, $is_admin)
    {
        $query = "UPDATE " . $this->table . " SET is_admin = :is_admin WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        // Ensure is_admin is 0 or 1
        $is_admin = $is_admin ? 1 : 0;

        $stmt->bindParam(':is_admin', $is_admin);
        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }

    public function countAll()
    {
        $query = "SELECT COUNT(*) as count FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['count'];
    }
}