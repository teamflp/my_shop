<?php require_once __DIR__ . '/includes/header.php'; ?>

    <h2><?php echo isset($category) ? 'Edit' : 'Add'; ?> Category</h2>
    <form method="post">
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" class="form-control" value="<?= htmlspecialchars($category['name'] ?? '') ?>" required>
        </div>
        <div class="form-group">
            <label for="parent_id">Parent Category:</label>
            <select name="parent_id" id="parent_id" class="form-control">
                <option value="">None</option>
                <?php foreach ($categories as $cat): ?>
                    <?php if (isset($category) && $category['id'] == $cat['id']) continue; // A category cannot be its own parent ?>
                    <option value="<?= $cat['id'] ?>" <?php echo (isset($category) && $category['parent_id'] == $cat['id']) ? 'selected' : ''; ?>>
                        <?= htmlspecialchars($cat['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Save Category</button>
    </form>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
