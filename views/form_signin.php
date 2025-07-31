<?php require_once 'includes/header.php'; ?>

<div class="container">
    <h2>Sign In</h2>
    <form action="signin.php" method="post">
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Sign In</button>
    </form>
</div>

<?php require_once 'includes/footer.php'; ?>
