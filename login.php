<?php
include 'db_connect.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = $_POST['username'] ?? '';
    $password = $_POST['pass'] ?? '';

    $stmt = $conn->prepare("SELECT * FROM users WHERE UserName = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();

    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if (!$user) {
        echo "<script>alert('Account not found'); window.location='login.php';</script>";
        exit;
    }

    if ($password === $user['UserPassword']) {

        $_SESSION['userid'] = $user['UserID'];
        $_SESSION['username'] = $user['UserName'];
        $_SESSION['role'] = $user['UserRole'];

        if (isset($_POST['remember'])) {
            setcookie("remember_username", $username, time() + 1209600, "/");
        }

        if ($user['UserRole'] === "admin") {
            header("Location: home_admin.php");
            exit;
        } else{
            header("Location: home_crafter.php");
            exit;
        }

    } else {
        echo "<script>alert('Wrong password'); window.location='login.php';</script>";
        exit;
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vincraft-Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav>
        <a class="logo">VinCraft Community</a>
        
        <a href="home_guest.php">Home</a>
        <a href="browse.php">Browse Posts</a>
        <a href="login.php">Login</a>
        <a href="register.php">Register</a>
    </nav>

    <form id="login-form" action="login.php" method="POST">
        <h2>Login</h2>
        <p1>Welcome back to VinCraft Community</p1>
        <div>
            <label for="username">Username</label> <br>
            <input type="text" id="username" name="username">
        </div>

        <div>
            <label for="pass">Password</label><br>
            <input type="password" id="pass" name="pass">
        </div>

        <div class="checkbox-wrap">
            <input type="checkbox" name="remember">Remember Me
        </div>

        <button id="login-button" type="submit">Login</button>

        <div>
            <p>Don't have an account yet? <a href="register.php">Register Here</a> </p>
        </div>

    </form>
    
    <script src="script.js"></script>
    
</body>
</html>