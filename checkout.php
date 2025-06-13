

<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$cart = $_SESSION['cart'] ?? [];
if (empty($cart)) {
    echo "🛒 Your cart is empty.";
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Checkout</title>
    <style>
        body { padding: 40px; font-family: Arial; background: #f4f4f4; }
        .checkout-form {
            max-width: 600px; margin: auto; background: #fff; padding: 30px;
            border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        input, textarea { width: 100%; padding: 12px; margin: 10px 0; border-radius: 6px; border: 1px solid #ccc; }
        button { background: #088178; color: white; padding: 12px 20px; border: none; border-radius: 6px; cursor: pointer; }
        button:hover { background: #0aa58f; }
    </style>
</head>
<body>
    <div class="checkout-form">
        <h2>🛍️ Checkout</h2>
        <form action="process_checkout.php" method="POST">
            <input type="text" name="name" placeholder="Full Name" required>
            <input type="email" name="email" placeholder="Email Address" required>
            <textarea name="address" placeholder="Delivery Address" required></textarea>
            <input type="text" name="phone" placeholder="Phone Number" required>

            <h3>💳 Payment Details (Dummy)</h3>
            <input type="text" name="card_number" placeholder="Card Number" required>
            <input type="text" name="expiry" placeholder="MM/YY" required>
            <input type="text" name="cvv" placeholder="CVV" required>

            <button type="submit">Confirm Order</button>
        </form>
    </div>
</body>
</html>
