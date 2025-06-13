<?php
session_start();
include 'includes/db.php';

if (!isset($_GET['id'])) {
    echo "No product ID provided.";
    exit();
}

$product_id = intval($_GET['id']);

$sql = "SELECT p.*, u.full_name AS seller_name, u.email AS seller_email 
        FROM products p 
        JOIN users u ON p.seller_id = u.id 
        WHERE p.id = $product_id";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 0) {
    echo "Product not found.";
    exit();
}

$product = mysqli_fetch_assoc($result);
$avg_query = "SELECT AVG(rating) AS avg_rating, COUNT(*) AS total_reviews 
              FROM reviews 
              WHERE product_id = $product_id";
$avg_result = mysqli_query($conn, $avg_query);
$avg_data = mysqli_fetch_assoc($avg_result);

$avg_rating = round($avg_data['avg_rating'], 1);
$total_reviews = $avg_data['total_reviews'];

?>

<?php include 'includes/back_button.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo $product['title']; ?> - Afrilink</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <style>
        .container {
            max-width: 800px;
            margin: 40px auto;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        .container img {
            width: 100%;
            max-height: 400px;
            object-fit: contain;
            border-radius: 10px;
        }
        h2 {
            margin-top: 20px;
            font-size: 28px;
            color: #222;
        }
        .price {
            font-size: 22px;
            color: #ba4593;
            font-weight: bold;
            margin: 10px 0;
        }
        .btn {
            background-color: #088178;
            color: #fff;
            padding: 12px 20px;
            display: inline-block;
            border-radius: 6px;
            text-decoration: none;
            margin-top: 20px;
        }
        .btn:hover {
            background-color: #0aa58f;
        }
        .details {
            margin-top: 15px;
            line-height: 1.6;
            color: #444;
        }
        .seller {
            margin-top: 25px;
            background: #f2f2f2;
            padding: 15px;
            border-radius: 8px;
        }
        .seller p { margin: 0; }

        .reviews, .review-form {
            margin-top: 30px;
        }
        .reviews p {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

<div class="container">
    <img src="uploads/<?php echo $product['image']; ?>" alt="Product Image">

    <h2>
        <?php echo $product['title']; ?>
        <?php if ($total_reviews > 0): ?>
            <span style="font-size: 18px; color: #ffaa00; margin-left: 10px;">
            ⭐ <?php echo $avg_rating; ?> (<?php echo $total_reviews; ?> reviews)
            </span>
        <?php endif; ?>
    </h2>

    <div class="price">R<?php echo number_format($product['price'], 2); ?></div>

    <div class="details">
        <strong>Category:</strong> <?php echo $product['category']; ?><br>
        <strong>Status:</strong> <?php echo ucfirst($product['status']); ?><br>
        <strong>Stock:</strong> <?php echo $product['stock']; ?><br><br>
        <p><?php echo $product['description']; ?></p>
    </div>

    <div class="seller">
        <h4>👤 Seller Info:</h4>
        <p><strong>Name:</strong> <?php echo $product['seller_name']; ?></p>
        <p><strong>Email:</strong> <?php echo $product['seller_email']; ?></p>
    </div>

    <a class="btn" href="mailto:<?php echo $product['seller_email']; ?>?subject=Interested in your product: <?php echo $product['title']; ?>">📧 Contact Seller</a>

    <?php if (isset($_SESSION['role']) && ($_SESSION['role'] == 'buyer' || $_SESSION['role'] == 'both')): ?>
        <?php if ($product['status'] == 'available' && $product['stock'] > 0): ?>
            <a class="btn" style="background-color: #ba4593;" href="buy.php?id=<?php echo $product['id']; ?>">🛒 Buy Now</a>
        <?php else: ?>
            <p style="color: red;">This product is sold out.</p>
        <?php endif; ?>
    <?php endif; ?>

    <div class="reviews">
        <h3>Customer Reviews</h3>
        <?php
        $review_query = "SELECT r.*, u.full_name FROM reviews r 
                         JOIN users u ON r.user_id = u.id 
                         WHERE r.product_id = $product_id 
                         ORDER BY r.created_at DESC";
        $review_result = mysqli_query($conn, $review_query);

        if (mysqli_num_rows($review_result) == 0) {
            echo "<p>No reviews yet. Be the first to review this product!</p>";
        } else {
            while ($review = mysqli_fetch_assoc($review_result)) {
                $stars = str_repeat("⭐", $review['rating']) . str_repeat("☆", 5 - $review['rating']);
                echo "<p><strong>{$review['full_name']}</strong> {$stars}<br>{$review['comment']}</p><hr>";
            }
        }
        ?>
    </div>

    <?php if (isset($_SESSION['user_id']) && ($_SESSION['role'] == 'buyer' || $_SESSION['role'] == 'both')): ?>
        <div class="review-form">
            <h4>Leave a Review</h4>
            <form action="submit_review.php" method="post">
                <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                <label>Rating (1-5):</label><br>
                <input type="number" name="rating" min="1" max="5" required><br><br>
                <label>Comment:</label><br>
                <textarea name="comment" rows="4" required></textarea><br>
                <button class="btn" type="submit">Submit Review</button>
            </form>
        </div>
    <?php endif; ?>

</div>

</body>
</html>
