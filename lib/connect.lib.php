<?php

$dbHost = "localhost";
$dbUser = "root";
$dbPass = "";
$dbName = "pc-workshop";

$conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

if ($conn->connect_error) {
    die("<div><h4>Connection failed</h4></div>");
}
?>