<?php
session_start();
include("../config/db_connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST['email'];
    $password = $_POST['password'];

    // ✅ Secure query
    $query = "SELECT * FROM students WHERE email='$email'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {

        $row = mysqli_fetch_assoc($result);

        // ✅ Password verify (IMPORTANT)
        if(password_verify($password, $row['password'])){

            $_SESSION['student_id'] = $row['id'];
            header("Location: student_dashboard.php");
            exit();

        } else {
            echo "<script>alert('Invalid Password');</script>";
        }

    } else {
        echo "<script>alert('User not found');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Student Login | StudentPulse</title>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

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
background:#1e293b;
transform:translateY(-2px);
}

.bg-glow{
position:absolute;
width:700px;
height:700px;
background:radial-gradient(circle,#3b82f6,transparent 70%);
filter:blur(150px);
opacity:0.35;
animation:float 8s ease-in-out infinite;
}

@keyframes float{
0%{transform:translateY(0px)}
50%{transform:translateY(-40px)}
100%{transform:translateY(0px)}
}

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

.login-illustration img{
width:260px;
}

.login-card{
width:340px;
text-align:center;
}

.login-card h2{
font-size:32px;
margin-bottom:25px;
}

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

.input-group input{
width:100%;
padding:13px 40px 13px 40px;
border:none;
border-radius:10px;
background:#1e293b;
color:white;
font-size:14px;
outline:none;
transition:0.3s;
}

.input-group input:focus{
box-shadow:0 0 10px #3b82f6;
background:#111827;
}

/* 👁 TOGGLE ICON */
.toggle-password{
position:absolute;
right:14px;
top:50%;
transform:translateY(-50%);
cursor:pointer;
color:#94a3b8;
}

.toggle-password:hover{
color:#3b82f6;
}

.login-btn{
width:100%;
padding:13px;
border:none;
border-radius:10px;
background:linear-gradient(135deg,#2563eb,#3b82f6);
color:white;
font-size:16px;
cursor:pointer;
transition:0.3s;
}

.login-btn:hover{
transform:translateY(-2px);
box-shadow:0 10px 25px rgba(59,130,246,0.5);
}

.small-text{
margin-top:15px;
font-size:14px;
color:#94a3b8;
}

.small-text a{
color:#60a5fa;
text-decoration:none;
}

.small-text a:hover{
text-decoration:underline;
}

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

<!-- BACK BUTTON -->
<div class="back-btn" onclick="window.location.href='../index.php'">
← Back
</div>

<div class="bg-glow"></div>

<div class="login-container">

<div class="login-illustration">
<img src="https://cdn-icons-png.flaticon.com/512/3135/3135755.png">
</div>

<div class="login-card">

<h2>Student Login</h2>

<form method="POST">

<div class="input-group">
<i class="fa-solid fa-envelope"></i>
<input type="email" name="email" placeholder="Enter Email" required>
</div>

<div class="input-group">
<i class="fa-solid fa-lock"></i>
<input type="password" id="password" name="password" placeholder="Enter Password" required>

<!-- 👁 SHOW/HIDE -->
<i class="fa-solid fa-eye toggle-password" id="togglePassword"></i>
</div>

<button class="login-btn">Login</button>

</form>

<div class="small-text">
Forgot password? <a href="reset_password.php">Reset</a>
</div>

</div>

</div>

<script>
// 👁 Toggle Password
const togglePassword = document.getElementById("togglePassword");
const password = document.getElementById("password");

togglePassword.addEventListener("click", function () {

    const type = password.getAttribute("type") === "password" ? "text" : "password";
    password.setAttribute("type", type);

    // Change icon
    this.classList.toggle("fa-eye");
    this.classList.toggle("fa-eye-slash");

});
</script>

</body>
</html>