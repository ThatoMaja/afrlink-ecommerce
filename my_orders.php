<?php
session_start();
include 'includes/db.php';

if (!isset($_SESSION['user_id']) || ($_SESSION['role'] !== 'buyer' && $_SESSION['role'] !== 'both')) {
    header("Location: login.php");
    exit();
}

$buyer_id = $_SESSION['user_id'];

// Fetches buyer's orders
$sql = "SELECT o.*, p.title, p.image, p.price, p.category 
        FROM orders o 
        JOIN products p ON o.product_id = p.id 
        WHERE o.buyer_id = $buyer_id 
        ORDER BY o.created_at DESC";

$result = mysqli_query($conn, $sql);
?>

<?php include 'includes/back_button.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <title>My Orders</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 40px;
            background-color: #f8f8f8;
        }
        h2 {
            text-align: center;
            margin-bottom: 30px;
        }
        .order {
            background: #fff;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 10px;
            display: flex;
            gap: 20px;
            box-shadow: 0 5px 10px rgba(0,0,0,0.05);
        }
        .order img {
            width: 140px;
            height: 140px;
            object-fit: cover;
            border-radius: 10px;
        }
        .details {
            flex-grow: 1;
        }
        .details h4 {
            margin-top: 0;
            color: #333;
        }
        .details p {
            margin: 6px 0;
        }
        .status {
            font-weight: bold;
            color: #ba4593;
        }
    </style>
</head>
<body>

<h2>📄 My Orders</h2>

<?php if (mysqli_num_rows($result) > 0): ?>
    <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <div class="order">
            <img src="uploads/<?php echo $row['image']; ?>" alt="Product">
            <div class="details">
                <h4><?php echo $row['title']; ?></h4>
                <p><strong>Category:</strong> <?php echo $row['category']; ?></p>
                <p><strong>Price:</strong> R<?php echo number_format($row['price'], 2); ?></p>
                <p><strong>Status:</strong> <span class="status"><?php echo ucfirst($row['status']); ?></span></p>
                <p><strong>Ordered On:</strong> <?php echo date("d M Y", strtotime($row['created_at'])); ?></p>
            </div>
        </div>
    <?php endwhile; ?>
<?php else: ?>
    <p style="text-align:center;">You haven’t ordered anything yet 😅</p>
<?php endif; ?>

</body>
</html>
