<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About | PC-Workshop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <?php include './navbar.php'; ?>

    <main class="container page-main narrow">
        <div class="panel">
            <h1 class="page-title">About PC-Workshop</h1>
            <p class="page-sub mb-3">A place for PC builders to share their builds.</p>
            <p>Create an account, then post your builds, components and upgrades with photos, a price bracket and a PCPartPicker link. Browse the Posts page to see what other people have made.</p>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
