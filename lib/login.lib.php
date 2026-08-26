<?php

$userEmail = $_POST['userEmail'] ?? '';
$password = $_POST['password'] ?? '';

require "./connect.lib.php";

$sql = "SELECT * from users Where email = ?";
$statement = $conn->stmt_init();
if (!$statement->prepare($sql)) {
    header("Location: ../login.php?error=login error. try aain later.");
    exit();
}
$statement->bind_param('s', $userEmail);

$statement->execute();

$resultSet = $statement->get_result();
if ($row = $resultSet->fetch_assoc()) {
    echo $row['username'];
}