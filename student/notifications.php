<?php
session_start();
include("../config/database.php");

if(!isset($_SESSION['student_email']))
{
    header("Location: student_login.php");
    exit();
}

$email = $_SESSION['student_email'];

$query = "SELECT * FROM students WHERE email='$email'";
$result = mysqli_query($conn,$query);
$student = mysqli_fetch_assoc($result);

$attendance = $student['attendance'];
$marks = $student['marks'];
$fee = $student['fee_status'];

?>

<!DOCTYPE html>
<html>
<head>
<title>Student Notifications</title>
</head>

<body>

<h2>Notifications</h2>

<?php

if($attendance < 75)
{
    echo "<p style='color:red;'>⚠ Warning: Your attendance is below 75%</p>";
}

if($marks < 50)
{
    echo "<p style='color:red;'>⚠ Warning: Your marks are below passing level</p>";
}

if($fee == "Pending")
{
    echo "<p style='color:red;'>⚠ Warning: Your fee payment is pending</p>";
}

if($attendance >=75 && $marks >=50 && $fee != "Pending")
{
    echo "<p style='color:green;'>✔ No notifications. Everything is good!</p>";
}

?>

<br><br>

<a href="student_dashboard.php">Back to Dashboard</a>

</body>
</html>