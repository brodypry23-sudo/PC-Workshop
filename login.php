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
    <title>Login | PC-Workshop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <?php include './navbar.php'; ?>

    <!-- This is the login form -->
    <main class="container page-main">
        <div class="auth-wrap">
            <div class="panel">

                <h1 class="h3">Login</h1>

                <?php if (!empty($_GET['error'])) { ?>
                    <div class="errormessage" role="alert"><?php echo htmlspecialchars($_GET['error']); ?></div>
                <?php } ?>

                <form method="POST" action="./lib/login.lib.php">

                    <div class="mb-3">
                        <label for="userEmail" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="userEmail" name="userEmail" placeholder="Enter your email" required>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Sign In</button>

                </form>

                <?php if (isset($_SESSION['userId'])) { ?>
                    <div class="mt-3">
                        <a href="./lib/logout.lib.php">Log out</a>
                    </div>
                <?php } else { ?>
                    <p class="page-note mt-3">No account yet? <a href="signup.php">Sign up</a></p>
                <?php } ?>

            </div>
        </div>
    </main>
    <!-- End of form -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
