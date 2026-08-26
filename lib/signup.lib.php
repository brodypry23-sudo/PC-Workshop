<?php

$dbuserName = $_POST['userName'] ?? '';
$userEmail = $_POST['userEmail'] ?? '';
$password = $_POST['password'] ?? '';
$confirmPassword = $_POST['confirmPassword'] ?? '';

// Check if the password and confirm password match
if ($password !== $confirmPassword) {
    header("Location: ../signup.php?error=Passwords do not match. Please try again");
    exit;
}
require "./connect.lib.php";

// Check whether this email is already registered 
$checkEmail = $conn->stmt_init();
$checkEmail->prepare("SELECT userid FROM users WHERE email = ?"); 
$checkEmail->bind_param("s", $userEmail); 
$checkEmail->execute(); 
$checkEmail->store_result();
if ($checkEmail->num_rows > 0) {
    header("Location: ../signup.php?error=An account with this email address already exists");
    exit;
}

// Prepare and execute the SQL statement to insert the new user into the database
$sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
$statement = $conn->stmt_init();
if (!$statement->prepare($sql)) {
    header("Location: ../signup.php?error=Something went wrong please try again");
    exit();
}
$encryptedPassword = password_hash($password, PASSWORD_DEFAULT);
$statement->bind_param("sss", $dbuserName, $userEmail, $encryptedPassword);
$statement->execute();
header("Location: ../signup.php?success=Account created successfully");
exit;

?>