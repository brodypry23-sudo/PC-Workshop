<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Posts | PC-Workshop</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <?php include './navbar.php'; ?>
    <?php require './lib/posts.lib.php'; ?>



    <Div class="card-container">
        <div class="card mb-4" id="create-post-card">
            <?php

            echo "<h3>This is a list of reviews</h3>";
            
            for ($index = 0; $index < count($posts); $index++) {
                echo "<div class='card mb-4'>";
                    echo "<img src='" . $posts[$index]['imageurl'] . "' class='card-img-top' alt='" . $posts[$index]['title'] . "'>";
                    echo "<div class='card-body'>";
                        echo "<h4 class='card-title'>" . $posts[$index]['title'] . "</h4>";
                        echo "<p class='card-text'>" . $posts[$index]['bodytext'] . "</p>";
                        echo "<p><strong>Price Bracket:</strong> " . $posts[$index]['pricebracket'] . "</p>";
                        echo "<p class='text-muted'>Posted by user #" . $posts[$index]['userId'] . " (Post ID: " . $posts[$index]['postId'] . ")</p>";

                        if (!empty($posts[$index]['partlists'])) {
                            echo "<a href='" . $posts[$index]['partlists'] . "' target='_blank' class='btn btn-primary'>View on PCPartPicker</a>";
                        }
                        ?>

                        <form method="POST" action="./lib/deletepost.lib.php">
                            <input type="hidden" id="postId" name="postId" value="<?php echo $posts[$index]['postId']; ?>" />
                            <button type="submit">Delete</button>
                        </form>
                        <form method="POST" action="./editPost.php">
                            <input type="hidden" id="postId" name="postId" value="<?php echo $posts[$index]['postId']; ?>" />
                            <button type="submit">Edit</button>
                        </form>

                        <?php
                    echo "</div>";
                echo "</div>";
            }

            ?>
        </div>
    </Div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> 
</body>
</html>