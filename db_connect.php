<?php
    $db = "vincraft_db";
    $username = "root";
    $password = "";
    $host = "localhost";

    $conn = new mysqli($host, $username, $password, $db);

    if ($conn->connect_error) {
        die("Connection Error: " . $conn->connect_error);
    }
?>