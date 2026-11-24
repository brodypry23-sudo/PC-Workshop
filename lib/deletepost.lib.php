<?php
// Make the session variables available to the code
session_start();

// If the user is not logged in, then go back to posts.php
if (!isset($_SESSION['userId'])) {
    header("location: ../posts.php");
    exit();
}

if (empty($_POST['postId'])) {
    header("location: ../posts.php");
    exit();
}

require __DIR__ . "/connect.lib.php";
require_once __DIR__ . "/images.lib.php";

// Make database errors throw exceptions so the transaction can be rolled back
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$postId = (int)$_POST['postId'];
$userId = (int)$_SESSION['userId'];

// 1. BR-6: the post must belong to the logged in user
$ownerId = getPostOwner($conn, $postId);

if ($ownerId === null) {
    header("location: ../posts.php");
    exit();
}

if ($ownerId !== $userId) {
    error_log("deletepost: user " . $userId . " tried to delete post " . $postId . " owned by " . $ownerId);
    flash('error', "You can only change your own posts.");
    header("location: ../posts.php");
    exit();
}

// 2. Remember the image file names for after the database delete
$images = loadImages($conn, $postId);

// 3. Delete the image rows and the post in ONE transaction
try {
    $conn->begin_transaction();

    $delImages = $conn->prepare("DELETE FROM images WHERE postId = ?");
    $delImages->bind_param("i", $postId);
    $delImages->execute();

    $delPost = $conn->prepare("DELETE FROM builds WHERE postId = ? AND userId = ?");
    $delPost->bind_param("ii", $postId, $userId);
    $delPost->execute();

    $conn->commit();
} catch (Throwable $e) {
    $conn->rollback();
    error_log("deletepost: transaction rolled back for postId " . $postId . ": " . $e->getMessage());
    flash('error', "The post could not be deleted. Please try again.");
    header("location: ../posts.php");
    exit();
}

// 4. Only after the commit: remove the files from disk (problems are only logged)
foreach ($images as $image) {
    deleteImageFile($userId, $image['tmpFileName']);
}

flash('success', "Post and its images deleted.");
header("location: ../posts.php");
exit();
