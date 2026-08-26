<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Posts | My Website</title>
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

    <h1>Our Posts</h1>
    <p>This is the posts page.</p>

    <?php
    //creates a counter variable to keep track of the number of posts displayed
    $array = 0;

    //creat some arrays to hold data that will be replaced with data from the database
    $users = array('daniel', 'john', 'jane', 'mary', 'peter','hi');
    $titles = array('coffee', 'tea', 'milk', 'juice', 'water','hi');
    $discriptions = array('description1', 'description2', 'description3', 'description4', 'description5','hi');

    //loop through the arrays and display the data in a card format
    for ($i = 0; $i < count($users); $i++) {
        echo '<div class="card" style="width: 18rem;">';
        echo '<div class="card-body">';
        echo '<h5 class="card-title">' . $titles[$i] . '</h5>';
        echo '<h6 class="card-subtitle mb-2 text-muted">By ' . $users[$i] . '</h6>';
        echo '<p class="card-text">' . $discriptions[$i] . '</p>';
        echo '</div>';
        echo '</div>';

        //increment the counter variable
        $array++;
    }
    ?>












    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> 
</body>
</html>