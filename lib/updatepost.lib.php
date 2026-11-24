<?php
session_start();

require __DIR__ . "/connect.lib.php";

// If the user is not logged in, go back to posts.php
if (!isset($_SESSION['userId'])) {
    header("Location: ../posts.php");
    exit();
}

if (empty($_POST['postId'])) {
    header("Location: ../posts.php");
    exit();
}

// Get the details from the form (images are handled by addimages / deleteimage)
$postId       = $_POST['postId'];
$title        = $_POST['title'] ?? '';
$bodytext     = $_POST['bodytext'] ?? '';
$pricebracket = $_POST['pricebracket'] ?? '';
$userId       = $_SESSION['userId'];

// Init, Prepare, Bind, Execute
$sql = "UPDATE builds SET title = ?, bodytext = ?, pricebracket = ? WHERE postId = ? AND userId = ?";

$statement = $conn->stmt_init();

if (!$statement->prepare($sql)) {
    header("Location: ../posts.php?error=Error updating post. Try again later.");
    exit();
}

$statement->bind_param("sssii", $title, $bodytext, $pricebracket, $postId, $userId);

if (!$statement->execute()) {
    header("Location: ../posts.php?error=Error updating post. Try again later.");
    exit();
}

header("Location: ../posts.php?success=Post updated successfully.");
exit();
