<?php

// Make the session variables available to the code
session_start();

// If the user is not logged in, then go back to posts.php
if (!isset($_SESSION['userId'])) {
    header("location: ./posts.php");
    exit();
}

// The postId comes from the Edit button (POST) or from a redirect after adding/deleting an image (GET)
$postId = (int)($_POST['postId'] ?? $_GET['postId'] ?? 0);

if ($postId <= 0) {
    header("location: ./posts.php");
    exit();
}

$userId = $_SESSION['userId'];

// Init, Prepare, Bind, Execute
require __DIR__ . "/connect.lib.php";
$sql = "SELECT * FROM builds WHERE postId = ? AND userId = ?";
$statement = $conn->stmt_init();
if (!$statement->prepare($sql)) {
    header("Location: ./posts.php"); //Redirect
    exit();
}
$statement->bind_param("ii", $postId, $userId);
$statement->execute();

$result = $statement->get_result();
$row = $result->fetch_assoc();

if (!$row) {
    header("location: ./posts.php");
    exit();
}
