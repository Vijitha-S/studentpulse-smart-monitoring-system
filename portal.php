<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Login Portal | StudentPulse</title>

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>

body{
margin:0;
font-family:"Book Antiqua", serif;
background:#020617;
color:white;
display:flex;
justify-content:center;
align-items:center;
height:100vh;
}

.container{
text-align:center;
}

h1{
margin-bottom:60px;
font-size:42px;
}

/* Cards */

.cards{
display:flex;
gap:40px;
}

.card{
width:260px;
padding:40px;
border-radius:20px;

background:rgba(255,255,255,0.05);
backdrop-filter:blur(10px);

border:1px solid rgba(255,255,255,0.1);

transition:0.3s;
}

.card:hover{
transform:translateY(-10px);
box-shadow:0 0 25px rgba(59,130,246,0.5);
}

.card i{
font-size:45px;
margin-bottom:20px;
color:#60a5fa;
}

.card h2{
margin-bottom:20px;
}

.btn{
padding:10px 22px;
border-radius:8px;
text-decoration:none;
color:white;
font-size:14px;
}

.student-btn{
background:#2563eb;
}

.staff-btn{
background:#16a34a;
}

.admin-btn{
background:#111827;
}

</style>

</head>

<body>

<div class="container">

<h1>Login Portal</h1>

<div class="cards">

<!-- Student -->

<div class="card">

<i class="fa-solid fa-user-graduate"></i>

<h2>Student</h2>

<a href="student/student_login.php" class="btn student-btn">
Student Login
</a>

</div>

<!-- Staff -->

<div class="card">

<i class="fa-solid fa-chalkboard-user"></i>

<h2>Staff</h2>

<a href="staff/staff_login.php" class="btn staff-btn">
Staff Login
</a>

</div>

<!-- Admin -->

<div class="card">

<i class="fa-solid fa-user-shield"></i>

<h2>Admin</h2>

<a href="admin/admin_login.php" class="btn admin-btn">
Admin Login
</a>

</div>

</div>

</div>

</body>
</html>