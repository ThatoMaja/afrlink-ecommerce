<?php
session_start();
if (!isset($_SESSION['user_id']) || ($_SESSION['role'] !== 'seller' && $_SESSION['role'] !== 'both')) {
    header("Location: login.php");
    exit();
}

include 'includes/db.php';

$user_id = $_SESSION['user_id'];

// Fetches the seller's products
$sql = "SELECT * FROM products WHERE seller_id = $user_id ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);
?>

<?php include 'includes/back_button.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <title>My Products</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <style>
        .container {
            max-width: 1000px;
            margin: 40px auto;
            padding: 20px;
        }
        h2 {
            margin-bottom: 20px;
        }
        .product-card {
            background: #fff;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0 5px 10px rgba(0,0,0,0.1);
            display: flex;
            gap: 20px;
        }
        .product-card img {
            width: 150px;
            border-radius: 8px;
            object-fit: cover;
        }
        .product-info {
            flex-grow: 1;
        }
        .product-info h4 {
            margin: 0 0 10px;
            color: #333;
        }
        .product-info p {
            margin: 4px 0;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>📦 My Products</h2>

    <?php if (mysqli_num_rows($result) > 0): ?>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <div class="product-card">
                <img src="uploads/<?php echo $row['image']; ?>" alt="Product Image">
                <div class="product-info">
                    <h4><?php echo $row['title']; ?></h4>
                    <p><strong>Price:</strong> R<?php echo number_format($row['price'], 2); ?></p>
                    <p><strong>Category:</strong> <?php echo $row['category']; ?></p>
                    <p><strong>Status:</strong> <?php echo ucfirst($row['status']); ?></p>
                    <p><?php echo $row['description']; ?></p>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>You haven't uploaded any products yet.</p>
    <?php endif; ?>
</div>

</body>
</html>
