<?php
session_start();

// Destroy session
session_unset();
session_destroy();

// Redirect to login page
header("Location: student_login.php");
exit();
?>