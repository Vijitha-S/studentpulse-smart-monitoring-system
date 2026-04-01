<?php
session_start();
include("../config/db_connect.php");

if(!isset($_SESSION['admin'])){
    header("Location: admin_login.php");
    exit();
}

$staff = mysqli_query($conn,"
SELECT s.*, d.name as dept, y.year_name
FROM staff s
LEFT JOIN departments d ON s.department_id=d.id
LEFT JOIN years y ON s.year_id=y.id
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Manage Staff</title>

<style>
body{
background:#020617;
color:white;
font-family:"Book Antiqua";
padding:30px;
}

table{
width:100%;
border-collapse:collapse;
}

th,td{
padding:12px;
text-align:center;
}

th{background:#1e293b;}

tr:nth-child(even){
background:#0f172a;
}

.btn{
padding:6px 10px;
border-radius:6px;
text-decoration:none;
color:white;
}

.edit{background:#3b82f6;}
.delete{background:#ef4444;}
</style>

</head>

<body>

<h2>All Staff</h2>

<table>
<tr>
<th>ID</th>
<th>Name</th>
<th>Email</th>
<th>Department</th>
<th>Year</th>
<th>Type</th>
<th>Action</th>
</tr>

<?php while($row=mysqli_fetch_assoc($staff)){ ?>

<tr>
<td><?=$row['id']?></td>
<td><?=$row['name']?></td>
<td><?=$row['email']?></td>
<td><?=$row['dept']?></td>
<td><?=$row['year_name']?></td>
<td><?=$row['type']?></td>

<td>
<a class="btn edit" href="edit_staff.php?id=<?=$row['id']?>">Edit</a>
<a class="btn delete" 
onclick="return confirm('Delete this staff?')"
href="delete_staff.php?id=<?=$row['id']?>">Delete</a>
</td>
</tr>

<?php } ?>

</table>

</body>
</html>