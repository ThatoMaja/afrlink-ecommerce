<?php
session_start();

if (isset($_POST['id']) && isset($_POST['quantity'])) {
    $id = intval($_POST['id']);
    $qty = max(1, intval($_POST['quantity']));
    
    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id]['quantity'] = $qty;
    }
}

header("Location: cart.php");
exit;
