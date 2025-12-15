
<?php
session_start();
include "db_connect.php";

if (!isset($_SESSION['userid']) || $_SESSION['role'] !== 'crafter') {
    header("Location: login.php");
    exit;
}

$postID = $_POST['postID'] ?? '';
$text   = trim($_POST['text'] ?? '');
$userID = $_SESSION['userid'];

if ($postID && $text !== "") {
    $stmt = $conn->prepare("
        INSERT INTO comments (PostID, UserID, Text, CommentDate)
        VALUES (?, ?, ?, NOW())
    ");
    $stmt->bind_param("sss", $postID, $userID, $text);
    $stmt->execute();
}

header("Location: post_detail.php?id=$postID");
exit;
?>