<?php
$host = "localhost";
$user = "root"; // or your DB username
$pass = "";     // or your DB password
$db = "c2c_db";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
