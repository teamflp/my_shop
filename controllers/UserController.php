<?php

namespace controllers;

use models\User;

class UserController
{
    public function register()
    {
        $errors = [];
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $password_confirm = $_POST['password_confirm'] ?? '';

            // Simple validation
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
                    // Rédiriger vers la page de connexion après la création de l'utilisateur
                    header("Location: signin.php");
                    exit();
                } else {
                    $errors[] = ERROR_REGISTRATION_FAILED;
                }
            }
        }
        
        // Formulaire d'inscription
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
            
            // Validation
            if (empty($username) || empty($email)) {
                $errors[] = ERROR_FILL_REQUIRED_FIELDS;
            }
            
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = ERROR_INVALID_EMAIL;
            }
            
            // If user wants to change password
            if (!empty($new_password)) {
                // Verify current password
                if (empty($current_password) || !$userModel->verifyPassword($user, $current_password)) {
                    $errors[] = "Le mot de passe actuel est incorrect.";
                }
                
                if ($new_password !== $confirm_password) {
                    $errors[] = ERROR_PASSWORDS_DO_NOT_MATCH;
                }
            }
            
            if (empty($errors)) {
                $is_admin = $user['is_admin']; // Preserve admin status
                $password_to_update = !empty($new_password) ? $new_password : null;
                
                if ($userModel->update($_SESSION['user_id'], $username, $email, $is_admin, $password_to_update)) {
                    // Update session username
                    $_SESSION['username'] = $username;
                    $success = true;
                    // Refresh user data
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
                $errors[] = ERROR_FILL_ALL_FIELDS;
            }

            if (empty($errors)) {
                $userModel = new \models\User();
                $user = $userModel->findByEmail($email);

                if ($user && $userModel->verifyPassword($user, $password)) {
                    \models\Auth::login($user);
                    // Redirect to home page or dashboard
                    header("Location: index.php");
                    exit();
                } else {
                    $errors[] = "Identifiants invalides.";
                }
            }
        }
        
        // Display the login form
        require_once __DIR__ . '/../views/form_signin.php';
    }
    
    // Méthode Admin pour la gestion des utilisateurs
    
    public function adminList()
    {
        $userModel = new User();
        $users = $userModel->readAll();
        require_once __DIR__ . '/../views/admin/users.php';
    }
    
    public function addUser()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $is_admin = isset($_POST['is_admin']) ? 1 : 0;
            
            // Simple validation
            if (empty($username) || empty($email) || empty($password)) {
                echo ERROR_FILL_ALL_FIELDS;
                return;
            }
            
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo ERROR_INVALID_EMAIL;
                return;
            }
            
            $userModel = new User();
            if ($userModel->create($username, $email, $password)) {
                header("Location: admin.php?action=users");
                exit();
            } else {
                echo ERROR_USER_ADD_FAILED;
            }
        } else {
            require_once __DIR__ . '/../views/admin/user_form.php';
        }
    }
    
    public function editUser(): void
    {
        $id = $_GET['id'];
        $userModel = new User();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $email = $_POST['email'];
            $is_admin = isset($_POST['is_admin']) ? 1 : 0;
            $password = !empty($_POST['password']) ? $_POST['password'] : null;
            
            if (empty($username) || empty($email)) {
                echo ERROR_FILL_REQUIRED_FIELDS;
                return;
            }
            
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo ERROR_INVALID_EMAIL;
                return;
            }
            
            if ($userModel->update($id, $username, $email, $is_admin, $password)) {
                header("Location: admin.php?action=users");
                exit();
            } else {
                echo ERROR_USER_UPDATE_FAILED;
            }
        } else {
            $user = $userModel->readOne($id);
            if (!$user) {
                echo ERROR_USER_NOT_FOUND;
                return;
            }
            require_once __DIR__ . '/../views/admin/user_form.php';
        }
    }
    
    public function deleteUser()
    {
        $id = $_GET['id'];
        $userModel = new User();
        
        // Don't allow deleting your own account
        if ($id == $_SESSION['user_id']) {
            echo ERROR_CANNOT_DELETE_OWN_ACCOUNT;
            return;
        }
        
        if ($userModel->delete($id)) {
            header("Location: admin.php?action=users");
            exit();
        } else {
            echo ERROR_USER_DELETE_FAILED;
        }
    }
}