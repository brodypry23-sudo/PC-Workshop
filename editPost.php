<?php
require "./lib/loadpost.lib.php";
require_once "./lib/images.lib.php";

$images = loadImages($conn, (int)$row['postId']);

$brackets = [
    'Budget'     => 'Budget (Under $800)',
    'Mid-Range'  => 'Mid-Range ($800 - $1500)',
    'High-End'   => 'High-End ($1500 - $3000)',
    'Enthusiast' => 'Enthusiast ($3000+)',
];

if (!isset($brackets[$row['pricebracket']])) {
    $brackets[$row['pricebracket']] = $row['pricebracket'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Post | PC-Workshop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <?php include './navbar.php'; ?>

    <main class="container page-main narrow">

        <div class="page-head">
            <div>
                <h1 class="page-title">Edit post</h1>
                <p class="page-sub">Change your build details, then save.</p>
            </div>
            <a href="posts.php" class="btn btn-outline-brand">Back to posts</a>
        </div>

        <?php showFlash(); ?>

        <!-- 1. The text fields -->
        <form method="POST" action="./lib/updatepost.lib.php" class="panel mb-4">
            <input type="hidden" name="postId" value="<?php echo (int)$row['postId']; ?>" />

            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" required
                       value="<?php echo htmlspecialchars($row['title']); ?>">
            </div>

            <div class="mb-3">
                <label for="bodytext" class="form-label">Content</label>
                <textarea class="form-control" id="bodytext" name="bodytext" rows="5" required><?php echo htmlspecialchars($row['bodytext']); ?></textarea>
            </div>

            <div class="mb-3">
                <label for="pricebracket" class="form-label">Price Bracket</label>
                <select class="form-select" id="pricebracket" name="pricebracket" required>
                    <?php foreach ($brackets as $value => $label) { ?>
                        <option value="<?php echo htmlspecialchars($value); ?>"<?php echo $row['pricebracket'] === $value ? ' selected' : ''; ?>><?php echo htmlspecialchars($label); ?></option>
                    <?php } ?>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Save changes</button>
        </form>

        <!-- 2. The images already on this post (each Delete is its own form: forms can't be nested) -->
        <div class="panel">
            <h2 class="h4">Images (<?php echo count($images); ?> of <?php echo MAX_IMAGES; ?>)</h2>

            <?php if (count($images) === 0) { ?>
                <div class="empty-box mb-4">This post has no images yet.</div>
            <?php } ?>

            <div class="row row-cols-2 row-cols-md-3 g-3 mb-4">
                <?php foreach ($images as $image) { ?>
                    <div class="col">
                        <div class="card build-card h-100">
                            <img class="thumb"
                                 src="<?php echo htmlspecialchars(imageUrlPath((int)$row['userId'], $image['tmpFileName'])); ?>"
                                 alt="<?php echo htmlspecialchars($image['originalFileName']); ?>">
                            <div class="card-body p-2">
                                <form method="POST" action="./lib/deleteimage.lib.php"
                                      data-confirm="Are you sure? This permanently deletes this image. It cannot be undone.">
                                    <input type="hidden" name="imageId" value="<?php echo (int)$image['imageId']; ?>" />
                                    <button type="submit" class="btn btn-outline-danger btn-sm w-100">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>

            <!-- 3. Add more images -->
            <?php if (count($images) < MAX_IMAGES) { ?>
                <form method="POST" action="./lib/addimages.lib.php" enctype="multipart/form-data">
                    <input type="hidden" name="postId" value="<?php echo (int)$row['postId']; ?>" />
                    <div class="mb-3">
                        <label for="images" class="form-label">Add images (JPEG or PNG, max 5 MB each)</label>
                        <input type="file" class="form-control" id="images" name="images[]" accept=".jpg,.jpeg,.png" multiple>
                    </div>
                    <button type="submit" class="btn btn-primary">Add images</button>
                </form>
            <?php } else { ?>
                <p class="mb-0">This post already has the maximum of <?php echo MAX_IMAGES; ?> images.</p>
            <?php } ?>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="JS/confirm.js"></script>
</body>
</html>
