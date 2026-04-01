<?php
include("../config/db_connect.php");
$result = mysqli_query($conn,"SELECT * FROM students");
?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Students | Staff Panel</title>

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
background:#020617;
color:white;
padding:40px;
}

/* Header */

.header{
display:flex;
justify-content:space-between;
align-items:center;
margin-bottom:30px;
}

.header h1{
font-size:32px;
}

/* Search */

.search-box{
position:relative;
}

.search-box input{
padding:12px 15px 12px 40px;
border-radius:10px;
border:none;
background:#1e293b;
color:white;
width:280px;
}

.search-box i{
position:absolute;
left:12px;
top:50%;
transform:translateY(-50%);
color:#94a3b8;
}

/* Table Container */

.table-box{
background:rgba(255,255,255,0.05);
backdrop-filter:blur(15px);
padding:30px;
border-radius:15px;
border:1px solid rgba(255,255,255,0.1);
}

/* Table */

table{
width:100%;
border-collapse:collapse;
}

th,td{
padding:14px;
text-align:center;
}

th{
background:#1e293b;
font-size:15px;
}

tr:nth-child(even){
background:#0f172a;
}

/* Hover */

tr:hover{
background:#1e293b;
transition:0.3s;
}

/* Badge */

.badge{
padding:6px 10px;
border-radius:8px;
font-size:13px;
font-weight:bold;
}

.paid{
background:#16a34a;
}

.notpaid{
background:#dc2626;
}

/* Button */

.update-btn{
background:linear-gradient(135deg,#22c55e,#16a34a);
padding:8px 14px;
border-radius:8px;
color:white;
text-decoration:none;
transition:0.3s;
}

.update-btn:hover{
transform:translateY(-2px);
box-shadow:0 6px 15px rgba(34,197,94,0.4);
}

</style>

</head>

<body>

<div class="header">

<h1>Students List</h1>

<div class="search-box">
<i class="fa fa-search"></i>
<input type="text" id="search" placeholder="Search student...">
</div>

</div>

<div class="table-box">

<table id="table">

<tr>
<th>ID</th>
<th>Name</th>
<th>Email</th>
<th>Attendance</th>
<th>Fees</th>
<th>Status</th>
<th>Action</th>
</tr>

<?php while($row=mysqli_fetch_assoc($result)){ ?>

<tr>

<td><?php echo $row['id']; ?></td>
<td><?php echo $row['name']; ?></td>
<td><?php echo $row['email']; ?></td>
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
<a class="update-btn" href="update_student.php?id=<?php echo $row['id']; ?>">
Update
</a>
</td>

</tr>

<?php } ?>

</table>

</div>

<!-- 🔍 Search Script -->

<script>

document.getElementById("search").addEventListener("keyup", function(){

let val = this.value.toLowerCase();

document.querySelectorAll("#table tr").forEach((row,i)=>{

if(i===0) return;

row.style.display = row.innerText.toLowerCase().includes(val) ? "" : "none";

});

});

</script>

</body>
</html>