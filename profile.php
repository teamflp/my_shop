<?php
require_once 'init.php';

use controllers\UserController;

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: signin.php');
    exit();
}

// Handle profile management
(new UserController())->profile();