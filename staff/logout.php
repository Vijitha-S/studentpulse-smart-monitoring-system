<?php
session_start();

// Clear session
$_SESSION = [];
session_destroy();

// Redirect to staff login (same folder)
header("Location: staff_login.php");
exit();
?>