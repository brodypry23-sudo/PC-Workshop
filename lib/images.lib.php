<?php

const MAX_IMAGES    = 10;             
const MAX_FILE_SIZE = 5 * 1024 * 1024;    
const ALLOWED_TYPES = ['image/jpeg', 'image/png'];  

// ---------- paths ----------

function userUploadDir(int $userId): string {
    return __DIR__ . '/../uploads/userFolders/' . $userId . '/';
}

function imageUrlPath(int $userId, string $tmpFileName): string {
    return 'uploads/userFolders/' . $userId . '/' . rawurlencode($tmpFileName);
}

// ---------- messages shown to the user ----------

function flash(string $type, string $message): void {
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
    $_SESSION['flash'][$type][] = $message;
}

function showFlash(): void {
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
    $classes = ['error' => 'errormessage', 'success' => 'successmessage'];
    foreach ($classes as $type => $class) {
        foreach ($_SESSION['flash'][$type] ?? [] as $message) {
            echo "<div class='" . $class . "'>" . htmlspecialchars($message) . "</div>";
        }
        
        if (!empty($_GET[$type])) {
            echo "<div class='" . $class . "'>" . htmlspecialchars($_GET[$type]) . "</div>";
        }
    }
    unset($_SESSION['flash']);
}

// ---------- database ----------

// Returns the userId that owns the post, or null if the post doesn't exist
function getPostOwner(mysqli $conn, int $postId): ?int {
    $stmt = $conn->prepare("SELECT userId FROM builds WHERE postId = ?");
    $stmt->bind_param("i", $postId);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();
    return $row ? (int)$row['userId'] : null;
}

// All images of a post, in the order they were added
function loadImages(mysqli $conn, int $postId): array {
    $stmt = $conn->prepare("SELECT imageId, tmpFileName, originalFileName FROM images WHERE postId = ? ORDER BY imageId");
    $stmt->bind_param("i", $postId);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

// ---------- files ----------

function deleteImageFile(int $ownerId, string $tmpFileName): void {
    $path = userUploadDir($ownerId) . basename($tmpFileName);   
    if (!file_exists($path)) {
        error_log("deleteImageFile: file missing on disk: " . $path);
        return;
    }
    if (!unlink($path)) {
        error_log("deleteImageFile: could not delete: " . $path);
    }
}


function saveImages(mysqli $conn, int $postId, int $userId, array $files): array {
    $result = ['saved' => [], 'errors' => []];

    /
    if (empty($files['name']) || (count($files['name']) === 1 && $files['error'][0] === UPLOAD_ERR_NO_FILE)) {
        return $result;
    }

    $dir = userUploadDir($userId);
    if (!is_dir($dir) && !mkdir($dir, 0755, true)) {
        error_log("saveImages: could not create folder " . $dir);
        $result['errors'][] = "Your images could not be saved.";
        return $result;
    }

    $count = count(loadImages($conn, $postId));

    foreach ($files['name'] as $i => $original) {
        $tmp = $files['tmp_name'][$i];

        if ($files['error'][$i] === UPLOAD_ERR_INI_SIZE || $files['error'][$i] === UPLOAD_ERR_FORM_SIZE) {
            $result['errors'][] = $original . " was rejected: it is over the 5 MB limit.";
            continue;
        }
        if ($files['error'][$i] !== UPLOAD_ERR_OK) {
            $result['errors'][] = $original . " could not be uploaded.";
            continue;
        }
        if ($count >= MAX_IMAGES) {
            $result['errors'][] = $original . " was rejected: a post can have at most " . MAX_IMAGES . " images.";
            continue;
        }
        if ($files['size'][$i] > MAX_FILE_SIZE) {
            $result['errors'][] = $original . " was rejected: it is over the 5 MB limit.";
            continue;
        }
        if (!in_array(mime_content_type($tmp), ALLOWED_TYPES, true)) {
            $result['errors'][] = $original . " was rejected: only JPEG and PNG images are allowed.";
            continue;
        }

        $stored = basename($tmp);     
        $dest   = $dir . $stored;

        if (file_exists($dest)) {     
            $result['errors'][] = $original . " could not be saved. Please upload it again.";
            continue;
        }

        if (!move_uploaded_file($tmp, $dest)) {
            error_log("saveImages: move_uploaded_file failed for " . $dest . " (postId " . $postId . ")");
            $result['errors'][] = $original . " could not be saved.";
            continue;
        }

        
        $shortName = mb_substr($original, 0, 255);
        $stmt = $conn->prepare("INSERT INTO images (postId, tmpFileName, originalFileName) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $postId, $stored, $shortName);

        if (!$stmt->execute()) {
            unlink($dest);             
            error_log("saveImages: INSERT failed for " . $stored . " (postId " . $postId . "): " . $stmt->error);
            $result['errors'][] = $original . " could not be saved.";
            continue;
        }

        $count++;
        $result['saved'][] = $original;
    }

    return $result;
}

// Calls saveImages() and turns the result into messages for the next page load
function saveImagesWithMessages(mysqli $conn, int $postId, int $userId, array $files): void {
    $result = saveImages($conn, $postId, $userId, $files);

    if (count($result['saved']) > 0) {
        flash('success', "Saved " . count($result['saved']) . " image(s): " . implode(', ', $result['saved']));
    }
    foreach ($result['errors'] as $message) {
        flash('error', $message);
    }
}

// True when the whole POST was thrown away because it was bigger than post_max_size
function postTooLarge(): bool {
    return empty($_POST) && empty($_FILES) && isset($_SERVER['CONTENT_LENGTH']) && (int)$_SERVER['CONTENT_LENGTH'] > 0;
}
