<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up | My Website</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <!--<header and navigation>-->
    <span id="navbar-placeholder"></span>
    <script>
        fetch('navbar.php')    
        .then(response => response.text())    
        .then(html => { document.getElementById('navbar-placeholder').innerHTML = html; });
    </script>
    <!--<end header and navigation>-->

    <!-- This is the login form -->
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card p-4 shadow-sm">

                    <h2 class="card-title mb-3">Login</h2>
                    
                    <form method="POST" action="./lib/login.lib.php">

                        <div class="mb-3">
                            <label for="userEmail" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="userEmail" name="userEmail" placeholder="Enter your email" required>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Sign In</button>

                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End of form -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> 
</body>
</html>