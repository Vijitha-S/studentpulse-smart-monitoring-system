<?php
session_start();
include("../config/db_connect.php");

if(!isset($_SESSION['admin'])){
    header("Location: admin_login.php");
    exit();
}

// ADD STAFF
if(isset($_POST['add'])){

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $dept = $_POST['department_id'];
    $type = $_POST['type'];
    $year = $_POST['year_id'];

    mysqli_query($conn,"
    INSERT INTO staff(name,email,password,department_id,year_id,type)
    VALUES('$name','$email','$password','$dept','$year','$type')
    ");

    echo "<script>alert('Staff Added Successfully');</script>";
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Add Staff</title>

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

/* CARD */
.card{
width:400px;
background:rgba(255,255,255,0.05);
padding:30px;
border-radius:16px;
backdrop-filter:blur(15px);
border:1px solid rgba(255,255,255,0.1);
box-shadow:0 10px 30px rgba(0,0,0,0.6);
}

h2{
text-align:center;
margin-bottom:20px;
}

/* INPUT */
input,select{
width:100%;
padding:12px;
margin-bottom:15px;
border:none;
border-radius:8px;
background:#1e293b;
color:white;
}

/* BUTTON */
button{
width:100%;
padding:12px;
background:#22c55e;
border:none;
border-radius:8px;
color:white;
cursor:pointer;
}

button:hover{
background:#16a34a;
}
</style>

<script>
// Dynamic Year based on UG/PG
function updateYear(){

    let type = document.getElementById("type").value;
    let year = document.getElementById("year");

    year.innerHTML = "";

    if(type == "UG"){
        year.innerHTML = `
        <option value="1">1st Year</option>
        <option value="2">2nd Year</option>
        <option value="3">3rd Year</option>`;
    } else {
        year.innerHTML = `
        <option value="1">1st Year</option>
        <option value="2">2nd Year</option>`;
    }
}
</script>

</head>

<body>

<div class="card">

<h2>Add Staff</h2>

<form method="POST">

<input type="text" name="name" placeholder="Staff Name" required>
<input type="email" name="email" placeholder="Email" required>
<input type="text" name="password" placeholder="Password" required>

<select name="department_id" required>
<option value="">Select Department</option>
<?php
$d = mysqli_query($conn,"SELECT * FROM departments");
while($row=mysqli_fetch_assoc($d)){
echo "<option value='".$row['id']."'>".$row['name']."</option>";
}
?>
</select>

<select name="type" id="type" onchange="updateYear()" required>
<option value="">Select UG/PG</option>
<option value="UG">UG</option>
<option value="PG">PG</option>
</select>

<select name="year_id" id="year" required>
<option>Select Year</option>
</select>

<button name="add">Add Staff</button>

</form>

</div>

</body>
</html>