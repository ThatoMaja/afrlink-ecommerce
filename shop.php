<?php
session_start();
include 'includes/db.php';

// Search input
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

// SQL query including avg_rating and total_reviews
$query = "
    SELECT 
        p.*, 
        ROUND(AVG(r.rating), 1) AS avg_rating, 
        COUNT(r.id) AS total_reviews
    FROM products p
    LEFT JOIN reviews r ON p.id = r.product_id
    WHERE p.status = 'available'
    " . (!empty($search) ? "AND (p.title LIKE '%$search%' OR p.description LIKE '%$search%')" : "") . "
    GROUP BY p.id
    ORDER BY p.created_at DESC
";

$result = mysqli_query($conn, $query);
?>

<?php include 'includes/back_button.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <title>Marketplace - Afrilink</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 30px;
            background: #f9f9f9;
        }
        h2 {
            text-align: center;
            margin-bottom: 40px;
        }
        .grid {
            display: flex;
            flex-wrap: wrap;
            gap: 25px;
            justify-content: center;
        }
        .product {
            width: 280px;
            background: #fff;
            border-radius: 10px;
            padding: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: 0.2s ease-in-out;
        }
        .product:hover {
            transform: scale(1.02);
        }
        .product img {
            width: 100%;
            height: 200px;
            object-fit: contain;
            border-radius: 8px;
        }
        .product h4 {
            margin: 10px 0 5px;
        }
        .product p {
            font-size: 14px;
            color: #555;
        }
        .price {
            font-weight: bold;
            color: #ba4593;
            margin: 8px 0;
        }
        .btn {
            display: inline-block;
            padding: 10px;
            background-color: #088178;
            color: white;
            border-radius: 6px;
            text-decoration: none;
            text-align: center;
            margin-top: 10px;
        }
        .btn:hover {
            background-color: #0aa58f;
        }
    </style>
</head>
<body>

<!-- Search bar -->
<form method="GET" action="shop.php" style="text-align: center; margin: 30px 0;">
    <input type="text" name="search" placeholder="Search for products..." 
           value="<?php echo htmlspecialchars($search); ?>"
           style="padding: 10px; width: 300px; border-radius: 4px; border: 1px solid #ccc;">
    <button type="submit" style="padding: 10px 20px; background-color:rgb(40, 83, 182); color: white; border: none; border-radius: 4px;">
        🔍 Search
    </button>
</form>

<h2>🛍️ Afrilink Marketplace</h2>

<div class="grid">
    <?php if (mysqli_num_rows($result) > 0): ?>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <div class="product">
                <img src="uploads/<?php echo $row['image']; ?>" alt="Product Image">
                <h4><?php echo $row['title']; ?></h4>
                <p><?php echo $row['category']; ?></p>

                <?php if ($row['total_reviews'] > 0): ?>
                    <p style="color: #ffaa00;">
                        ⭐ <?php echo $row['avg_rating']; ?> (<?php echo $row['total_reviews']; ?> reviews)
                    </p>
                <?php else: ?>
                    <p style="color: #888;">No reviews yet</p>
                <?php endif; ?>

                <div class="price">R<?php echo number_format($row['price'], 2); ?></div>
                <a class="btn" href="product.php?id=<?php echo $row['id']; ?>">View</a>
                <a class="btn" href="add_to_cart.php?id=<?php echo $row['id']; ?>">🛒 Add to Cart</a>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>No products found. Try searching again.</p>
    <?php endif; ?>
</div>

</body>
</html>
