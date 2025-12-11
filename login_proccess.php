<?php
include "db_connect.php";

$username = trim($_POST['username']);
$pass     = trim($_POST['pass']);

$query = mysqli_query($conn, "SELECT * FROM users WHERE UserName='$username'");
$data = mysqli_fetch_assoc($query);

if (!$data) {
    echo "<script>alert('Username not found!'); window.location='login.php';</script>";
    exit;
}

if ($pass !== $data['UserPassword']) {
    echo "<script>alert('Incorrect password!'); window.location='login.php';</script>";
    exit;
}

echo "<script>alert('Login Successful!'); window.location='home_crafter.php';</script>";
?>
