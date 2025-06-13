<?php
session_start();
include 'includes/db.php';

// Protect route
if ($_SESSION['email'] !== 'admin@afrilink.com') {
    echo "Access denied.";
    exit();
}

// Gets user ID from URL
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $delete = mysqli_query($conn, "DELETE FROM users WHERE id = $id");
    header("Location: admin_panel.php");
}
?>
