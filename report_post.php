
<?php
session_start();
include "db_connect.php";

if ($_SESSION['role'] !== 'crafter') exit;

$postID = $_GET['id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VinCraft - Report Post</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav>
        <a class="logo">VinCraft Community</a>
        <a href="home_crafter.php">Home</a>
        <a href="browse_crafter.php">Browse Posts</a>
        <a href="upload_post.php">Upload Post</a>
        <a href="my_post.php">My Post</a>
        <a href="logout.php">Logout</a>
        <a class="welcome"><b>Welcome, <?= $_SESSION['username'] ?>!</b></a>
    </nav>

    <h2>Report Post</h2>

    <form method="POST" action="submit_report.php">
        <textarea name="reason" required></textarea>
        <input type="hidden" name="postID" value="<?= $postID ?>">
        <button>Submit Report</button>
    </form>

    <footer>
        © 2025 VinCraft Community. All rights reserved
    </footer>

<script src="script.js"></script>
</body>
</html>
