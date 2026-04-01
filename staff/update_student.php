<?php
include("../config/db_connect.php");

$id = $_GET['id'];

$result = mysqli_query($conn, "SELECT * FROM students WHERE id='$id'");
$row = mysqli_fetch_assoc($result);

// UPDATE
if(isset($_POST['update'])){

    $cad = $_POST['cad'];
    $hadoop = $_POST['hadoop'];
    $oe = $_POST['oe'];
    $track = $_POST['track'];
    $attendance = $_POST['attendance'];
    $fees_total = $_POST['fees_total'];

    $update = "UPDATE students SET 
        cad='$cad',
        hadoop='$hadoop',
        oe='$oe',
        track='$track',
        attendance='$attendance',
        fees_total='$fees_total'
        WHERE id='$id'";

    mysqli_query($conn,$update);

    echo "<script>alert('Updated Successfully');window.location='staff_dashboard.php';</script>";
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Update Student</title>

<style>
body{
background:#020617;
color:white;
font-family:"Book Antiqua";
padding:40px;
}

form{
max-width:400px;
margin:auto;
}

input{
width:100%;
padding:10px;
margin:10px 0;
}

button{
background:#22c55e;
padding:10px;
border:none;
color:white;
cursor:pointer;
}
</style>

</head>

<body>

<h2>Edit Student</h2>

<form method="POST">

<label>CAD</label>
<input type="number" name="cad" value="<?php echo $row['cad']; ?>">

<label>Hadoop</label>
<input type="number" name="hadoop" value="<?php echo $row['hadoop']; ?>">

<label>OE</label>
<input type="number" name="oe" value="<?php echo $row['oe']; ?>">

<label>Track</label>
<input type="number" name="track" value="<?php echo $row['track']; ?>">

<label>Attendance</label>
<input type="number" name="attendance" value="<?php echo $row['attendance']; ?>">

<label>Fees</label>
<input type="number" name="fees_total" value="<?php echo $row['fees_total']; ?>">

<button name="update">Update</button>

</form>

</body>
</html>