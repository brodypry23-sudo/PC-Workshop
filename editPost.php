<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Post | My Website</title>
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

    <h1>Edit Post</h1>
    <p>This is the edit post page.</p>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> 
</body>
</html>