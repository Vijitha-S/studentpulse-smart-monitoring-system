<?php

$host = "localhost";
$user = "root";
$password = "";     // XAMPP default password
$database = "college_system";

$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

?>