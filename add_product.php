<?php
session_start();
if (!isset($_SESSION['user_id']) || ($_SESSION['role'] !== 'seller' && $_SESSION['role'] !== 'both')) {
    header("Location: login.php");
    exit();
}

include 'includes/db.php';

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price = $_POST['price'];
    $category = mysqli_real_escape_string($conn, $_POST['category']);

    $image = $_FILES['image']['name'];
    $image_tmp = $_FILES['image']['tmp_name'];
    $upload_folder = "uploads/" . basename($image);

    // Moves the uploaded file
    if (move_uploaded_file($image_tmp, $upload_folder)) {
        $seller_id = $_SESSION['user_id'];
        $sql = "INSERT INTO products (seller_id, title, description, price, image, category)
                VALUES ('$seller_id', '$title', '$description', '$price', '$image', '$category')";
        if (mysqli_query($conn, $sql)) {
            $success = "Product uploaded successfully!";
        } else {
            $error = "Database error: " . mysqli_error($conn);
        }
    } else {
        $error = "Image upload failed.";
    }
}
?>

<?php include 'includes/back_button.php'; ?>


<!DOCTYPE html>
<html>
<head>
    <title>Add Product</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <style>
        .form-container {
            max-width: 600px;
            margin: 40px auto;
            padding: 30px;
            background: #f2f2f2;
            border-radius: 10px;
        }
        .form-container h2 {
            margin-bottom: 20px;
        }
        .form-container input,
        .form-container textarea,
        .form-container select {
            width: 100%;
            padding: 12px;
            margin: 10px 0 20px 0;
            border: 1px solid #ccc;
            border-radius: 6px;
        }
        .form-container button {
            background-color: #088178;
            color: #fff;
            border: none;
            padding: 12px 20px;
            border-radius: 6px;
            cursor: pointer;
        }
        .form-container button:hover {
            background-color: #0aa58f;
        }
        .message {
            color: green;
            font-weight: bold;
        }
        .error {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Add New Product</h2>

    <?php if ($success): ?>
        <p class="message"><?php echo $success; ?></p>
    <?php elseif ($error): ?>
        <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>

    <form method="POST" action="" enctype="multipart/form-data">
        <label>Product Title:</label>
        <input type="text" name="title" required>

        <label>Description:</label>
        <textarea name="description" rows="4" required></textarea>

        <label>Price (ZAR):</label>
        <input type="number" name="price" step="0.01" required>

        <label>Category:</label>
        <select name="category" required>
            <option value="Clothing">Clothing</option>
            <option value="Accessories">Accessories</option>
            <option value="Shoes">Shoes</option>
            <option value="Other">Other</option>
        </select>

        <label>Product Image:</label>
        <input type="file" name="image" accept="image/*" required>

        <button type="submit">Upload Product</button>
    </form>
</div>

</body>
</html>
