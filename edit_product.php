<?php
session_start();
include 'includes/db.php';

// Only admin allowed
if (!isset($_SESSION['email']) || $_SESSION['email'] !== 'admin@afrilink.com') {
    echo "Access denied.";
    exit();
}

if (!isset($_GET['id'])) {
    echo "No product ID provided.";
    exit();
}

$product_id = intval($_GET['id']);

// Gets product details
$query = mysqli_query($conn, "SELECT * FROM products WHERE id = $product_id");
$product = mysqli_fetch_assoc($query);

if (!$product) {
    echo "Product not found.";
    exit();
}

// Handles form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $price = floatval($_POST['price']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    $update = mysqli_query($conn, "UPDATE products SET 
        title = '$title', 
        price = $price, 
        category = '$category', 
        description = '$description', 
        status = '$status'
        WHERE id = $product_id");

    if ($update) {
        header("Location: admin_panel.php");
        exit();
    } else {
        echo "Failed to update product.";
    }
}
?>

<?php include 'includes/back_button.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Product</title>
    <style>
        body {
            font-family: Arial;
            padding: 40px;
            background-color: #f4f4f4;
        }
        form {
            max-width: 600px;
            margin: auto;
            background: #fff;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
        }
        label {
            display: block;
            margin-top: 15px;
        }
        input, textarea, select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
        }
        button {
            margin-top: 20px;
            background: #088178;
            color: #fff;
            padding: 12px;
            border: none;
            width: 100%;
            border-radius: 6px;
            cursor: pointer;
        }
    </style>
</head>
<body>

<h2>✏️ Edit Product</h2>

<form method="POST">
    <label>Title:</label>
    <input type="text" name="title" value="<?php echo $product['title']; ?>" required>

    <label>Price (R):</label>
    <input type="number" step="0.01" name="price" value="<?php echo $product['price']; ?>" required>

    <label>Category:</label>
    <input type="text" name="category" value="<?php echo $product['category']; ?>" required>

    <label>Description:</label>
    <textarea name="description" rows="5"><?php echo $product['description']; ?></textarea>

    <label>Status:</label>
    <select name="status">
        <option value="available" <?php if ($product['status'] === 'available') echo 'selected'; ?>>Available</option>
        <option value="sold" <?php if ($product['status'] === 'sold') echo 'selected'; ?>>Sold</option>
        <option value="removed" <?php if ($product['status'] === 'removed') echo 'selected'; ?>>Removed</option>
    </select>

    <button type="submit">Update Product</button>
</form>

</body>
</html>
