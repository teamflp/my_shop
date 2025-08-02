<?php

namespace controllers;

use models\Auth;
use models\User;

class UserController
{
    public function register(): void
    {
        $errors = [];
      
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $password_confirm = $_POST['password_confirm'] ?? '';

            if (empty($username) || empty($email) || empty($password)) {
                $errors[] = ERROR_FILL_ALL_FIELDS;
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = ERROR_INVALID_EMAIL;
            }
            
            if ($password !== $password_confirm) {
                $errors[] = ERROR_PASSWORDS_DO_NOT_MATCH;
            }

            if (empty($errors)) {
                $user = new User();
                if ($user->create($username, $email, $password)) {
                    header("Location: signin.php");
                    exit();
                } else {
                    $errors[] = ERROR_REGISTRATION_FAILED;
                }
            }
        }
        
        require_once __DIR__ . '/../views/form_signup.php';
    }
    
    public function profile(): void
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: signin.php");
            exit();
        }
        
        $errors = [];
        $success = false;
        $userModel = new User();
        $user = $userModel->readOne($_SESSION['user_id']);
        $orderModel = new \models\Order();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $email = $_POST['email'];
            $current_password = $_POST['current_password'] ?? '';
            $new_password = $_POST['new_password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';
            
            if (empty($username) || empty($email)) {
                $errors[] = ERROR_FILL_REQUIRED_FIELDS;
            }
            
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = ERROR_INVALID_EMAIL;
            }
            
            if (!empty($new_password)) {
                if (empty($current_password) || !$userModel->verifyPassword($user, $current_password)) {
                    $errors[] = "Le mot de passe actuel est incorrect.";
                }
                
                if ($new_password !== $confirm_password) {
                    $errors[] = ERROR_PASSWORDS_DO_NOT_MATCH;
                }
            }
            
            if (empty($errors)) {
                $password_to_update = !empty($new_password) ? $new_password : null;
                
                if ($userModel->updateProfile($_SESSION['user_id'], $username, $email, $password_to_update)) {
                    $_SESSION['username'] = $username;
                    $success = true;
                    // Recharger les données de l'utilisateur pour afficher les infos à jour
                    $user = $userModel->readOne($_SESSION['user_id']);
                } else {
                    $errors[] = "La mise à jour du profil a échoué.";
                }
            }
        }

        // Récupère l'historique des commandes de l'utilisateur
        $orders = $orderModel->getOrdersByUserId($_SESSION['user_id']);
        // Pour chaque commande, récupérer les articles associés
        foreach ($orders as $key => $order) {
            $orders[$key]['items'] = $orderModel->getOrderItems($order['id']);
        }

        require_once __DIR__ . '/../views/profile.php';
    }

    public function login(): void
    {
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            if (empty($email) || empty($password)) {
                echo "Please fill all fields.";
                return;
            }

            $userModel = new User();
            $user = $userModel->findByEmail($email);

            if ($user && $userModel->verifyPassword($user, $password)) {
                Auth::login($user);
                // Rédirection vers la page d'accueil
                header("Location: index.php");
                exit();
            } else {
                echo "Invalid credentials.";
            }
        } else {
            // Formulaire de connexion
            require_once __DIR__ . '/../views/form_signin.php';
        }
    }

    // --- Méthodes Admin ---

    public function adminListUsers(): void
    {
        Auth::isAdmin() or die('Forbidden');
        $userModel = new User();
        $users = $userModel->readAll();
        require_once __DIR__ . '/../views/admin/users.php';
    }

    public function updateUserAdminStatus(): void
    {
        Auth::isAdmin() or die('Forbidden');

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'])) {
            $userModel = new User();
            $user_id = $_POST['user_id'];
            // La valeur doit être '1' ou '0'
            $is_admin = $_POST['is_admin'];
            $userModel->setAdminStatus($user_id, $is_admin);
            require_once __DIR__ . '/../views/form_signin.php';
        } else {
            $userModel = new User();
            $user = $userModel->findByEmail($email);

            if ($user && $userModel->verifyPassword($user, $password)) {
                if ($user['status'] === 'suspended') {
                    $errors[] = "Votre compte est suspendu. Veuillez contacter un administrateur.";
                } else {
                    Auth::login($user);
                    header("Location: index.php");
                    exit();
                }
            } else {
                $errors[] = "Identifiants invalides.";
            }
            require_once __DIR__ . '/../views/form_signin.php';
        }
    }
}