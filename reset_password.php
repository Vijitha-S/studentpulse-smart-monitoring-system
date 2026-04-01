<?php
include("config/db_connect.php");
include("send_email.php"); // 🔥 Email system

if(isset($_POST['reset'])){

$email = $_POST['email'];
$newpass = $_POST['password'];

$found = false;

// 🔹 STUDENT
$check1 = mysqli_query($conn,"SELECT * FROM students WHERE email='$email'");
if(mysqli_num_rows($check1)>0){
    mysqli_query($conn,"UPDATE students SET password='$newpass' WHERE email='$email'");
    $found = true;
}

// 🔹 STAFF
$check2 = mysqli_query($conn,"SELECT * FROM staff WHERE email='$email'");
if(mysqli_num_rows($check2)>0){
    mysqli_query($conn,"UPDATE staff SET password='$newpass' WHERE email='$email'");
    $found = true;
}

// 🔹 ADMIN (uses username)
$check3 = mysqli_query($conn,"SELECT * FROM admin WHERE username='$email'");
if(mysqli_num_rows($check3)>0){
    mysqli_query($conn,"UPDATE admin SET password='$newpass' WHERE username='$email'");
    $found = true;
}

// ✅ SUCCESS
if($found){

    // 🔥 SEND EMAIL
    $subject = "StudentPulse - Password Reset Successful";
    $message = "
    <h2>Password Updated</h2>
    <p>Your password has been successfully updated.</p>
    <p><b>New Password:</b> $newpass</p>
    <br>
    <p>If this was not you, contact admin immediately.</p>
    ";

    sendMail($email, $subject, $message);

    echo "<script>alert('Password Updated & Email Sent');</script>";

}else{
    echo "<script>alert('Email / Username not found');</script>";
}

}
?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Reset Password | StudentPulse</title>

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:"Book Antiqua", serif;
}

body{
height:100vh;
display:flex;
justify-content:center;
align-items:center;
background:#020617;
color:white;
}

/* Container */

.form-box{
background:rgba(255,255,255,0.05);
padding:30px;
border-radius:15px;
backdrop-filter:blur(15px);
border:1px solid rgba(255,255,255,0.1);
width:320px;
text-align:center;
}

/* Input */

.input-group{
position:relative;
margin-bottom:15px;
}

.input-group i{
position:absolute;
left:12px;
top:50%;
transform:translateY(-50%);
color:#94a3b8;
}

.input-group input{
width:100%;
padding:12px 12px 12px 35px;
border:none;
border-radius:8px;
background:#1e293b;
color:white;
}

/* Button */

button{
width:100%;
padding:12px;
border:none;
border-radius:8px;
background:#22c55e;
color:white;
cursor:pointer;
}

</style>

</head>

<body>

<div class="form-box">

<h2>Reset Password</h2>

<form method="POST">

<div class="input-group">
<i class="fa fa-envelope"></i>
<input type="text" name="email" placeholder="Enter Email / Username" required>
</div>

<div class="input-group">
<i class="fa fa-lock"></i>
<input type="password" name="password" placeholder="New Password" required>
</div>

<button name="reset">Reset Password</button>

</form>

</div>

</body>
</html>