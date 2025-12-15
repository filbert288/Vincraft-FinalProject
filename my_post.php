
<?php
session_start();
include "db_connect.php";

if(!isset($_SESSION['userid']) || $_SESSION['role'] !== 'crafter'){
    header("Location: login.php");
    exit;
}

$userID = $_SESSION['userid'];
$stmt = $conn->prepare("SELECT * FROM posts WHERE UserID=?");
$stmt->bind_param("s", $userID);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VinCraft - My Post</title>
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

    <h2>My Posts</h2>

    <?php if($result->num_rows === 0): ?>
        <p>You haven’t uploaded any posts yet.</p>
    <?php endif; ?>

    <?php while($p = $result->fetch_assoc()): ?>
        <div class="post-card">
            <img src="<?= $p['Thumbnail'] ?>" width="150"><br>
            <b><?= $p['PostTitle'] ?></b><br>
            <a href="post_detail.php?id=<?= $p['PostID'] ?>">View</a> |
            <a href="edit_post.php?id=<?= $p['PostID'] ?>">Edit</a>
        </div>
    <?php endwhile; ?>

    <footer>
        © 2025 VinCraft Community. All rights reserved
    </footer>

<script src="script.js"></script>
</body>
</html>
