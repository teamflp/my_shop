<?php

namespace controllers;

use models\User;

class UserController
{
    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            // Simple validation
            if (empty($username) || empty($email) || empty($password)) {
                echo "Please fill all fields.";
                return;
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo "Invalid email format.";
                return;
            }

            $user = new User();
            if ($user->create($username, $email, $password)) {
                // Redirect to login page after successful registration
                header("Location: signin.php");
                exit();
            } else {
                echo "Registration failed.";
            }
        } else {
            // Display the registration form
            require_once __DIR__ . '/../views/form_signup.php';
        }
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            if (empty($email) || empty($password)) {
                echo "Please fill all fields.";
                return;
            }

            $userModel = new \models\User();
            $user = $userModel->findByEmail($email);

            if ($user && $userModel->verifyPassword($user, $password)) {
                \models\Auth::login($user);
                // Redirect to home page or dashboard
                header("Location: index.php");
                exit();
            } else {
                echo "Invalid credentials.";
            }
        } else {
            // Display the login form
            require_once __DIR__ . '/../views/form_signin.php';
        }
    }
}