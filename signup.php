<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup | PC-Workshop</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <?php include './navbar.php'; ?>

    <!-- This is the sign-up form -->
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card p-4 shadow-sm">

                    <h2 class="card-title mb-3">Create an Account</h2>
                    
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
                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required minlength="8"  pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number, one uppercase and lowercase letter, and at least 8 or more characters">
                        </div>

                        <div class="mb-3">
                            <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Confirm your password" required>
                        </div>

                        <div class='errormessage'>
                            <?php
                                if (isset($_GET['error'])) {
                                    echo $_GET['error'];
                                }
                            ?>
                        </div>
                        <div class='successmessage'>
                            <?php
                                if (isset($_GET['success'])) {
                                    echo $_GET['success'];
                                }
                            ?>
                        </div>

                        <button type="submit" class="btn btn-primary">Sign Up</button>

                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End of form -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> 
</body>
</html>