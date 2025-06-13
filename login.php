<?php
session_start();
include 'includes/db.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $query);

    if ($row = mysqli_fetch_assoc($result)) {
        if (password_verify($password, $row['password'])) {
            // Password is correct
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['full_name'] = $row['full_name'];
            $_SESSION['role'] = $row['role'];
            $_SESSION['email'] = $row['email'];


            // Redirect based on role
            if ($row['role'] == 'seller') {
                header("Location: dashboard.php");
            } elseif ($row['role'] == 'buyer') {
                header("Location: shop.php");
            } else {
                header("Location: dashboard.php");
            }
            exit();
        } else {
            $error = "Incorrect password.";
        }
    } else {
        $error = "Email not found.";
    }
}
?>

<?php include 'includes/back_button.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <style>
        .form-container {
            max-width: 500px;
            margin: 50px auto;
            padding: 30px;
            background: #f7f7f7;
            border-radius: 10px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        .form-container h2 {
            margin-bottom: 20px;
        }
        .form-container input {
            width: 100%;
            padding: 12px;
            margin: 10px 0 20px 0;
            border-radius: 6px;
            border: 1px solid #ccc;
        }
        .form-container button {
            background-color: #ba4593;
            color: #fff;
            border: none;
            padding: 12px 20px;
            border-radius: 6px;
            cursor: pointer;
        }
        .form-container button:hover {
            background-color: #81084d;
        }
        .error {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Login</h2>

    <?php if ($error): ?>
        <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <label>Email Address:</label>
        <input type="email" name="email" required>

        <label>Password:</label>
        <input type="password" name="password" required>

        <button type="submit">Login</button>
    </form>
</div>

</body>
</html>
