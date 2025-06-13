<?php
session_start();
include 'includes/db.php';

if (!isset($_SESSION['email']) || $_SESSION['email'] !== 'admin@afrilink.com') {
    echo "Access denied.";
    exit();
}

if (isset($_GET['id'])) {
    $product_id = intval($_GET['id']);

    // Deletes orders first, then product
    mysqli_query($conn, "DELETE FROM orders WHERE product_id = $product_id");
    mysqli_query($conn, "DELETE FROM products WHERE id = $product_id");

    header("Location: admin_panel.php");
}
?>
