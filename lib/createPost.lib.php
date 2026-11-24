<?php

session_start();

require __DIR__ . "/connect.lib.php";
require_once __DIR__ . "/images.lib.php";

// Must be logged in
if (!isset($_SESSION['userId'])) {
    header("Location: ../login.php");
    exit();
}

// The whole form was bigger than php.ini allows (post_max_size)
if (postTooLarge()) {
    header("Location: ../createPost.php?error=Those images are too large to upload in one go.");
    exit();
}

// 1. Get the details from the web page using POST
$title = $_POST['title'] ?? '';
$bodytext = $_POST['bodytext'] ?? '';
$pricebracket = $_POST['pricebracket'] ?? '';
$partlists = $_POST['partlists'] ?? '';

$userId = (int)$_SESSION['userId'];

// 2. Create a SQL Statement to insert the post (images now live in their own table)
$sql = "INSERT INTO builds (title, bodytext, pricebracket, partlists, userId) VALUES (?, ?, ?, ?, ?)";

$statement = $conn->stmt_init();

if (!$statement->prepare($sql)) {
    header("Location: ../createPost.php?error=Error creating post. Try again later.");
    exit();
}

// 3. Bind the parameters and execute the statement
$statement->bind_param("ssssi", $title, $bodytext, $pricebracket, $partlists, $userId);

if (!$statement->execute()) {
    header("Location: ../createPost.php?error=Error creating post. Try again later.");
    exit();
}

// 4. Read back the new postId, then save the images that were chosen (if any)
$postId = $conn->insert_id;
saveImagesWithMessages($conn, $postId, $userId, $_FILES['images'] ?? []);

flash('success', "Post created successfully.");
header("Location: ../posts.php");
exit();
