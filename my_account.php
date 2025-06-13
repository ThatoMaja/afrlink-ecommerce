<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<?php include 'includes/back_button.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <title>My Account - Afrilink</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <style>
        .account-container {
            display: flex;
            gap: 30px;
            padding: 40px 80px;
        }

        .account-nav {
            flex: 1;
            background: #f4f4f4;
            padding: 20px;
            border-radius: 8px;
        }

        .account-nav h3 {
            margin-bottom: 10px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 5px;
        }

        .account-nav ul {
            list-style: none;
            padding: 0;
        }

        .account-nav li {
            margin-bottom: 10px;
        }

        .account-nav a {
            text-decoration: none;
            color: #333;
        }

        .account-content {
            flex: 3;
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 8px rgba(0,0,0,0.05);
        }

        .account-content h2 {
            margin-bottom: 20px;
        }

        .account-content .section {
            margin-bottom: 30px;
        }
    </style>
</head>
<body>

<!-- <?php include 'includes/header.php'; ?>-->

<div class="account-container">
    <!-- Sidebar -->
    <div class="account-nav">
        <h3>Orders</h3>
        <ul>
            <li><a href="#">My Orders</a></li>
            <li><a href="#">Invoices</a></li>
            <li><a href="#">Returns</a></li>
            <li><a href="#">Product Reviews</a></li>
            <li><a href="#">My Lists</a></li>
        </ul>

        <h3>Payments</h3>
        <ul>
            <li><a href="#">Coupons & Offers</a></li>
            <li><a href="#">Credit & Refunds</a></li>
            <li><a href="#">Payment History</a></li>
        </ul>

        <h3>Profile</h3>
        <ul>
            <li><a href="#">Personal Details</a></li>
            <li><a href="#">Security Settings</a></li>
            <li><a href="#">Address Book</a></li>
            <li><a href="#">Newsletter Subscriptions</a></li>
        </ul>

        <h3>Support</h3>
        <ul>
            <li><a href="#">Help Centre</a></li>
        </ul>
    </div>

    <!-- Main content -->
    <div class="account-content">
        <h2>Welcome, <?php echo $_SESSION['full_name']; ?>!</h2>
        
        <div class="section">
            <h3>My Orders</h3>
            <p>You currently have 0 orders.</p>
        </div>

        <div class="section">
            <h3>My Profile</h3>
            <p>Name: <?php echo $_SESSION['full_name']; ?></p>
            <p>Email: <?php echo $_SESSION['email']; ?></p>
        </div>
    </div>
</div>

</body>
</html>
