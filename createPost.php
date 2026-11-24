<?php
require_once './lib/images.lib.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Only logged in users can create posts
if (!isset($_SESSION['userId'])) {
    header('Location: ./login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Post | PC-Workshop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <?php include './navbar.php'; ?>

    <main class="container page-main narrow">

        <div class="page-head">
            <div>
                <h1 class="page-title">Create post</h1>
                <p class="page-sub">Share your build with other builders.</p>
            </div>
            <a href="posts.php" class="btn btn-outline-brand">Back to posts</a>
        </div>

        <?php showFlash(); ?>

        <form method="POST" action="./lib/createPost.lib.php" enctype="multipart/form-data" class="panel">

            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" placeholder="Enter post title" required>
            </div>

            <div class="mb-3">
                <label for="bodytext" class="form-label">Content</label>
                <textarea class="form-control" id="bodytext" name="bodytext" rows="5" placeholder="Enter post content" required></textarea>
            </div>

            <div class="mb-3">
                <label for="pricebracket" class="form-label">Price Bracket</label>
                <select class="form-select" id="pricebracket" name="pricebracket" required>
                    <option value="" disabled selected>Select a price range</option>
                    <option value="Budget">Budget (Under $800)</option>
                    <option value="Mid-Range">Mid-Range ($800 - $1500)</option>
                    <option value="High-End">High-End ($1500 - $3000)</option>
                    <option value="Enthusiast">Enthusiast ($3000+)</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="partlists" class="form-label">PC PartPicker Link</label>
                <input type="url" class="form-control" id="partlists" name="partlists" placeholder="Enter PC PartPicker link (optional)">
            </div>

            <div class="mb-3">
                <label for="images" class="form-label">Images (optional, up to 10, JPEG or PNG, max 5 MB each)</label>
                <input type="file" class="form-control" id="images" name="images[]" accept=".jpg,.jpeg,.png" multiple>
            </div>

            <button type="submit" class="btn btn-primary">Create Post</button>

        </form>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
