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

    /**
     * Crée un nouvel utilisateur.
     * CORRIGÉ : Insère 0 dans is_admin, qui est un entier.
     */
    public function create($username, $email, $password): bool
    {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // La requête insère 0 pour is_admin et 'active' pour status
        $query = "INSERT INTO " . $this->table . " (username, email, password, is_admin, status, created_at) VALUES (:username, :email, :password, 0, 'active', NOW())";

        $stmt = $this->conn->prepare($query);

        $username = htmlspecialchars(strip_tags($username));
        $email = htmlspecialchars(strip_tags($email));

        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashed_password);

        if ($stmt->execute()) {
            return true;
        }
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

    public function verifyPassword($user, $password): bool
    {
        return password_verify($password, $user['password']);
    }

    public function ReadOne($id): array
    {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère tous les utilisateurs avec les colonnes nécessaires pour le tableau de bord.
     */
    public function readAll(): array
    {
        $query = "SELECT id, username, email, is_admin, status, created_at FROM " . $this->table . " ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Met à jour le statut et le rôle (is_admin) d'un utilisateur.
     * CORRIGÉ : Convertit le rôle (ex: "admin") en entier (1 ou 0) pour la BDD.
     */
    public function updateStatusAndAdmin($id, $role_string, $status): bool
    {
        $is_admin_int = ($role_string === 'admin') ? 1 : 0;

        $query = "UPDATE " . $this->table . " SET is_admin = :is_admin, status = :status WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $status = htmlspecialchars(strip_tags($status));

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':is_admin', $is_admin_int);
        $stmt->bindParam(':status', $status);

        return $stmt->execute();
    }
    
    public function delete($id)
    {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        
        return $stmt->execute();
    }
}