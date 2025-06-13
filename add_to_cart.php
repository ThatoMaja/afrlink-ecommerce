<?php
session_start();
include 'includes/db.php';

if (!isset($_GET['id'])) {
    header('Location: shop.php');
    exit;
}



$product_id = intval($_GET['id']);

// Fetch product info
$sql = "SELECT * FROM products WHERE id = $product_id AND status = 'available'";
$result = mysqli_query($conn, $sql);
$product = mysqli_fetch_assoc($result);

if (!$product) {
    header('Location: shop.php');
    exit;
}

// Initialize cart 
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// If product is already in cart, increase qty
if (isset($_SESSION['cart'][$product_id])) {
    $_SESSION['cart'][$product_id]['quantity'] += 1;
} else {
    $_SESSION['cart'][$product_id] = [
        'title' => $product['title'],
        'price' => $product['price'],
        'image' => $product['image'],
        'quantity' => 1
    ];
}

header('Location: cart.php');
exit;
?>
