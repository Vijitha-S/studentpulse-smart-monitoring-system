<?php
session_start();
include("../config/db_connect.php");

if($_SERVER["REQUEST_METHOD"]=="POST"){

    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM admin WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn,$query);

    if(mysqli_num_rows($result)==1){

        $_SESSION['admin'] = $username;

        header("Location: admin_dashboard.php");
        exit();

    } else {
        echo "<script>alert('Invalid Login');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Admin Login | StudentPulse</title>

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:"Book Antiqua", serif;
}

/* Background */

body{
height:100vh;
display:flex;
justify-content:center;
align-items:center;
background:#020617;
color:white;
overflow:hidden;
}

/* 🔥 BACK BUTTON */
.back-btn{
position:absolute;
top:30px;
left:30px;
padding:10px 18px;
background:rgba(255,255,255,0.05);
border:1px solid rgba(255,255,255,0.1);
border-radius:10px;
backdrop-filter:blur(10px);
color:white;
cursor:pointer;
transition:0.3s;
}

.back-btn:hover{
background:#ef4444;
transform:translateY(-2px);
}

/* Glow */

.bg-glow{
position:absolute;
width:700px;
height:700px;
background:radial-gradient(circle,#ef4444,transparent 70%);
filter:blur(150px);
opacity:0.35;
animation:float 8s ease-in-out infinite;
}

@keyframes float{
0%{transform:translateY(0)}
50%{transform:translateY(-40px)}
100%{transform:translateY(0)}
}

/* Container */

.login-container{
display:flex;
align-items:center;
gap:60px;
padding:40px;
border-radius:18px;
background:rgba(255,255,255,0.05);
backdrop-filter:blur(15px);
border:1px solid rgba(255,255,255,0.1);
box-shadow:0 20px 40px rgba(0,0,0,0.4);
}

/* Image */

.login-illustration img{
width:260px;
}

/* Form */

.login-card{
width:340px;
text-align:center;
}

.login-card h2{
font-size:32px;
margin-bottom:25px;
}

/* Input */

.input-group{
position:relative;
margin-bottom:18px;
}

.input-group i{
position:absolute;
left:14px;
top:50%;
transform:translateY(-50%);
color:#94a3b8;
}

/* 👁 Toggle icon */
.toggle-eye{
position:absolute;
right:14px;
top:50%;
transform:translateY(-50%);
cursor:pointer;
color:#94a3b8;
}

.input-group input{
width:100%;
padding:13px 40px 13px 40px;
border:none;
border-radius:10px;
background:#1e293b;
color:white;
outline:none;
transition:0.3s;
}

.input-group input:focus{
box-shadow:0 0 10px #ef4444;
background:#111827;
}

/* Button */

.login-btn{
width:100%;
padding:13px;
border:none;
border-radius:10px;
background:linear-gradient(135deg,#ef4444,#dc2626);
color:white;
font-size:16px;
cursor:pointer;
transition:0.3s;
}

.login-btn:hover{
transform:translateY(-2px);
box-shadow:0 10px 25px rgba(239,68,68,0.5);
}

/* Responsive */

@media(max-width:900px){
.login-container{
flex-direction:column;
text-align:center;
}
.login-illustration img{
width:200px;
}
}

</style>

</head>

<body>

<!-- 🔥 BACK BUTTON -->
<div class="back-btn" onclick="window.location.href='../index.php'">
← Back
</div>

<div class="bg-glow"></div>

<div class="login-container">

<!-- Image -->
<div class="login-illustration">
<img src="https://cdn-icons-png.flaticon.com/512/2922/2922510.png">
</div>

<!-- Form -->
<div class="login-card">

<h2>Admin Login</h2>

<form method="POST">

<div class="input-group">
<i class="fa fa-user"></i>
<input type="text" name="username" placeholder="Enter Username" required>
</div>

<div class="input-group">
<i class="fa fa-lock"></i>
<input type="password" id="password" name="password" placeholder="Enter Password" required>
<i class="fa fa-eye toggle-eye" onclick="togglePassword()"></i>
</div>

<button class="login-btn">Login</button>

</form>

</div>

</div>

<!-- 👁 TOGGLE SCRIPT -->
<script>
function togglePassword(){
    const pass = document.getElementById("password");
    const icon = document.querySelector(".toggle-eye");

    if(pass.type === "password"){
        pass.type = "text";
        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash");
    } else {
        pass.type = "password";
        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");
    }
}
</script>

</body>
</html>