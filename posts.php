<?php
// Loads $posts (each post has an 'images' array) and starts the session
require './lib/posts.lib.php';

$loggedIn = isset($_SESSION['userId']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Posts | PC-Workshop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <?php include './navbar.php'; ?>

    <main class="container page-main">

        <div class="page-head">
            <div>
                <h1 class="page-title">Builds</h1>
                <p class="page-sub">See what other people have built.</p>
            </div>

            <?php if ($loggedIn) { ?>
                <a class="btn btn-primary" href="createPost.php">Create post</a>
            <?php } else { ?>
                <p class="page-note"><a href="login.php">Log in</a> to share your own build.</p>
            <?php } ?>
        </div>

        <?php showFlash(); ?>

        <?php if (count($posts) === 0) { ?>
            <div class="empty-box">No builds yet.</div>
        <?php } ?>

        <div class="row row-cols-1 row-cols-lg-2 g-4">
            <?php foreach ($posts as $post) { ?>
                <?php
                $isOwner = $loggedIn && (int)$_SESSION['userId'] === (int)$post['userId'];
                $imageCount = count($post['images']);
                ?>

                <div class="col">
                    <article class="card build-card h-100">

                        <?php if ($imageCount > 0) { ?>
                            <div class="gallery" data-gallery>
                                <div class="gallery-track" tabindex="0" role="group"
                                     aria-label="Images for <?php echo htmlspecialchars($post['title']); ?>">
                                    <?php foreach ($post['images'] as $image) { ?>
                                        <div class="gallery-slide">
                                            <img loading="lazy"
                                                 src="<?php echo htmlspecialchars(imageUrlPath((int)$post['userId'], $image['tmpFileName'])); ?>"
                                                 alt="<?php echo htmlspecialchars($image['originalFileName']); ?>">
                                        </div>
                                    <?php } ?>
                                </div>

                                <?php if ($imageCount > 1) { ?>
                                    <button type="button" class="gallery-btn gallery-prev" aria-label="Previous image" hidden>
                                        <svg viewBox="0 0 24 24" width="22" height="22" aria-hidden="true"><path d="M15 5l-7 7 7 7" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                    </button>
                                    <button type="button" class="gallery-btn gallery-next" aria-label="Next image">
                                        <svg viewBox="0 0 24 24" width="22" height="22" aria-hidden="true"><path d="M9 5l7 7-7 7" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                    </button>
                                    <p class="gallery-count" aria-live="polite">1 / <?php echo $imageCount; ?></p>
                                <?php } ?>
                            </div>
                        <?php } else { ?>
                            <div class="gallery gallery-empty">No images yet</div>
                        <?php } ?>

                        <div class="card-body d-flex flex-column">
                            <h2 class="card-title"><?php echo htmlspecialchars($post['title']); ?></h2>
                            <div><span class="price-badge"><?php echo htmlspecialchars($post['pricebracket']); ?></span></div>
                            <p class="card-text"><?php echo nl2br(htmlspecialchars($post['bodytext'])); ?></p>
                            <p class="post-meta">Posted by user #<?php echo (int)$post['userId']; ?></p>

                            <div class="d-flex flex-wrap gap-2 mt-auto">
                                <?php if (preg_match('#^https?://#i', $post['partlists'] ?? '')) { ?>
                                    <a href="<?php echo htmlspecialchars($post['partlists']); ?>" target="_blank" rel="noopener" class="btn btn-primary">View on PCPartPicker</a>
                                <?php } ?>

                                <?php if ($isOwner) { ?>
                                    <form method="POST" action="./editPost.php">
                                        <input type="hidden" name="postId" value="<?php echo (int)$post['postId']; ?>" />
                                        <button type="submit" class="btn btn-outline-brand">Edit</button>
                                    </form>
                                    <form method="POST" action="./lib/deletepost.lib.php"
                                          data-confirm="Are you sure? This permanently deletes the post and all of its images. It cannot be undone.">
                                        <input type="hidden" name="postId" value="<?php echo (int)$post['postId']; ?>" />
                                        <button type="submit" class="btn btn-outline-danger">Delete</button>
                                    </form>
                                <?php } ?>
                            </div>
                        </div>

                    </article>
                </div>
            <?php } ?>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="JS/carousel.js"></script>
    <script src="JS/confirm.js"></script>
</body>
</html>
