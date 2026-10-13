<?php

// Make the session variables available to the code
session_start();

// If the user is not logged in, then go back to posts.php
if (!isset($_SESSION['userId'])) {
    header("location: ./posts.php");
    exit();
}
if (empty($_POST['postId'])) {
    header("location: ./posts.php");
    exit();
}

// Get the postId that was in the hidden field.
$postId = $_POST['postId'];
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
