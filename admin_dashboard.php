<?php
session_start();
include("../config/db_connect.php");

// Protect admin page
if(!isset($_SESSION['admin'])){
    header("Location: admin_login.php");
    exit();
}

// FETCH STUDENTS
$result = mysqli_query($conn,"
SELECT 
    students.*, 
    departments.name AS dept,
    years.year_name
FROM students
LEFT JOIN departments ON students.department_id = departments.id
LEFT JOIN years ON students.year_id = years.id
ORDER BY dept, years.year_name
");
?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Admin Dashboard | StudentPulse</title>

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:"Book Antiqua", serif;
}

body{
display:flex;
background:#020617;
color:white;
}

/* 🔥 FIXED BACK BUTTON (TOP-LEFT OUTSIDE SIDEBAR) */
.back-btn{
position:fixed;
top:20px;
left:20px;
padding:10px 18px;
background:rgba(255,255,255,0.05);
border:1px solid rgba(255,255,255,0.1);
border-radius:10px;
color:white;
cursor:pointer;
transition:0.3s;
backdrop-filter:blur(10px);
z-index:1000;
}

.back-btn:hover{
background:#1e293b;
transform:translateY(-2px);
}

/* Sidebar */

.sidebar{
width:240px;
height:100vh;
background:#0f172a;
padding:30px;
margin-left:60px; /* 🔥 space for back button */
}

.sidebar h2{
margin-bottom:40px;
}

.sidebar a{
display:block;
color:white;
text-decoration:none;
margin:12px 0;
padding:10px;
border-radius:6px;
transition:0.3s;
}

.sidebar a:hover{
background:#1e293b;
}

/* Main */

.main{
flex:1;
padding:30px;
}

/* Header */

.header{
display:flex;
justify-content:space-between;
align-items:center;
margin-bottom:30px;
}

/* Buttons */

.btn{
display:inline-block;
padding:8px 14px;
border-radius:6px;
text-decoration:none;
color:white;
font-size:14px;
margin:2px;
white-space:nowrap;
transition:0.2s;
}

.btn:hover{
opacity:0.85;
}

.add{background:#22c55e;}
.delete{background:#ef4444;}
.edit{background:#3b82f6;}

/* Table */

.table-box{
background:rgba(255,255,255,0.05);
padding:25px;
border-radius:15px;
border:1px solid rgba(255,255,255,0.1);
}

table{
width:100%;
border-collapse:collapse;
}

th,td{
padding:14px;
text-align:center;
vertical-align:middle;
}

th{
background:#1e293b;
}

tr:nth-child(even){
background:#0f172a;
}

td{
white-space:nowrap;
}

/* Badge */

.badge{
display:inline-block;
padding:6px 12px;
border-radius:20px;
font-size:13px;
font-weight:bold;
white-space:nowrap;
}

.paid{background:#16a34a;}
.notpaid{background:#dc2626;}

/* Group Row */

.group-row{
background:#1e293b;
font-weight:bold;
}

</style>

</head>

<body>

<!-- 🔥 BACK BUTTON -->
<div class="back-btn" onclick="window.location.href='admin_login.php'">
← Back
</div>

<!-- Sidebar -->

<div class="sidebar">

<h2>Admin Panel</h2>

<a href="admin_dashboard.php"><i class="fa fa-home"></i> Dashboard</a>
<a href="add_department.php"><i class="fa fa-building"></i> Department</a>
<a href="add_year.php"><i class="fa fa-calendar"></i> Year</a>
<a href="add_subject.php"><i class="fa fa-book"></i> Subject</a>
<a href="add_student.php"><i class="fa fa-user-plus"></i> Student</a>

<a href="add_staff.php"><i class="fa fa-user"></i> Add Staff</a>

<!-- ✅ NEW PAGE -->
<a href="manage_staff.php"><i class="fa fa-users"></i> Manage Staff</a>

<a href="logout.php"><i class="fa fa-sign-out"></i> Logout</a>

</div>

<!-- Main -->

<div class="main">

<div class="header">

<h1>Admin Dashboard</h1>

<div>
<a href="add_student.php" class="btn add">+ Add Student</a>
</div>

</div>

<div class="table-box">

<h2>All Students</h2>

<table>

<tr>
<th>ID</th>
<th>Name</th>
<th>Email</th>
<th>Department</th>
<th>Year</th>
<th>Attendance</th>
<th>Fees</th>
<th>Status</th>
<th>Action</th>
</tr>

<?php
$current_group = "";

while($row=mysqli_fetch_assoc($result)){

    $group = ($row['dept'] ?? 'No Dept')." - ".($row['year_name'] ?? '-');

    if($current_group != $group){
        echo "<tr class='group-row'>
                <td colspan='9'>$group</td>
              </tr>";
        $current_group = $group;
    }
?>

<tr>

<td><?php echo $row['id']; ?></td>
<td><?php echo $row['name']; ?></td>
<td><?php echo $row['email']; ?></td>
<td><?php echo $row['dept'] ?? '-'; ?></td>
<td><?php echo $row['year_name'] ?? '-'; ?></td>
<td><?php echo $row['attendance']; ?>%</td>
<td>₹<?php echo $row['fees_total']; ?></td>

<td>
<?php
if($row['fees_total']==0){
echo "<span class='badge paid'>Paid</span>";
}else{
echo "<span class='badge notpaid'>Not Paid</span>";
}
?>
</td>

<td>
<div style="display:flex; justify-content:center; gap:6px;">
<a class="btn edit" href="edit_student.php?id=<?php echo $row['id']; ?>">Edit</a>
<a class="btn delete" href="delete_student.php?id=<?php echo $row['id']; ?>">Delete</a>
</div>
</td>

</tr>

<?php } ?>

</table>

</div>

</div>

</body>
</html>