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
    <title>Signup | PC-Workshop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <?php include './navbar.php'; ?>

    <!-- This is the sign-up form -->
    <main class="container page-main">
        <div class="auth-wrap">
            <div class="panel">

                <h1 class="h3">Create an Account</h1>

                <?php if (!empty($_GET['error'])) { ?>
                    <div class="errormessage" role="alert"><?php echo htmlspecialchars($_GET['error']); ?></div>
                <?php } ?>
                <?php if (!empty($_GET['success'])) { ?>
                    <div class="successmessage" role="status"><?php echo htmlspecialchars($_GET['success']); ?></div>
                <?php } ?>

                <form method="POST" action="./lib/signup.lib.php">

                    <div class="mb-3">
                        <label for="userName" class="form-label">Username</label>
                        <input type="text" class="form-control" id="userName" name="userName" placeholder="Enter your username" required minlength="3" maxlength="20">
                    </div>

                    <div class="mb-3">
                        <label for="userEmail" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="userEmail" name="userEmail" placeholder="Enter your email" required>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required minlength="8" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number, one uppercase and lowercase letter, and at least 8 or more characters">
                    </div>

                    <div class="mb-3">
                        <label for="confirmPassword" class="form-label">Confirm password</label>
                        <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Confirm your password" required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Sign Up</button>

                </form>

                <p class="page-note mt-3">Already have an account? <a href="login.php">Log in</a></p>

            </div>
        </div>
    </main>
    <!-- End of form -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
