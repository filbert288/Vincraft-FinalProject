
<?php
session_start();
include "db_connect.php";

if (!isset($_SESSION['userid']) || $_SESSION['role'] !== 'crafter') {
    header("Location: login.php");
    exit;
}

$postID = $_POST['postID'] ?? '';
$userID = $_SESSION['userid'];

if (!$postID) exit;

$check = $conn->prepare("SELECT 1 FROM likes WHERE PostID=? AND UserID=?");
$check->bind_param("ss", $postID, $userID);
$check->execute();

if ($check->get_result()->num_rows > 0) {
    $stmt = $conn->prepare("DELETE FROM likes WHERE PostID=? AND UserID=?");
} else {
    $stmt = $conn->prepare("INSERT INTO likes (PostID, UserID) VALUES (?,?)");
}

$stmt->bind_param("ss", $postID, $userID);
$stmt->execute();

header("Location: post_detail.php?id=$postID");
exit;
?>