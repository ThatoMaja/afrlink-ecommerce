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
    <title>Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 40px;
            background-color: #f4f4f4;
        }

        h1 {
            color: #333;
        }

        .box {
            background: #fff;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .btn {
            display: inline-block;
            background-color:rgb(25, 103, 171);
            color: #fff;
            padding: 12px 20px;
            margin: 10px 5px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
            transition: 0.2s ease;
        }

        .btn:hover {
            background-color:rgb(188, 81, 163);
        }

        .logout {
            color: #81084d;
            margin-top: 20px;
            display: inline-block;
        }
    </style>
</head>
<body>

    <h1>Welcome, <?php echo $_SESSION['full_name']; ?> 👋</h1>
    <p>You are logged in as <strong><?php echo $_SESSION['role']; ?></strong>.</p>

    <div class="box">
        <?php if ($_SESSION['role'] == 'seller' || $_SESSION['role'] == 'both') : ?>
            <a href="add_product.php" class="btn">➕ Add New Product</a>
            <a href="my_products.php" class="btn">📦 My Listings</a>
        <?php endif; ?>

        <?php if ($_SESSION['role'] == 'buyer' || $_SESSION['role'] == 'both') : ?>
            <a href="shop.php" class="btn">🛒 Browse Marketplace</a>
            <a href="my_orders.php" class="btn">📄 My Orders</a>
        <?php endif; ?>

        <?php if ($_SESSION['email'] === 'admin@afrilink.com'): ?>
            <a href="admin_panel.php" class="btn">🧠 Admin Panel</a>
        <?php endif; ?>

    </div>

    <a class="logout" href="logout.php">🚪 Logout</a>

</body>
</html>



