<?php

$host = "localhost";
$userName = "root";
$password = "";
$databaseName = "projectdatabase";

// Create a new connection to the MySQL database
$conn = new mysqli($host, $userName, $password, $databaseName);

// Check if the connection was successful
if ($conn->connect_error) {
    die("<div><h4>Connection failed</h4></div>");
}

?>