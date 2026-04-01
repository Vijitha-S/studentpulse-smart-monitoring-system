<?php
include("../config/db_connect.php");

$id = $_GET['id'];

$student = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT * FROM students WHERE id='$id'
"));

if(isset($_POST['update'])){

$name = $_POST['name'];
$email = $_POST['email'];
$department_id = $_POST['department_id'];
$year_id = $_POST['year_id'];

mysqli_query($conn,"
UPDATE students 
SET name='$name',
email='$email',
department_id='$department_id',
year_id='$year_id'
WHERE id='$id'
");

echo "<script>alert('Updated');window.location='admin_dashboard.php';</script>";
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Student</title>

<style>
body{
background:#020617;
color:white;
display:flex;
justify-content:center;
align-items:center;
height:100vh;
font-family:"Book Antiqua";
}

form{
background:#1e293b;
padding:30px;
border-radius:10px;
width:300px;
}

input,select{
width:100%;
padding:10px;
margin:10px 0;
border:none;
border-radius:5px;
}

button{
width:100%;
padding:10px;
background:#3b82f6;
border:none;
color:white;
border-radius:5px;
}
</style>
</head>

<body>

<form method="POST">

<h2>Edit Student</h2>

<input type="text" name="name" value="<?php echo $student['name']; ?>">

<input type="email" name="email" value="<?php echo $student['email']; ?>">

<select name="department_id">
<?php
$d = mysqli_query($conn,"SELECT * FROM departments");
while($row=mysqli_fetch_assoc($d)){
$sel = ($row['id']==$student['department_id']) ? "selected" : "";
echo "<option value='".$row['id']."' $sel>".$row['name']."</option>";
}
?>
</select>

<select name="year_id">
<?php
$y = mysqli_query($conn,"SELECT * FROM years");
while($row=mysqli_fetch_assoc($y)){
$sel = ($row['id']==$student['year_id']) ? "selected" : "";
echo "<option value='".$row['id']."' $sel>".$row['year_name']."</option>";
}
?>
</select>

<button name="update">Update</button>

</form>

</body>
</html>