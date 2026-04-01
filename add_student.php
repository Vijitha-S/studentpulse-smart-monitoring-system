<?php
session_start();
include("../config/db_connect.php");

if(!isset($_SESSION['admin'])){
    header("Location: admin_login.php");
    exit();
}

// ADD STUDENT
if(isset($_POST['add'])){

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $department_id = $_POST['department_id'];
    $year_id = $_POST['year_id'];

    if($name && $email && $password && $department_id && $year_id){

        $hashed = password_hash($password, PASSWORD_DEFAULT);

        mysqli_query($conn,"
        INSERT INTO students(name,email,password,department_id,year_id,attendance,fees_paid,fees_total)
        VALUES('$name','$email','$hashed','$department_id','$year_id',0,0,0)
        ");

        echo "<script>alert('Student Added Successfully');window.location='admin_dashboard.php';</script>";
    } else {
        echo "<script>alert('All fields required');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Add Student</title>

<style>
body{
margin:0;
background:#020617;
color:white;
font-family:"Book Antiqua";
}

/* SIDEBAR */
.sidebar{
width:230px;
height:100vh;
background:#020617;
position:fixed;
padding:20px;
border-right:1px solid #1e293b;
}

.sidebar h2{
margin-bottom:20px;
}

.sidebar a{
display:block;
color:white;
text-decoration:none;
padding:10px;
margin:5px 0;
border-radius:8px;
}

.sidebar a:hover{
background:#1e293b;
}

/* MAIN */
.main{
margin-left:250px;
padding:40px;
}

/* CARD */
.card{
background:rgba(255,255,255,0.05);
backdrop-filter:blur(15px);
padding:30px;
border-radius:16px;
max-width:450px;
margin:auto;
box-shadow:0 10px 30px rgba(0,0,0,0.5);
}

/* FORM */
input, select{
width:100%;
padding:12px;
margin:10px 0;
border:none;
border-radius:8px;
background:#111827;
color:white;
}

button{
width:100%;
padding:12px;
background:#16a34a;
border:none;
color:white;
border-radius:10px;
cursor:pointer;
font-size:16px;
}

button:hover{
background:#15803d;
}
</style>
</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">
<h2>Admin Panel</h2>

<a href="admin_dashboard.php">🏠 Dashboard</a>
<a href="add_department.php">🏢 Department</a>
<a href="add_year.php">📅 Year</a>
<a href="add_subject.php">📘 Subject</a>
<a href="add_student.php">➕ Student</a>
<a href="../logout.php">🚪 Logout</a>
</div>

<!-- MAIN -->
<div class="main">

<h1>Add Student</h1>

<div class="card">

<form method="POST">

<input type="text" name="name" placeholder="Student Name" required>

<input type="email" name="email" placeholder="Email" required>

<input type="password" name="password" placeholder="Password" required>

<!-- DEPARTMENT -->
<select name="department_id" required>
<option value="">Select Department</option>

<?php
$dept = mysqli_query($conn,"SELECT * FROM departments");
while($d=mysqli_fetch_assoc($dept)){
echo "<option value='".$d['id']."'>".$d['name']."</option>";
}
?>

</select>

<!-- YEAR -->
<select name="year_id" required>
<option value="">Select Year</option>

<?php
$year = mysqli_query($conn,"SELECT * FROM years");
while($y=mysqli_fetch_assoc($year)){
echo "<option value='".$y['id']."'>".$y['year_name']."</option>";
}
?>

</select>

<button name="add">Add Student</button>

</form>

</div>

</div>

</body>
</html>