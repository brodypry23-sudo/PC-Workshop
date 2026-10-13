<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Post | PC-Workshop</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <?php include './navbar.php'; ?>

    <h1>EDIT</h1>

    <?php
    require "./lib/loadpost.lib.php";
    ?>

    <form method="POST" action="./lib/updatepost.lib.php">
        <input type="text" id="title" name="title" placeholder="Enter the title of the review" required value="<?php echo $row['title']; ?>" />
        <input type="text" id="bodytext" name="bodytext" placeholder="Enter the review" required value="<?php echo $row['bodytext']; ?>" />
        <input type="text" id="pricebracket" name="pricebracket" placeholder="Enter the price bracket" required value="<?php echo $row['pricebracket']; ?>" />
        <input type="text" id="imageurl" name="imageurl" placeholder="Enter an image url for the review" required value="<?php echo $row['imageurl']; ?>" />
        <input type="hidden" id="postId" name="postId" value="<?php echo $row['postId']; ?>" />

        <button type="submit">Save changes</button>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

