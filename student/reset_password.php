<?php

include("../config/db_connect.php");

$message="";

if(isset($_POST['reset'])){

$email = $_POST['email'];
$new_password = $_POST['password'];

$sql = "UPDATE students SET password='$new_password' WHERE email='$email'";

$result = mysqli_query($conn,$sql);

if(mysqli_affected_rows($conn) > 0){
$message = "Password Updated Successfully!";
}
else{
$message = "Email Not Found!";
}

}

?>

<!DOCTYPE html>
<html>

<head>

<title>Reset Password</title>

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>

body{
font-family:"Book Antiqua", serif;
background:#020617;
display:flex;
justify-content:center;
align-items:center;
height:100vh;
color:white;
}

.reset-box{

width:350px;
padding:40px;

background:rgba(255,255,255,0.05);
backdrop-filter:blur(12px);

border-radius:18px;

border:1px solid rgba(255,255,255,0.1);

text-align:center;
}

h2{
margin-bottom:25px;
}

input{

width:100%;
padding:12px;

margin:10px 0;

border:none;
border-radius:8px;

background:#1e293b;
color:white;

}

button{

width:100%;
padding:12px;

background:#2563eb;
border:none;
border-radius:8px;

color:white;
font-size:15px;

cursor:pointer;

}

button:hover{
background:#1d4ed8;
}

.message{
margin-top:15px;
color:#60a5fa;
}

.back{
margin-top:15px;
display:block;
color:#94a3b8;
text-decoration:none;
}

</style>

</head>

<body>

<div class="reset-box">

<h2>Reset Password</h2>

<form method="POST">

<input type="email" name="email" placeholder="Enter Email" required>

<input type="password" name="password" placeholder="New Password" required>

<button type="submit" name="reset">Reset Password</button>

</form>

<div class="message">

<?php echo $message; ?>

</div>

<a class="back" href="student_login.php">Back to Login</a>

</div>

</body>
</html>