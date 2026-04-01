<?php
session_start();
include("../config/db_connect.php");

if(!isset($_SESSION['admin'])){
    header("Location: admin_login.php");
    exit();
}

$id = $_GET['id'];

// FETCH STAFF
$staff = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT * FROM staff WHERE id='$id'
"));

// UPDATE
if(isset($_POST['update'])){

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $dept = $_POST['department_id'];
    $year = $_POST['year_id'];
    $type = $_POST['type'];

    mysqli_query($conn,"
    UPDATE staff SET
    name='$name',
    email='$email',
    password='$password',
    department_id='$dept',
    year_id='$year',
    type='$type'
    WHERE id='$id'
    ");

    header("Location: manage_staff.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Staff</title>

<style>
body{
background:#020617;
color:white;
font-family:"Book Antiqua";
display:flex;
justify-content:center;
align-items:center;
height:100vh;
}

.card{
width:400px;
background:rgba(255,255,255,0.05);
padding:30px;
border-radius:16px;
}

input,select{
width:100%;
padding:10px;
margin-bottom:12px;
background:#1e293b;
border:none;
color:white;
}

button{
width:100%;
padding:12px;
background:#3b82f6;
border:none;
color:white;
cursor:pointer;
}
</style>
</head>

<body>

<div class="card">

<h2>Edit Staff</h2>

<form method="POST">

<input type="text" name="name" value="<?=$staff['name']?>" required>
<input type="email" name="email" value="<?=$staff['email']?>" required>
<input type="text" name="password" value="<?=$staff['password']?>" required>

<select name="department_id">
<?php
$d = mysqli_query($conn,"SELECT * FROM departments");
while($row=mysqli_fetch_assoc($d)){
$sel = ($row['id']==$staff['department_id']) ? "selected" : "";
echo "<option value='".$row['id']."' $sel>".$row['name']."</option>";
}
?>
</select>

<select name="type">
<option <?=$staff['type']=='UG'?'selected':''?>>UG</option>
<option <?=$staff['type']=='PG'?'selected':''?>>PG</option>
</select>

<select name="year_id">
<?php
$y = mysqli_query($conn,"SELECT * FROM years");
while($row=mysqli_fetch_assoc($y)){
$sel = ($row['id']==$staff['year_id']) ? "selected" : "";
echo "<option value='".$row['id']."' $sel>".$row['year_name']."</option>";
}
?>
</select>

<button name="update">Update</button>

</form>

</div>

</body>
</html>