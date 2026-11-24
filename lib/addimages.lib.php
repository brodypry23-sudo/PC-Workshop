<?php
session_start();

require __DIR__ . "/connect.lib.php";
require_once __DIR__ . "/images.lib.php";

if (!isset($_SESSION['userId'])) {
    header("Location: ../posts.php");
    exit();
}

if (postTooLarge()) {
    flash('error', "Those images are too large to upload in one go.");
    header("Location: ../posts.php");
    exit();
}

$postId = (int)($_POST['postId'] ?? 0);
$userId = (int)$_SESSION['userId'];

if ($postId <= 0) {
    header("Location: ../posts.php");
    exit();
}

// BR-6: the post must exist and belong to the logged in user
$ownerId = getPostOwner($conn, $postId);

if ($ownerId === null) {
    flash('error', "That post no longer exists. Nothing was saved.");
    header("Location: ../posts.php");
    exit();
}

if ($ownerId !== $userId) {
    error_log("addimages: user " . $userId . " tried to add images to post " . $postId . " owned by " . $ownerId);
    flash('error', "You can only change your own posts.");
    header("Location: ../posts.php");
    exit();
}

saveImagesWithMessages($conn, $postId, $userId, $_FILES['images'] ?? []);

header("Location: ../editPost.php?postId=" . $postId);
exit();
