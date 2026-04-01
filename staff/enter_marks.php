<?php
include("../config/db_connect.php");

// Save Marks
if(isset($_POST['save_marks'])){
    $student_id = $_POST['student_id'];

    foreach($_POST['marks'] as $subject_id => $mark){
        mysqli_query($conn,"INSERT INTO marks(student_id, subject_id, marks)
        VALUES('$student_id','$subject_id','$mark')");
    }

    echo "<script>alert('Marks Saved Successfully');</script>";
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Enter Marks</title>

<style>
body{
background:#020617;
color:white;
font-family:Arial;
text-align:center;
}

.container{
margin-top:40px;
}

select, input{
padding:10px;
margin:5px;
width:250px;
}

button{
padding:10px 20px;
background:#3b82f6;
color:white;
border:none;
cursor:pointer;
}

table{
margin:20px auto;
border-collapse:collapse;
width:50%;
}

th, td{
border:1px solid #ccc;
padding:10px;
}

th{
background:#1e293b;
}
</style>

</head>

<body>

<div class="container">

<h2>Enter Student Marks</h2>

<!-- Select Student -->
<form method="GET">
<select name="student_id" required>
<option value="">Select Student</option>

<?php
$students = mysqli_query($conn,"SELECT * FROM students");
while($s = mysqli_fetch_assoc($students)){
    echo "<option value='".$s['id']."'>".$s['name']."</option>";
}
?>
</select>

<button type="submit">Load Subjects</button>
</form>

<?php
if(isset($_GET['student_id'])){

$student_id = $_GET['student_id'];

// Get student details
$student = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM students WHERE id='$student_id'"));

$dept_id = $student['department_id'];
$year_id = $student['year_id'];

// Fetch subjects
$subjects = mysqli_query($conn,"SELECT * FROM subjects 
WHERE department_id='$dept_id' AND year_id='$year_id'");
?>

<!-- Marks Form -->
<form method="POST">

<input type="hidden" name="student_id" value="<?php echo $student_id; ?>">

<table>
<tr>
<th>Subject</th>
<th>Marks</th>
</tr>

<?php
while($sub = mysqli_fetch_assoc($subjects)){
    echo "<tr>
            <td>".$sub['subject_name']."</td>
            <td><input type='number' name='marks[".$sub['id']."]' required></td>
          </tr>";
}
?>

</table>

<button type="submit" name="save_marks">Save Marks</button>

</form>

<?php } ?>

</div>

</body>
</html>