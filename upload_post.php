
<?php
session_start();
include "db_connect.php";

if(!isset($_SESSION['userid']) || $_SESSION['role'] !== 'crafter'){
    header("Location: login.php");
    exit;
}

$userID = $_SESSION['userid'];

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $postID = "P" . time() . rand(100,999);
    $title  = $_POST['title'];
    $desc   = $_POST['description'];
    $cat    = $_POST['category'];
    $video  = $_POST['video'];

    if(empty($_FILES['thumb']['name'])) exit;

    $allowed = ['jpg','jpeg','png','webp'];
    $ext = strtolower(pathinfo($_FILES['thumb']['name'], PATHINFO_EXTENSION));
    if(!in_array($ext, $allowed)) exit;

    $dir = "uploads/$userID/$postID/";
    if(!is_dir($dir)) mkdir($dir, 0777, true);

    $thumb = $dir . "thumb.$ext";
    move_uploaded_file($_FILES['thumb']['tmp_name'], $thumb);

    $stmt = $conn->prepare("
        INSERT INTO posts
        (PostID, UserID, CategoryID, PostTitle, PostDesc, VideoLink, Thumbnail, CreatedAt)
        VALUES (?,?,?,?,?,?,?,NOW())
    ");
    $stmt->bind_param(
        "sssssss",
        $postID, $userID, $cat, $title, $desc, $video, $thumb
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
    <title>VinCraft - Upload Post</title>
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

    <h2>Upload Post</h2>

    <form id="upload-form" method="POST" enctype="multipart/form-data">
        <input name="title" placeholder="Post Title" required><br>

        <textarea name="description" placeholder="Description" required></textarea><br>

        <select name="category" required>
            <?php
            $cat = $conn->query("SELECT * FROM categories");
            while($c = $cat->fetch_assoc()){
                echo "<option value='{$c['CategoryID']}'>{$c['CategoryName']}</option>";
            }
            ?>
        </select><br>

        <input name="video" placeholder="Video link (optional)"><br>
        <input type="file" name="thumb" accept="image/*" required><br>

        <button type="submit">Upload</button>
    </form>

    <footer>
        © 2025 VinCraft Community. All rights reserved
    </footer>

<script src="script.js"></script>
</body>
</html>
