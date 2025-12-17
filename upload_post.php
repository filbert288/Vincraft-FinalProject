<?php
session_start();
include "db_connect.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'crafter') {
    header("Location: login.php");
    exit;
}

$catQuery = mysqli_query($conn, "SELECT * FROM Category");


function generatePostID($conn) {
    $q = mysqli_query($conn, "SELECT MAX(PostID) AS lastID FROM Post");
    $row = mysqli_fetch_assoc($q);

    if (!$row['lastID']) {
        return "P00001";
    }

    $num = intval(substr($row['lastID'], 1)) + 1;

    if ($num > 99999) {
        die("Post limit reached");
    }

    return "P" . str_pad($num, 5, "0", STR_PAD_LEFT);
}

$error = "";

if (isset($_POST['publish'])) {

    $userID     = $_SESSION['user_id'];
    $postID     = generatePostID($conn);
    $title      = trim($_POST['title']);
    $categoryID = $_POST['category'];
    $desc       = trim($_POST['description']);
    $videoLink  = trim($_POST['video_link']);

    $file = $_FILES['thumbnail'];

    
    if (strlen($title) < 5 || strlen($title) > 75) {
        $error = "Title must be between 5 and 75 characters.";
    } elseif (empty($categoryID)) {
        $error = "Please select a category.";
    } elseif (strlen($desc) < 15 || strlen($desc) > 250) {
        $error = "Description must be between 15 and 250 characters.";
    } elseif ($file['error'] === 4) {
        $error = "Thumbnail is required.";
    } else {


        $allowedExt = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $fileExt = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if (!in_array($fileExt, $allowedExt)) {
            $error = "Invalid image type.";
        } elseif ($file['size'] > 150 * 1024 * 1024) {
            $error = "Image exceeds 150MB.";
        } else {

        
            $targetDir = "assets/uploads/$userID/$postID/";
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0777, true);
            }

            $newFileName = "thumb." . $fileExt;
            $targetPath  = $targetDir . $newFileName;
            $dbPath      = "assets/uploads/$userID/$postID/$newFileName";

           
            if (move_uploaded_file($file['tmp_name'], $targetPath)) {

                $stmt = $conn->prepare("
                    INSERT INTO Post 
                    (PostID, UserID, CategoryID, PostTitle, PostDesc, PostVideo, PostImage, PostUpload)
                    VALUES (?, ?, ?, ?, ?, ?, ?, NOW())
                ");

                $stmt->bind_param(
                    "sssssss",
                    $postID,
                    $userID,
                    $categoryID,
                    $title,
                    $desc,
                    $videoLink,
                    $dbPath
                );

                if ($stmt->execute()) {
                    header("Location: post_detail.php?id=$postID");
                    exit;
                } else {
                    $error = "Database Error: " . $stmt->error;
                }

            } else {
                $error = "Failed to upload image.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload-Post</title>
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
        
        <?php if(isset($_SESSION['username'])): ?>
            <a class="welcome"><b>Welcome, <?php echo $_SESSION['username']; ?>!</b></a>
        <?php endif; ?>
    </nav>

    <div id="upload-form-wrapper">
        <h2>Upload Post</h2>
        <p class="subtitle">Share your creation with the community</p>
        
        <form method="POST" enctype="multipart/form-data">
            <label>Title</label>
            <input type="text" name="title">
             
            <label>Category</label>
            <select name="category" required>
                <option value="">-- choose --</option>
                <?php while ($c = mysqli_fetch_assoc($catQuery)) : ?>
                    <option value="<?= $c['CategoryID']; ?>">
                        <?= htmlspecialchars($c['CategoryName']); ?>
                    </option>
                    <?php endwhile; ?>
                </select>

            <label>Description</label>
            <textarea name="description"></textarea>

            <label>Video Link</label>
            <input type="text" name="video_link">

            <label>Thumbnail</label>
            <input type="file" name="thumbnail">
            
            <button type="submit" name="publish">Publish</button>
        </form>
    </div>
    <script src="script.js"></script>
</body>
</html>
