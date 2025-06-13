<?php
session_start();
include 'includes/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] == 'seller') {
    // Only buyers or "both" can buy
    echo "You must be logged in as a buyer to place an order.";
    exit();
}

if (!isset($_GET['id'])) {
    echo "No product ID provided.";
    exit();
}

$product_id = intval($_GET['id']);
$buyer_id = $_SESSION['user_id'];

// 1. Check if product is available
$check = mysqli_query($conn, "SELECT * FROM products WHERE id = $product_id AND status = 'available'");
if (mysqli_num_rows($check) == 0) {
    echo "Product not available or already sold.";
    exit();
}

// 2. Insert order
$insert = mysqli_query($conn, "INSERT INTO orders (buyer_id, product_id, status) VALUES ($buyer_id, $product_id, 'pending')");

// 3. Mark product as sold
$update = mysqli_query($conn, "UPDATE products SET status = 'sold' WHERE id = $product_id");

if ($insert && $update) {
    echo "<h2 style='font-family:sans-serif;color:green;text-align:center;'>✅ Order placed successfully!</h2>";
    echo "<p style='text-align:center;'><a href='my_orders.php'>View My Orders</a></p>";
} else {
    echo "Something went wrong.";
}
?>
