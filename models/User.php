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
}