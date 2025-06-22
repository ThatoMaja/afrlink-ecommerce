<?php
$host = "sql309.infinityfree.com";
$user = "if0_39253487"; 
$pass = "aBb9w2bzNizhdB";     
$db = "if0_39253487_afrilink_c2c_ecommerce";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
