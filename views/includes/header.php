<?php
// We need to use Auth class, so let's make sure it's available
// This is a bit of a hack, but since we call this from different depths, it's safer
if (file_exists(__DIR__ . '/../../init.php')) {
    require_once __DIR__ . '/../../init.php';
}
use models\Auth;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Shop</title>
    <!-- Simple bootstrap for styling -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="index.php">My Shop</a>
    <div class="collapse navbar-collapse">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
            <?php if (Auth::isLoggedIn()): ?>
                <?php if (Auth::isAdmin()): ?>
                    <li class="nav-item"><a class="nav-link" href="admin.php">Admin Dashboard</a></li>
                <?php endif; ?>
                <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
            <?php else: ?>
                <li class="nav-item"><a class="nav-link" href="signin.php">Sign In</a></li>
                <li class="nav-item"><a class="nav-link" href="signup.php">Sign Up</a></li>
            <?php endif; ?>
        </ul>
    </div>
</nav>

<main class="py-4">
