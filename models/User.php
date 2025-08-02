<?php

namespace models;

use PDO;

class User
{
    private PDO $conn;
    private string $table = 'users';

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
        // Error logging should be handled by a dedicated logger or in the controller.
        // The previous line `printf("Error: %s.\n", $stmt->error);` was incorrect
        // as PDOStatement does not have an `error` property. One should use $stmt->errorInfo().
        return false;
    }

    /**
     * Trouve un utilisateur par son email.
     * @param string $email
     * @return array|false
     */
    public function findByEmail(string $email): array|false
    {
        $query = "SELECT * FROM " . $this->table . " WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Vérifie le mot de passe d'un utilisateur.
     * @param array $user
     * @param string $password
     * @return bool
     */
    public function verifyPassword($user, $password): bool
    {
        return password_verify($password, $user['password']);
    }

    /**
     * @param int $id
     * @return array|false
     */
    public function readOne(int $id): array|false
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
    public function updateStatusAndAdmin(int $id, string $role_string, string $status): bool
    {
        $is_admin_int = ($role_string === 'admin') ? 1 : 0;

        $query = "UPDATE " . $this->table . " SET is_admin = :is_admin, status = :status WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $status = htmlspecialchars(strip_tags($status));

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':is_admin', $is_admin_int, PDO::PARAM_INT);
        $stmt->bindParam(':status', $status);

        return $stmt->execute();
    }

    /**
     * Met à jour les informations de profil d'un utilisateur (username, email, password).
     * @param int $id
     * @param string $username
     * @param string $email
     * @param string|null $new_password
     * @return bool
     */
    public function updateProfile(int $id, string $username, string $email, ?string $new_password = null): bool
    {
        $params = [
            ':id' => $id,
            ':username' => $username,
            ':email' => $email
        ];

        $password_part = '';
        if ($new_password !== null) {
            $password_part = ', password = :password';
            $params[':password'] = password_hash($new_password, PASSWORD_DEFAULT);
        }

        $query = "UPDATE " . $this->table . " SET username = :username, email = :email" . $password_part . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute($params);
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
     * Récupère les derniers utilisateurs inscrits.
     * @param int $limit Le nombre d'utilisateurs à récupérer.
     * @return array
     */
    public function getLatestUsers(int $limit): array
    {
        // CORRIGÉ: La colonne est `created_at`, pas `created`.
        $query = "SELECT id, username, email, is_admin, status, created_at FROM " . $this->table . " ORDER BY created_at DESC LIMIT :limit";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Supprime un utilisateur.
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }

    /**
     * Met à jour le statut administrateur d'un utilisateur.
     * @param int $user_id L'ID de l'utilisateur à mettre à jour.
     * @param bool $is_admin Le nouveau statut (true pour admin, false pour non-admin).
     * @return bool Retourne true en cas de succès, false sinon.
     */
    public function setAdminStatus(int $user_id, bool $is_admin): bool
    {
        $query = "UPDATE " . $this->table . " SET is_admin = :is_admin WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        // Convertit le booléen en entier (1 ou 0) pour la base de données
        $is_admin_int = (int) $is_admin;

        $stmt->bindParam(':is_admin', $is_admin_int, PDO::PARAM_INT);
        $stmt->bindParam(':id', $user_id, PDO::PARAM_INT);

        return $stmt->execute();
    }
}