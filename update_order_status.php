<?php
session_start();
include 'includes/db.php';

// Only admin allowed
if (!isset($_SESSION['email']) || $_SESSION['email'] !== 'admin@afrilink.com') {
    echo "Access denied.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_id = intval($_POST['order_id']);
    $new_status = mysqli_real_escape_string($conn, $_POST['status']);

    $update = mysqli_query($conn, "UPDATE orders SET status = '$new_status' WHERE id = $order_id");

    if ($update) {
        header("Location: admin_panel.php");
        exit();
    } else {
        echo "Failed to update order status.";
    }
}
?>
