<?php require_once 'includes/header.php'; ?>

<div class="container">
    <h2>Your Shopping Cart</h2>
    <?php if (empty($cart_items)): ?>
        <p>Your cart is empty.</p>
    <?php else: ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $total = 0; ?>
                <?php foreach ($cart_items as $item): ?>
                    <tr>
                        <td><?= htmlspecialchars($item['name']) ?></td>
                        <td>$<?= htmlspecialchars($item['price']) ?></td>
                        <td>
                            <form action="cart.php?action=update" method="post" class="form-inline">
                                <input type="hidden" name="product_id" value="<?= $item['id'] ?>">
                                <input type="number" name="quantity" value="<?= $item['quantity'] ?>" min="1" class="form-control" style="width: 70px;">
                                <button type="submit" class="btn btn-sm btn-primary ml-1">Update</button>
                            </form>
                        </td>
                        <td>$<?= number_format($item['price'] * $item['quantity'], 2) ?></td>
                        <td><a href="cart.php?action=remove&id=<?= $item['id'] ?>" class="btn btn-sm btn-danger">Remove</a></td>
                    </tr>
                    <?php $total += $item['price'] * $item['quantity']; ?>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3" class="text-right">Grand Total:</th>
                    <th colspan="2">$<?= number_format($total, 2) ?></th>
                </tr>
            </tfoot>
        </table>
    <?php endif; ?>
</div>

<?php require_once 'includes/footer.php'; ?>
