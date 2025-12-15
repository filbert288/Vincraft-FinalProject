
<?php
session_start();
include "db_connect.php";

if(!isset($_SESSION['userid']) || $_SESSION['role'] !== 'crafter'){
    exit;
}

$postID = $_POST['postID'];
$reason = trim($_POST['reason']);
$userID = $_SESSION['userid'];

if($reason != ""){
    $stmt = $conn->prepare("
        INSERT INTO reports (ReportID, PostID, UserID, Reason, ReportDate)
        VALUES (?, ?, ?, ?, NOW())
    ");
    $reportID = "R".time();
    $stmt->bind_param("ssss", $reportID, $postID, $userID, $reason);
    $stmt->execute();
}

header("Location: post_detail.php?id=$postID");
exit;
?>
