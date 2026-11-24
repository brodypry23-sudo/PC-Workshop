<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/lib/connect.lib.php';
require_once __DIR__ . '/lib/images.lib.php';

// The three newest builds, each with its first image as the cover
$latest = [];
$result = $conn->query("SELECT * FROM builds ORDER BY postId DESC LIMIT 3");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $row['images'] = loadImages($conn, (int)$row['postId']);
        $latest[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home | PC-Workshop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <?php include './navbar.php'; ?>

    <main class="container page-main">

        <section class="hero">
            <h1>Show off your PC build</h1>
            <p>Post your parts list, photos and price bracket, and see what other builders have put together.</p>
            <a class="btn btn-light btn-lg" href="posts.php">Browse builds</a>
            <?php if (!isset($_SESSION['userId'])) { ?>
                <a class="btn btn-outline-light btn-lg" href="signup.php">Create an account</a>
            <?php } ?>
        </section>

        <?php if (count($latest) > 0) { ?>
            <div class="section-head">
                <h2>Latest builds</h2>
                <a href="posts.php">See all builds</a>
            </div>

            <div class="row row-cols-1 row-cols-md-3 g-4">
                <?php foreach ($latest as $post) { ?>
                    <div class="col">
                        <article class="card build-card h-100">
                            <?php if (count($post['images']) > 0) { ?>
                                <div class="gallery">
                                    <div class="gallery-slide" style="height:100%;">
                                        <img src="<?php echo htmlspecialchars(imageUrlPath((int)$post['userId'], $post['images'][0]['tmpFileName'])); ?>"
                                             alt="<?php echo htmlspecialchars($post['images'][0]['originalFileName']); ?>">
                                    </div>
                                </div>
                            <?php } else { ?>
                                <div class="gallery gallery-empty">No images yet</div>
                            <?php } ?>
                            <div class="card-body">
                                <h3 class="card-title"><?php echo htmlspecialchars($post['title']); ?></h3>
                                <span class="price-badge"><?php echo htmlspecialchars($post['pricebracket']); ?></span>
                            </div>
                        </article>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>

    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
