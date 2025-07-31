<?php

namespace models;

class Auth
{
    public static function login($user)
    {
    public static function login($user): void
    {
        // Enregistrer les informations de l'utilisateur dans la session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['is_admin'] = $user['is_admin'];
    }

    public static function logout()
    {
        // Unset all session values
        $_SESSION = array();

        // Destroy the session
        session_destroy();
    }

    public static function logout(): void
    {
        // On détruit toutes les variables de session
        $_SESSION = array();

        // Détruire la session
        session_destroy();
    }

    public static function isLoggedIn(): bool
    {
        return isset($_SESSION['user_id']);
    }

    public static function isAdmin(): bool
    {
        return isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1;
    }
}