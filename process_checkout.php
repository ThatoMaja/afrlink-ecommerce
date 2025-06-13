<?php
session_start();
include 'includes/db.php'; 

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Grabs form data (simulates saving)
    $name     = $_POST['name'];
    $email    = $_POST['email'];
    $address  = $_POST['address'];
    $phone    = $_POST['phone'];
    $user_id  = $_SESSION['user_id'];
    $total    = 999.99; // static for now

    // logic  

    unset($_SESSION['cart']); // Clear cart
    header("Location: payment_success.php");
    exit();
}
?>
