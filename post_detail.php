
<?php
session_start();
include "db_connect.php";

if(!isset($_SESSION['userid'])){
    header("Location: login.php");
    exit;
}

if($_SESSION['role'] === 'guest'){
    header("Location: browse_guest.php");
    exit;
}

if(!isset($_GET['id'])){
    header("Location: browse_crafter.php");
    exit;
}

$userID = $_SESSION['userid'];
$postID = $_GET['id'];

$stmt = $conn->prepare("
    SELECT p.*, u.UserName, c.CategoryName
    FROM posts p
    JOIN users u ON p.UserID = u.UserID
    JOIN categories c ON p.CategoryID = c.CategoryID
    WHERE p.PostID=?
");
$stmt->bind_param("s", $postID);
$stmt->execute();
$post = $stmt->get_result()->fetch_assoc();

if(!$post) exit;

$isOwner = ($post['UserID'] === $userID);

$like = $conn->prepare("SELECT 1 FROM likes WHERE PostID=? AND UserID=?");
$like->bind_param("ss", $postID, $userID);
$like->execute();
$isLiked = $like->get_result()->num_rows > 0;

$count = $conn->prepare("SELECT COUNT(*) total FROM likes WHERE PostID=?");
$count->bind_param("s", $postID);
$count->execute();
$likeCount = $count->get_result()->fetch_assoc()['total'];

$cmt = $conn->prepare("
    SELECT c.*, u.UserName
    FROM comments c
    JOIN users u ON c.UserID = u.UserID
    WHERE c.PostID=?
    ORDER BY c.CommentDate DESC
");
$cmt->bind_param("s", $postID);
$cmt->execute();
$comments = $cmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VinCraft - Post Detail</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <nav>
        <a href="home_crafter.php">Home</a>
        <a href="browse_crafter.php">Browse</a>
        <a href="upload_post.php">Upload</a>
        <a href="my_post.php">My Post</a>
        <a href="logout.php">Logout</a>
    </nav>

    <h2><?= $post['PostTitle'] ?></h2>
    <p>By <?= $post['UserName'] ?> | <?= $post['CategoryName'] ?></p>

    <img src="<?= $post['Thumbnail'] ?>" width="400">
    <p><?= nl2br($post['PostDesc']) ?></p>

    <form method="POST" action="toggle_like.php">
        <input type="hidden" name="postID" value="<?= $postID ?>">
        <button type="submit">
            <?= $isLiked ? "Unlike" : "Like" ?> (<?= $likeCount ?>)
        </button>
    </form>

    <?php if($isOwner): ?>
        <a href="edit_post.php?id=<?= $postID ?>">Edit</a>
    <?php else: ?>
        <a href="report_post.php?id=<?= $postID ?>">Report</a>
    <?php endif; ?>

    <hr>

    <h3>Comments</h3>
    <?php while($c = $comments->fetch_assoc()): ?>
        <p>
            <b><?= $c['UserName'] ?></b><br>
            <?= nl2br($c['Text']) ?>
        </p>
    <?php endwhile; ?>

    <form method="POST" action="add_comment.php">
        <textarea name="text" required></textarea>
        <input type="hidden" name="postID" value="<?= $postID ?>">
        <button type="submit">Comment</button>
    </form>
<script src="script.js"></script>

</body>
</html>
