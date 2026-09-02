<?php 

session_start();

require "./connect.lib.php";

// 1. Get the details from the web page using POST
$title = $_POST['title'] ?? '';
$bodytext = $_POST['bodytext'] ?? '';
$pricebracket = $_POST['pricebracket'] ?? '';
$imageurl = $_POST['imageurl'] ?? '';
$partlists = $_POST['partlists'] ?? '';

$userId = $_SESSION['userId'];

// 2. Create a SQL Statement to insert the post
$sql = "INSERT INTO builds (title, bodytext, pricebracket, partlists, imageurl, userId) VALUES (?, ?, ?, ?, ?, ?)";

$statement = $conn->stmt_init();

if (!$statement->prepare($sql)) {
    header("Location: ../createPost.php?error=Error creating post. Try again later.");
    exit();
}

// 3. Bind the parameters and execute the statement
$statement->bind_param("sssssi", $title, $bodytext, $pricebracket, $partlists, $imageurl, $userId);

if (!$statement->execute()) {
    header("Location: ../createPost.php?error=Error creating post. Try again later.");
    exit();
}

header("Location: ../index.php?success=Post created successfully.");
exit();


?>