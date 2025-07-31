<?php

namespace models;

class Auth
{
    public static function login($user)
    {
        // Set session variables
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

    public static function isLoggedIn()
    {
        return isset($_SESSION['user_id']);
    }

    public static function isAdmin()
    {
        return isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1;
    }
}