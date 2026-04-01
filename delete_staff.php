<?php
session_start();
include("../config/db_connect.php");

if(!isset($_SESSION['admin'])){
    header("Location: admin_login.php");
    exit();
}

if(isset($_GET['id'])){
    $id = $_GET['id'];

    mysqli_query($conn,"DELETE FROM staff WHERE id='$id'");
}

header("Location: manage_staff.php");
exit();
?>