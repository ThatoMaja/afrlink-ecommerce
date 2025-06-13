<?php
session_start();
$cart = $_SESSION['cart'] ?? [];
?>

<?php include 'includes/back_button.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <title>Your Cart - Afrilink</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <style>
        body { padding: 30px; font-family: Arial; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px; border: 1px solid #ddd; text-align: center; }
        img { width: 60px; height: 60px; object-fit: cover; border-radius: 5px; }
        .btn { padding: 8px 15px; background: #ba4593; color: white; border: none; border-radius: 4px; text-decoration: none; }
    </style>
</head>
<body>

<h2>🛒 Your Cart</h2>

<?php if (empty($cart)): ?>
    <p>Your cart is empty.</p>
<?php else: ?>
    <table>
        <tr>
            <th>Image</th>
            <th>Product</th>
            <th>Qty</th>
            <th>Price</th>
            <th>Total</th>
            <th>Action</th>
        </tr>

        <?php $grand_total = 0; ?>
        <?php foreach ($cart as $id => $item): 
            $total = $item['price'] * $item['quantity'];
            $grand_total += $total;
        ?>
        <tr>
            <td><img src="uploads/<?php echo $item['image']; ?>"></td>
            <td><?php echo $item['title']; ?></td>
            <td>
                <form action="update_cart.php" method="post" style="display:flex; justify-content:center;">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" min="1" style="width: 60px; padding: 5px;">
                    <button type="submit" class="btn" style="margin-left: 5px;">↻</button>
                </form>
            </td>

            <td>R<?php echo number_format($item['price'], 2); ?></td>
            <td>R<?php echo number_format($total, 2); ?></td>
            <td><a class="btn" href="remove_from_cart.php?id=<?php echo $id; ?>">Remove</a></td>
        </tr>
        <?php endforeach; ?>
        <tr>
            <td colspan="4" style="text-align: right;"><strong>Grand Total:</strong></td>
            <td colspan="2"><strong>R<?php echo number_format($grand_total, 2); ?></strong></td>
        </tr>
        <tr>
            <td colspan="6" style="text-align: right; padding-top: 10px;">
                <a class="btn" href="checkout.php" style="background-color: green; padding: 12px 24px; font-size: 16px;">✅ Checkout</a>
            </td>
        </tr>

    </table>
<?php endif; ?>

</body>
</html>
