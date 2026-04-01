<?php
session_start();
include("../config/db_connect.php");

if(!isset($_SESSION['student_id'])){
    header("Location: student_login.php");
    exit();
}

$id = $_SESSION['student_id'];

// STUDENT DETAILS
$student = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT s.*, d.name AS dept, y.year_name
FROM students s
LEFT JOIN departments d ON s.department_id=d.id
LEFT JOIN years y ON s.year_id=y.id
WHERE s.id='$id'
"));

$dept_id = $student['department_id'];
$year_id = $student['year_id'];

// SUBJECTS
$subjects = mysqli_query($conn,"
SELECT sub.id, sub.subject_name,
COALESCE(MAX(m.marks),0) AS marks
FROM subjects sub
LEFT JOIN marks m 
ON sub.id = m.subject_id AND m.student_id='$id'
WHERE sub.department_id='$dept_id'
AND sub.year_id='$year_id'
GROUP BY sub.id
");

// GPA FUNCTIONS
function getGPA($mark){
    if($mark>=90) return 10;
    elseif($mark>=80) return 9;
    elseif($mark>=70) return 8;
    elseif($mark>=60) return 7;
    elseif($mark>=50) return 6;
    else return 0;
}

function getGrade($mark){
    if($mark>=90) return "O";
    elseif($mark>=80) return "A+";
    elseif($mark>=70) return "A";
    elseif($mark>=60) return "B";
    elseif($mark>=50) return "C";
    else return "F";
}

// CALCULATION
$total=0; $count=0; $gpa_total=0;
$labels=[]; $data=[];

while($row=mysqli_fetch_assoc($subjects)){
    $total += $row['marks'];
    $count++;
    $gpa_total += getGPA($row['marks']);

    $labels[] = $row['subject_name'];
    $data[] = $row['marks'];
}

$avg = $count ? round($total/$count,2) : 0;
$cgpa = $count ? round($gpa_total/$count,2) : 0;

// TOPPER
$topper = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT s.id, AVG(m.marks) avg_marks
FROM students s
JOIN marks m ON s.id=m.student_id
WHERE s.department_id='$dept_id' AND s.year_id='$year_id'
GROUP BY s.id
ORDER BY avg_marks DESC
LIMIT 1
"));

$isTopper = ($topper && $topper['id']==$id);

// ALERTS
$alerts = [];

if($avg < 50){
    $alerts[] = "Low Academic Performance";
}

if(isset($student['attendance']) && $student['attendance'] < 75){
    $alerts[] = "Low Attendance";
}

if(isset($student['fees_total']) && $student['fees_total'] > 0){
    $alerts[] = "Pending Fees ₹".$student['fees_total'];
}

$isSafe = empty($alerts);
?>

<!DOCTYPE html>
<html>
<head>
<title>Student Dashboard</title>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
body{
margin:0;
background:#020617;
color:white;
font-family:"Book Antiqua";
display:flex;
}

/* 🔥 BACK BUTTON */
.back-btn{
position:absolute;
top:20px;
left:20px;
padding:10px 18px;
background:rgba(255,255,255,0.05);
border:1px solid rgba(255,255,255,0.1);
border-radius:10px;
color:white;
cursor:pointer;
transition:0.3s;
}

.back-btn:hover{
background:#1e293b;
transform:translateY(-2px);
}

.sidebar{
width:220px;
background:#020617;
height:100vh;
padding:20px;
border-right:1px solid #1e293b;
}

.sidebar h2{margin-bottom:20px;}

.sidebar a{
display:block;
padding:12px;
margin:10px 0;
text-decoration:none;
color:white;
border-radius:8px;
}

.sidebar a.active{
background:#22c55e;
color:black;
}

.sidebar a:hover{
background:#1e293b;
}

.main{
flex:1;
padding:30px;
}

.top{
display:flex;
justify-content:space-between;
align-items:center;
}

.btn{
background:#3b82f6;
padding:8px 15px;
border-radius:8px;
color:white;
text-decoration:none;
}

.topper{
background:#16a34a;
padding:10px;
border-radius:10px;
text-align:center;
margin:20px 0;
}

.cards{
display:grid;
grid-template-columns:repeat(5,1fr);
gap:20px;
margin-bottom:20px;
}

.card{
background:#1e293b;
padding:20px;
border-radius:10px;
text-align:center;
}

.section{
background:#1e293b;
padding:25px;
border-radius:10px;
margin-top:20px;
}

table{
width:100%;
border-collapse:collapse;
}

th,td{
padding:12px;
text-align:center;
}

th{background:#111827;}
tr:nth-child(even){background:#0f172a;}

.chart-box{
width:350px;
margin:auto;
}

.risk-box{
margin-top:20px;
padding:18px;
border-radius:10px;
font-size:15px;
}

.safe{
background:rgba(34,197,94,0.15);
border:1px solid #22c55e;
color:#4ade80;
}

.risk{
background:rgba(239,68,68,0.15);
border:1px solid #ef4444;
color:#f87171;
}
</style>

</head>

<body>

<!-- ✅ BACK BUTTON -->
<div class="back-btn" onclick="window.location.href='student_login.php'">
← Back
</div>

<div class="sidebar">
<h2>🎓 Student</h2>
<a class="active">🏠 Dashboard</a>
<a href="#">📘 Subjects</a>
<a href="#">📊 Marks</a>
<a href="logout.php">🚪 Logout</a>
</div>

<div class="main">

<div class="top">
<h1>Welcome <?php echo $student['name']; ?></h1>
<a href="leaderboard.php" class="btn">🏆 Leaderboard</a>
</div>

<?php if($isTopper){ ?>
<div class="topper">👑 You are the Topper!</div>
<?php } ?>

<div class="cards">
<div class="card">Department<br><?php echo $student['dept']; ?></div>
<div class="card">Year<br><?php echo $student['year_name']; ?></div>
<div class="card">Total<br><?php echo $total; ?></div>
<div class="card">Average<br><?php echo $avg; ?>%</div>
<div class="card">CGPA<br><?php echo $cgpa; ?></div>
</div>

<div class="section">
<h2>📘 Subject Marks</h2>

<table>
<tr>
<th>Subject</th>
<th>Marks</th>
<th>Grade</th>
<th>GPA</th>
</tr>

<?php
mysqli_data_seek($subjects,0);
while($row=mysqli_fetch_assoc($subjects)){
echo "<tr>
<td>{$row['subject_name']}</td>
<td>{$row['marks']}</td>
<td>".getGrade($row['marks'])."</td>
<td>".getGPA($row['marks'])."</td>
</tr>";
}
?>
</table>
</div>

<div class="section">
<h2>📊 Performance Chart</h2>

<div class="chart-box">
<canvas id="chart"></canvas>
</div>

<div class="risk-box <?php echo $isSafe ? 'safe' : 'risk'; ?>">
<?php if($isSafe){ ?>
✔ Performance is Good — Keep it up!
<?php } else { ?>
⚠ <b>Risk Alert</b>
<ul>
<?php foreach($alerts as $a){ echo "<li>$a</li>"; } ?>
</ul>
<?php } ?>
</div>

</div>

</div>

<script>
new Chart(document.getElementById("chart"),{
type:'pie',
data:{
labels: <?php echo json_encode($labels); ?>,
datasets:[{
data: <?php echo json_encode($data); ?>,
backgroundColor:[
'#0f172a',
'#1e3a8a',
'#374151',
'#581c87',
'#111827'
],
borderColor:'#020617',
borderWidth:2
}]
}
});
</script>

</body>
</html>