<!-- PHP -->
<?php
include "db_connect.php";

$error = "";
$success = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $username = trim($_POST["username"]);
    $email    = trim($_POST["email"]);
    $password = trim($_POST["pass"]);
    $confpass = trim($_POST["conf-pass"]);

    if($password !== $confpass){
        $error = "Passwords do not match";
    }

    $cekEmail = $conn->prepare("SELECT * FROM users WHERE UserEmail = ?");
    $cekEmail->bind_param("s", $email);
    $cekEmail->execute();
    if($cekEmail->get_result()->num_rows > 0){
        $error = "Email already registered";
    }


    $cekUser = $conn->prepare("SELECT * FROM users WHERE UserName = ?");
    $cekUser->bind_param("s", $username);
    $cekUser->execute();
    if($cekUser->get_result()->num_rows > 0){
        $error = "Username already taken";
    }

    if(!$error){
        $UserID = "U" . str_pad(rand(0,99999), 5, "0", STR_PAD_LEFT);
        $role = (str_ends_with($email, ".vin")) ? "admin" : "crafter";

        $stmt = $conn->prepare("INSERT INTO users (UserID, UserName, UserEmail, UserPassword, UserRole) VALUES (?,?,?,?,?)");
        $stmt->bind_param("sssss", $UserID, $username, $email, $password, $role);

        if($stmt->execute()){
            $success = "Registration successful! Redirecting...";
            header("refresh:2; url=login.php");
        } else {
            $error = "Database error: " . $stmt->error;
        }
    }
}
?>

<!-- HTML -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vincraft-Register</title>
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

    <form id="register-form" action="register.php" method="POST">
        <h2>Register</h2>
        <p1>Join the Vincraft Community</p1>
        
        <!-- error -->
        <?php if($error): ?>
            <div class="error-msg">
                <?= $error ?>
            </div>
        <?php endif; ?>
        
        <?php if($success): ?>
            <div class="success-msg">
                <?= $success ?>
            </div>
        <?php endif; ?>

        <!-- register -->
        <div>
            <label for="reg-username">Username</label> 
            <br>
            <input type="text" id="reg-username"  name="username">
        </div>

        <div>
            <label for="reg-email">Email</label> 
            <br>
            <input type="text" id="reg-email" name="email">
        </div>

        <div>
            <label for="reg-pass">Password</label>
            <br>
            <input type="password" id="reg-pass" name="pass">
        </div>

        <div>
            <label for="reg-conf-pass">Confirm Password</label>
            <br>
            <input type="password" id="reg-conf-pass" name="conf-pass">
        </div>

        <button id="register-button" type="submit">Register</button>

        <div>
            <p>Already have an account? <a href="login.php">Login Here</a> </p>
        </div>

    </form>
    
    <script src="script.js"></script>
</body>
</html>