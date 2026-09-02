<?php
session_start();

// Connect to the database
require "./lib/connect.lib.php";

// Create my SQL statement
$sql = "SELECT * FROM builds";

// Init
$statement = $conn->stmt_init();

// Prepare
if (!$statement->prepare($sql)) {
    header("Location: ../posts.php?error=Error loading posts. Try again later.");
    exit();
}

// Execute
if (!$statement->execute()) {
    header("Location: ../posts.php?error=Error loading posts. Try again later.");
    exit();
}

$resultSet = $statement->get_result();

// Create an array that will have all of the posts in it.
$posts = [];

// Fill that array with the posts from the database
while ($row = $resultSet->fetch_assoc()) {
    $posts[] = $row;
}

?>