<?php
$host = "127.0.0.1"; // ✅ match phpMyAdmin
$user = "root";
$password = ""; // since your root shows "No"
$database = "college_system";
$port = 3307; // 🔥 VERY IMPORTANT

$conn = mysqli_connect($host, $user, $password, $database, $port);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>