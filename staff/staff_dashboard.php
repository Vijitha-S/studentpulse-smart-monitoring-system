<?php
session_start();
include("../config/db_connect.php");

if(!isset($_SESSION['staff_id'])){
    header("Location: staff_login.php");
    exit();
}

$staff_id = $_SESSION['staff_id'];

$staff = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT * FROM staff WHERE id='$staff_id'
"));

$dept_id = $staff['department_id'];

// FETCH STUDENTS
$students = mysqli_query($conn,"
SELECT s.*, y.year_name 
FROM students s
LEFT JOIN years y ON s.year_id=y.id
WHERE s.department_id='$dept_id'
");

// SAVE DATA
if(isset($_POST['save'])){
    $sid = $_POST['student_id'];

    mysqli_query($conn,"
    UPDATE students SET 
    attendance='".mysqli_real_escape_string($conn,$_POST['attendance'])."',
    fees_paid='".mysqli_real_escape_string($conn,$_POST['fees_paid'])."'
    WHERE id='$sid'
    ");

    foreach($_POST['marks'] as $sub=>$mark){

        $sub = mysqli_real_escape_string($conn,$sub);
        $mark = mysqli_real_escape_string($conn,$mark);

        $check = mysqli_query($conn,"
        SELECT id FROM marks 
        WHERE student_id='$sid' AND subject_id='$sub'
        ");

        if(mysqli_num_rows($check) > 0){

            mysqli_query($conn,"
            UPDATE marks 
            SET marks='$mark'
            WHERE student_id='$sid' AND subject_id='$sub'
            ");

        } else {

            mysqli_query($conn,"
            INSERT INTO marks(student_id,subject_id,marks)
            VALUES('$sid','$sub','$mark')
            ");
        }
    }

    header("Location: staff_dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Staff Dashboard</title>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
body{
margin:0;
background:#020617;
color:white;
font-family:"Book Antiqua";
}

/* 🔥 TOP PANEL */
.top-panel{
position:fixed;
top:15px;
left:20px;
display:flex;
gap:10px;
z-index:1000;
}

.panel-btn{
padding:10px 18px;
background:rgba(255,255,255,0.05);
border:1px solid rgba(255,255,255,0.1);
border-radius:10px;
color:white;
cursor:pointer;
transition:0.3s;
backdrop-filter:blur(10px);
}

.panel-btn:hover{
background:#1e293b;
transform:translateY(-2px);
}

.logout-btn{
background:rgba(239,68,68,0.2);
border:1px solid #ef4444;
}

.logout-btn:hover{
background:#ef4444;
color:white;
}

/* ORIGINAL UI */
.main{
max-width:1200px;
margin:auto;
padding:30px;
}

h1{
margin-bottom:20px;
}

.card{
background:rgba(255,255,255,0.05);
backdrop-filter:blur(12px);
padding:25px;
border-radius:16px;
margin-bottom:30px;
box-shadow:0 10px 30px rgba(0,0,0,0.5);
}

.title{
font-size:20px;
margin-bottom:15px;
}

.flex{
display:flex;
gap:30px;
}

.left{
flex:1;
}

table{
width:100%;
border-collapse:collapse;
}

th,td{
padding:10px;
text-align:left;
}

th{
color:#94a3b8;
}

tr{
border-bottom:1px solid #1e293b;
}

input{
padding:6px;
width:70px;
border-radius:6px;
border:none;
text-align:center;
background:#111827;
color:white;
}

.right{
width:320px;
}

.info{
display:flex;
gap:20px;
margin-top:20px;
}

.info div{
background:#1e293b;
padding:12px;
border-radius:8px;
}

.btn{
margin-top:20px;
background:#16a34a;
border:none;
padding:10px 20px;
border-radius:10px;
color:white;
cursor:pointer;
}

.btn:hover{
background:#15803d;
}
</style>
</head>

<body>

<!-- 🔥 FIXED PANEL -->
<div class="top-panel">
    <div class="panel-btn" onclick="window.location.href='staff_login.php'">← Back</div>
    <div class="panel-btn logout-btn" onclick="window.location.href='logout.php'">Logout</div>
</div>

<div class="main">

<h1>📊 Staff Dashboard</h1>

<?php while($stu=mysqli_fetch_assoc($students)){ ?>

<div class="card">

<div class="title">
👤 <?php echo $stu['name']." (".$stu['year_name'].")"; ?>
</div>

<form method="POST">
<input type="hidden" name="student_id" value="<?php echo $stu['id']; ?>">

<div class="flex">

<div class="left">

<table>
<tr>
<th>Subject</th>
<th>Marks</th>
</tr>

<?php
$labels=[]; 
$data=[];

$subjects = mysqli_query($conn,"
SELECT * FROM subjects 
WHERE department_id='".$stu['department_id']."' 
AND year_id='".$stu['year_id']."'
");

while($sub=mysqli_fetch_assoc($subjects)){

$m = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT marks FROM marks 
WHERE student_id='".$stu['id']."' 
AND subject_id='".$sub['id']."'
"));

$val = $m['marks'] ?? 0;

$labels[] = $sub['subject_name'];
$data[] = $val;
?>

<tr>
<td><?php echo $sub['subject_name']; ?></td>
<td>
<input type="number" name="marks[<?php echo $sub['id']; ?>]" value="<?php echo $val; ?>">
</td>
</tr>

<?php } ?>

</table>

</div>

<div class="right">
<canvas id="chart<?php echo $stu['id']; ?>"></canvas>
</div>

</div>

<div class="info">

<div>
Attendance %<br>
<input type="number" name="attendance" value="<?php echo $stu['attendance']; ?>">
</div>

<div>
Fees Paid<br>
<input type="number" name="fees_paid" value="<?php echo $stu['fees_paid']; ?>">
</div>

<div>
Remaining<br>
₹<?php echo $stu['fees_total'] - $stu['fees_paid']; ?>
</div>

</div>

<button name="save" class="btn">Save</button>

</form>

</div>

<script>
new Chart(document.getElementById("chart<?php echo $stu['id']; ?>"),{
type:'bar',
data:{
labels: <?php echo json_encode($labels); ?>,
datasets:[{
data: <?php echo json_encode($data); ?>,
backgroundColor:[
'#1e3a8a',
'#374151',
'#581c87',
'#0f172a'
],
borderRadius:8
}]
},
options:{
indexAxis:'y',
plugins:{legend:{display:false}},
scales:{
x:{ticks:{color:'white'},grid:{color:'#1e293b'}},
y:{ticks:{color:'white'},grid:{display:false}}
}
}
});
</script>

<?php } ?>

</div>

</body>
</html>