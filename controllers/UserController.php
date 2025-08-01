<?php

namespace controllers;

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
    
    public function profile()
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: signin.php");
            exit();
        }
        
        $errors = [];
        $success = false;
        $userModel = new User();
        $user = $userModel->readOne($_SESSION['user_id']);
        
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
                $is_admin = $user['is_admin'];
                $password_to_update = !empty($new_password) ? $new_password : null;
                
                if ($userModel->update($_SESSION['user_id'], $username, $email, $is_admin, $password_to_update)) {
                    $_SESSION['username'] = $username;
                    $success = true;
                    $user = $userModel->readOne($_SESSION['user_id']);
                } else {
                    $errors[] = "La mise à jour du profil a échoué.";
                }
            }
        }
        
        require_once __DIR__ . '/../views/profile.php';
    }

    public function login()
    {
        $errors = [];

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

    // --- Admin Methods ---

    public function adminListUsers()
    {
        \models\Auth::isAdmin() or die('Forbidden');
        $userModel = new \models\User();
        $users = $userModel->readAll();
        require_once __DIR__ . '/../views/admin/users.php';
    }

    public function updateUserAdminStatus()
    {
        \models\Auth::isAdmin() or die('Forbidden');
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'])) {
            $userModel = new \models\User();
            $user_id = $_POST['user_id'];
            // The value from the select will be '1' or '0'
            $is_admin = $_POST['is_admin'];
            $userModel->setAdminStatus($user_id, $is_admin);
        }
        // Redirect back to the user list
        header("Location: admin.php?action=manage-users");
                $errors[] = "Veuillez remplir tous les champs.";
            } else {
                $userModel = new \models\User();
                $user = $userModel->findByEmail($email);

                if ($user && $userModel->verifyPassword($user, $password)) {
                    if ($user['status'] === 'suspended') {
                        $errors[] = "Votre compte est suspendu. Veuillez contacter un administrateur.";
                    } else {
                        \models\Auth::login($user);
                        header("Location: index.php");
                        exit();
                    }
                } else {
                    $errors[] = "Identifiants invalides.";
                }
            }
        }
        
        require_once __DIR__ . '/../views/form_signin.php';
    }

    /**
     * Met à jour le statut et le rôle d'un utilisateur depuis le tableau de bord.
     */
    public function updateUserAdminStatus()
    {
        \models\Auth::isAdmin() or die('Forbidden');

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_user'])) {
            $userModel = new \models\User();
            $userId = $_POST['update_user'];
            
            $role = $_POST['role'][$userId] ?? 'user';
            $status = $_POST['status'][$userId] ?? 'suspended';

            if ($userId) {
                if ($userId == $_SESSION['user_id']) {
                    header("Location: admin.php?action=dashboard&error=self_update");
                    exit();
                }

                $userModel->updateStatusAndAdmin($userId, $role, $status);
            }
        }

        header("Location: admin.php?action=dashboard");
        exit();
    }
}