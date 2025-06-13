<?php
session_start();
include 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    echo "You must be logged in to submit a review.";
    exit;
}

$product_id = intval($_POST['product_id']);
$user_id = $_SESSION['user_id'];
$rating = intval($_POST['rating']);
$comment = mysqli_real_escape_string($conn, $_POST['comment']);

if ($rating < 1 || $rating > 5) {
    echo "Invalid rating.";
    exit;
}

$query = "INSERT INTO reviews (product_id, user_id, rating, comment) 
          VALUES ($product_id, $user_id, $rating, '$comment')";

if (mysqli_query($conn, $query)) {
    header("Location: product.php?id=$product_id");
    exit;
} else {
    echo "Error submitting review.";
}
?>
