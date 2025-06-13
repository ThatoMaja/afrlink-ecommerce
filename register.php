<?php
include 'includes/db.php';


$success = "";
$error = "";

// When the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // hash password
    $role = $_POST['role'];

    // Checks if user exists
    $check = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
    if (mysqli_num_rows($check) > 0) {
        $error = "Email already registered.";
    } else {
        // Inserts new user
        $sql = "INSERT INTO users (full_name, email, phone, password, role) 
                VALUES ('$name', '$email', '$phone', '$password', '$role')";

        if (mysqli_query($conn, $sql)) {
            $success = "Registration successful! You can now log in.";
            header("Location: login.php");
            exit();

        } else {
            $error = "Something went wrong: " . mysqli_error($conn);
        }
    }
}
?>

<?php include 'includes/back_button.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
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
        .form-container input, select {
            width: 100%;
            padding: 12px;
            margin: 10px 0 20px 0;
            border-radius: 6px;
            border: 1px solid #ccc;
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
    <h2>Register</h2>

    <?php if ($success): ?>
        <p class="message"><?php echo $success; ?></p>
    <?php elseif ($error): ?>
        <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <label>Full Name:</label>
        <input type="text" name="full_name" required>

        <label>Email Address:</label>
        <input type="email" name="email" required>

        <label>Phone Number:</label>
        <input type="text" name="phone" required>

        <label>Password:</label>
        <input type="password" name="password" required>

        <label>Register As:</label>
        <select name="role" required>
            <option value="buyer">Buyer</option>
            <option value="seller">Seller</option>
            <option value="both">Buyer & Seller</option>
        </select>

        <button type="submit">Register</button>
    </form>
</div>

</body>
</html>
