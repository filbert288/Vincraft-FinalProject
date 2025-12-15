
<?php
session_start();
include "db_connect.php";

if (!isset($_SESSION['userid']) || $_SESSION['role'] !== 'crafter') {
    header("Location: login.php");
    exit;
}

$userID = $_SESSION['userid'];
$postID = $_GET['id'] ?? '';

$stmt = $conn->prepare("SELECT * FROM posts WHERE PostID=? AND UserID=?");
$stmt->bind_param("ss", $postID, $userID);
$stmt->execute();
$post = $stmt->get_result()->fetch_assoc();

if (!$post) exit;

if (isset($_POST['delete'])) {
    $del = $conn->prepare("DELETE FROM posts WHERE PostID=? AND UserID=?");
    $del->bind_param("ss", $postID, $userID);
    $del->execute();

    header("Location: my_post.php");
    exit;
}

if (isset($_POST['save'])) {
    $stmt = $conn->prepare("
        UPDATE posts 
        SET Title=?, Description=?, CategoryID=?, VideoLink=?
        WHERE PostID=? AND UserID=?
    ");
    $stmt->bind_param(
        "ssssss",
        $_POST['title'],
        $_POST['description'],
        $_POST['category'],
        $_POST['video'],
        $postID,
        $userID
    );
    $stmt->execute();

    header("Location: post_detail.php?id=$postID");
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VinCraft - Edit Post</title>
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

    <h2>Edit Post</h2>

    <form method="POST">
        <input name="title" value="<?= $post['Title'] ?>"><br>
        <textarea name="description"><?= $post['Description'] ?></textarea><br>
        <input name="video" value="<?= $post['VideoLink'] ?>"><br>

        <select name="category">
            <?php
            $cat = $conn->query("SELECT * FROM categories");
            while ($c = $cat->fetch_assoc()) {
                $s = ($c['CategoryID']==$post['CategoryID']) ? "selected":"";
                echo "<option value='{$c['CategoryID']}' $s>{$c['CategoryName']}</option>";
            }
            ?>
        </select><br>

        <button type="submit" name="save">Save</button>
        <button type="submit" name="delete">Delete</button>
    </form>

    <footer>
        © 2025 VinCraft Community. All rights reserved
    </footer>

<script src="script.js"></script>
</body>
</html>