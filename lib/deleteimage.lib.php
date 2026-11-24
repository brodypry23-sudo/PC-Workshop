<?php
session_start();

require __DIR__ . "/connect.lib.php";
require_once __DIR__ . "/images.lib.php";

// Deletes must be POST (never a plain link)
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SESSION['userId'])) {
    header("Location: ../posts.php");
    exit();
}

$imageId = (int)($_POST['imageId'] ?? 0);
$userId  = (int)$_SESSION['userId'];

if ($imageId <= 0) {
    header("Location: ../posts.php");
    exit();
}

// 1. Read the image row (file name + which post it belongs to + who owns that post)
$stmt = $conn->prepare("SELECT i.postId, i.tmpFileName, b.userId AS ownerId
                        FROM images i
                        JOIN builds b ON b.postId = i.postId
                        WHERE i.imageId = ?");
$stmt->bind_param("i", $imageId);
$stmt->execute();
$image = $stmt->get_result()->fetch_assoc();

if (!$image) {
    flash('error', "That image has already been removed.");
    header("Location: ../posts.php");
    exit();
}

// 2. BR-6: only the owner of the post may delete
if ((int)$image['ownerId'] !== $userId) {
    error_log("deleteimage: user " . $userId . " tried to delete image " . $imageId . " owned by " . $image['ownerId']);
    flash('error', "You can only change your own posts.");
    header("Location: ../posts.php");
    exit();
}

// 3. Delete the row first, then the file (a missing file is only logged)
$del = $conn->prepare("DELETE FROM images WHERE imageId = ?");
$del->bind_param("i", $imageId);

if (!$del->execute()) {
    error_log("deleteimage: DELETE failed for imageId " . $imageId . ": " . $del->error);
    flash('error', "The image could not be deleted. Please try again.");
    header("Location: ../editPost.php?postId=" . (int)$image['postId']);
    exit();
}

deleteImageFile((int)$image['ownerId'], $image['tmpFileName']);

flash('success', "Image deleted.");
header("Location: ../editPost.php?postId=" . (int)$image['postId']);
exit();
