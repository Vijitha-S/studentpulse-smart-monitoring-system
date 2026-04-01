<?php
include("../config/db_connect.php");

$id=$_GET['id'];

mysqli_query($conn,"DELETE FROM students WHERE id='$id'");

header("Location: admin_dashboard.php");
?>