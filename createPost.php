<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Post | PC-Workshop</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <?php include './navbar.php'; ?>

    <form method="POST" action="./lib/createPost.lib.php">

        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" placeholder="Enter post title" required>
        </div>

        <div class="mb-3">
            <label for="bodytext" class="form-label">Content</label>
            <textarea class="form-control" id="bodytext" name="bodytext" placeholder="Enter post content" required></textarea>
        </div>

        <div class="mb-3">
            <label for="pricebracket" class="form-label">Price Bracket</label>
            <select class="form-control" id="pricebracket" name="pricebracket" required>
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
            <label for="imageurl" class="form-label">Image URL</label>
            <input type="text" class="form-control" id="imageurl" name="imageurl" placeholder="Enter image URL" required>
        </div>

        <button type="submit" class="btn btn-primary">Create Post</button>

    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> 
</body>
</html>