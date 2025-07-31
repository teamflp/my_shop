<?php require_once __DIR__ . '/../includes/header.php'; ?>

<div class="container">
    <h2><?php echo isset($product) ? 'Edit' : 'Add'; ?> Product</h2>
    <form method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" class="form-control" value="<?= htmlspecialchars($product['name'] ?? '') ?>" required>
        </div>
        <div class="form-group">
            <label for="description">Description:</label>
            <textarea name="description" id="description" class="form-control" required><?= htmlspecialchars($product['description'] ?? '') ?></textarea>
        </div>
        <div class="form-group">
            <label for="price">Price:</label>
            <input type="number" step="0.01" name="price" id="price" class="form-control" value="<?= htmlspecialchars($product['price'] ?? '') ?>" required>
        </div>
        <div class="form-group">
            <label for="category_id">Category:</label>
            <select name="category_id" id="category_id" class="form-control" required>
                <option value="">Select Category</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?= $category['id'] ?>" <?php echo (isset($product) && $product['category_id'] == $category['id']) ? 'selected' : ''; ?>>
                        <?= htmlspecialchars($category['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="image">Image:</label>
            <input type="file" name="image" id="image" class="form-control-file">
            <?php if (isset($product) && !empty($product['image'])): ?>
                <p>Current image: <img src="<?= htmlspecialchars($product['image']) ?>" alt="" style="max-width: 100px;"></p>
                <input type="hidden" name="existing_image" value="<?= htmlspecialchars($product['image']) ?>">
            <?php endif; ?>
        </div>
        <button type="submit" class="btn btn-primary">Save Product</button>
    </form>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
