<?php
include("../config/db_connect.php");

// ================= ADD / UPDATE =================
if(isset($_POST['save'])){

    $subject_name = trim($_POST['subject_name']);
    $department_id = $_POST['department_id'];
    $year_id = $_POST['year_id'];

    if(!empty($subject_name) && !empty($department_id) && !empty($year_id)){

        // 🔥 UPDATE
        if(isset($_POST['edit_id']) && $_POST['edit_id'] != ""){

            $id = $_POST['edit_id'];

            mysqli_query($conn,"
            UPDATE subjects 
            SET subject_name='$subject_name',
                department_id='$department_id',
                year_id='$year_id'
            WHERE id='$id'
            ");

            $success = "Subject Updated Successfully";

        } 
        // 🔥 INSERT
        else {

            mysqli_query($conn,"
            INSERT INTO subjects (subject_name, department_id, year_id)
            VALUES ('$subject_name','$department_id','$year_id')
            ");

            $success = "Subject Added Successfully";
        }

    } else {
        $error = "All fields are required!";
    }
}

// ================= DELETE =================
if(isset($_GET['delete'])){
    $id = $_GET['delete'];

    mysqli_query($conn,"DELETE FROM subjects WHERE id='$id'");
    header("Location: add_subject.php");
    exit();
}

// ================= EDIT FETCH =================
$edit_data = null;

if(isset($_GET['edit'])){
    $id = $_GET['edit'];

    $res = mysqli_query($conn,"SELECT * FROM subjects WHERE id='$id'");
    $edit_data = mysqli_fetch_assoc($res);
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Subject Management</title>

<style>
body{
background:#020617;
color:white;
font-family:"Book Antiqua";
text-align:center;
}

.container{
margin-top:40px;
}

input, select{
padding:12px;
width:280px;
margin:8px;
border-radius:6px;
border:none;
}

button{
padding:12px 20px;
background:#3b82f6;
color:white;
border:none;
border-radius:6px;
cursor:pointer;
}

button:hover{
background:#1e40af;
}

.success{color:#4ade80;}
.error{color:#ef4444;}

table{
margin:30px auto;
width:80%;
border-collapse:collapse;
}

th,td{
padding:12px;
border:1px solid #ccc;
text-align:center;
}

th{
background:#1e293b;
}

tr:nth-child(even){
background:#0f172a;
}

.edit-btn{
background:#f59e0b;
padding:6px 12px;
color:white;
border-radius:5px;
text-decoration:none;
margin-right:5px;
}

.delete-btn{
background:#ef4444;
padding:6px 12px;
color:white;
border-radius:5px;
text-decoration:none;
}
</style>

</head>

<body>

<div class="container">

<h1>Subject Management</h1>

<?php 
if(isset($success)) echo "<p class='success'>$success</p>";
if(isset($error)) echo "<p class='error'>$error</p>";
?>

<!-- ================= FORM ================= -->
<form method="POST">

<input type="hidden" name="edit_id" value="<?php echo $edit_data['id'] ?? ''; ?>">

<input type="text" name="subject_name"
value="<?php echo $edit_data['subject_name'] ?? ''; ?>"
placeholder="Enter Subject Name" required><br>

<!-- Department -->
<select name="department_id" required>
<option value="">Select Department</option>
<?php
$dept = mysqli_query($conn,"SELECT * FROM departments");
while($d = mysqli_fetch_assoc($dept)){
    $selected = ($edit_data['department_id'] ?? '') == $d['id'] ? "selected" : "";
    echo "<option value='".$d['id']."' $selected>".$d['name']."</option>";
}
?>
</select><br>

<!-- Year -->
<select name="year_id" required>
<option value="">Select Year</option>
<?php
$year = mysqli_query($conn,"SELECT * FROM years");
while($y = mysqli_fetch_assoc($year)){
    $selected = ($edit_data['year_id'] ?? '') == $y['id'] ? "selected" : "";
    echo "<option value='".$y['id']."' $selected>".$y['year_name']."</option>";
}
?>
</select><br>

<button name="save">
<?php echo $edit_data ? "Update Subject" : "Add Subject"; ?>
</button>

</form>

<!-- ================= TABLE ================= -->
<h2>All Subjects</h2>

<table>

<tr>
<th>ID</th>
<th>Subject</th>
<th>Department</th>
<th>Year</th>
<th>Actions</th>
</tr>

<?php
$result = mysqli_query($conn,"
SELECT subjects.*, 
       departments.name AS dept, 
       years.year_name
FROM subjects
JOIN departments ON subjects.department_id = departments.id
JOIN years ON subjects.year_id = years.id
ORDER BY subjects.id DESC
");

while($row = mysqli_fetch_assoc($result)){
?>

<tr>
<td><?php echo $row['id']; ?></td>

<!-- ✅ FIXED (NO ERROR) -->
<td><?php echo $row['subject_name']; ?></td>

<td><?php echo $row['dept']; ?></td>

<td><?php echo $row['year_name']; ?></td>

<td>
<a class="edit-btn" href="add_subject.php?edit=<?php echo $row['id']; ?>">Edit</a>

<a class="delete-btn"
href="add_subject.php?delete=<?php echo $row['id']; ?>"
onclick="return confirm('Delete this subject?')">Delete</a>
</td>

</tr>

<?php } ?>

</table>

</div>

</body>
</html>