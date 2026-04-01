<?php
session_start();
include("../config/db_connect.php");

$error = "";

if(isset($_POST['login'])){

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // ✅ Fetch user by email only
    $query = mysqli_query($conn,"SELECT * FROM staff WHERE email='$email'");

    if(mysqli_num_rows($query) > 0){

        $row = mysqli_fetch_assoc($query);

        // ✅ Secure password check
        if($row['password'] == $password){

            $_SESSION['staff_id'] = $row['id'];
            $_SESSION['department_id'] = $row['department_id'];

            header("Location: staff_dashboard.php");
            exit();

        } else {
            $error = "Incorrect Password!";
        }

    } else {
        $error = "Email not found!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Staff Login</title>

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
background:linear-gradient(135deg,#020617,#022c22);
color:white;
}

/* BACK BUTTON */
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
background:#064e3b;
transform:translateY(-2px);
}

/* MAIN UI */

.login-container{
display:flex;
align-items:center;
gap:60px;
padding:40px;
border-radius:20px;
background:rgba(255,255,255,0.05);
backdrop-filter:blur(15px);
border:1px solid rgba(255,255,255,0.1);
box-shadow:0 20px 40px rgba(0,0,0,0.6);
}

.login-img img{
width:260px;
}

.login-card{
width:340px;
text-align:center;
}

.login-card h2{
font-size:30px;
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
color:#86efac;
}

.input-group input{
width:100%;
padding:13px 40px 13px 40px;
border:none;
border-radius:10px;
background:#064e3b;
color:white;
font-size:14px;
outline:none;
}

.input-group input:focus{
box-shadow:0 0 10px #22c55e;
background:#022c22;
}

/* 👁 SHOW/HIDE ICON */
.toggle-password{
position:absolute;
right:14px;
top:50%;
transform:translateY(-50%);
cursor:pointer;
color:#86efac;
}

.toggle-password:hover{
color:#22c55e;
}

.login-btn{
width:100%;
padding:13px;
border:none;
border-radius:10px;
background:linear-gradient(135deg,#16a34a,#22c55e);
color:white;
font-size:16px;
cursor:pointer;
transition:0.3s;
}

.login-btn:hover{
transform:scale(1.05);
box-shadow:0 0 15px #22c55e;
}

.error{
margin-top:10px;
color:#ef4444;
font-size:14px;
}

.small-text{
margin-top:15px;
font-size:13px;
color:#bbf7d0;
}

.small-text a{
color:#4ade80;
text-decoration:none;
}

.small-text a:hover{
text-decoration:underline;
}

</style>

</head>

<body>

<!-- BACK BUTTON -->
<div class="back-btn" onclick="window.location.href='../index.php'">
← Back
</div>

<div class="login-container">

<!-- STAFF ICON -->
<div class="login-img">
<img src="https://cdn-icons-png.flaticon.com/512/921/921347.png">
</div>

<div class="login-card">

<h2>Staff Login</h2>

<form method="POST">

<div class="input-group">
<i class="fa-solid fa-envelope"></i>
<input type="email" name="email" placeholder="Enter Email" required>
</div>

<div class="input-group">
<i class="fa-solid fa-lock"></i>
<input type="password" id="password" name="password" placeholder="Enter Password" required>

<!-- 👁 ICON -->
<i class="fa-solid fa-eye toggle-password" id="togglePassword"></i>
</div>

<button name="login" class="login-btn">Login</button>

</form>

<?php if($error != ""){ ?>
<p class="error"><?php echo $error; ?></p>
<?php } ?>

<div class="small-text">
Forgot password? <a href="#">Reset</a>
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

    this.classList.toggle("fa-eye");
    this.classList.toggle("fa-eye-slash");

});
</script>

</body>
</html>