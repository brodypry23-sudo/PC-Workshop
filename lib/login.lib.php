<?php

session_start();

require "./connect.lib.php";

// 1. Get the details from the web page using POST
$userName = $_POST['userEmail'] ?? '';
$userPassword = $_POST['password'] ?? '';

// 2. Create a SQL Statement to get the user
$sql = "SELECT * FROM users WHERE email = ?";
$statement = $conn->stmt_init();

if (!$statement->prepare($sql)) {
    header("Location: ../login.php?error=Login error. Try again later.");
    exit();
}

$statement->bind_param('s', $userName);

// 3. Execute that SQL
$statement->execute();

// 4. Check to see if there is a record
$resultSet = $statement->get_result();

if ($row = $resultSet->fetch_assoc()) {

    // 5. Check the password is correct
    $passwordMatch = password_verify($userPassword, $row['password']);

    if ($passwordMatch === true) {

        // 6. Set session variables with the user's details
        $_SESSION['userId'] = $row['userId'];
        $_SESSION['userName'] = $row['username'];

        // 7. Redirect to the index page
        header("Location: ../index.php");
        exit();

    } else {

        header("Location: ../login.php?error=Invalid email or password.&username=" . $userName);
        exit();
    }

} else {

    // No user was found with that email
    header("Location: ../login.php?error=Invalid email or password.&username=" . $userName);
    exit();
}