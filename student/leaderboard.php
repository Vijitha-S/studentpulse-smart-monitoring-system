<?php
session_start();
include("../config/db_connect.php");

if(!isset($_SESSION['student_id'])){
    header("Location: student_login.php");
    exit();
}

$id = $_SESSION['student_id'];

// student info
$student = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT s.*, d.name AS dept, y.year_name
FROM students s
LEFT JOIN departments d ON s.department_id=d.id
LEFT JOIN years y ON s.year_id=y.id
WHERE s.id='$id'
"));

$dept_id = $student['department_id'];
$year_id = $student['year_id'];

// leaderboard data
$data = [];
$res = mysqli_query($conn,"
SELECT s.name, AVG(m.marks) AS avg_marks
FROM students s
JOIN marks m ON s.id=m.student_id
WHERE s.department_id='$dept_id' AND s.year_id='$year_id'
GROUP BY s.id
ORDER BY avg_marks DESC
");

while($row=mysqli_fetch_assoc($res)){
    $data[] = $row;
}

// 🧠 AI PREDICTION
$prediction = "Stable Topper";

if(count($data) > 1){
    $gap = $data[0]['avg_marks'] - $data[1]['avg_marks'];

    if($gap < 5){
        $prediction = $data[1]['name']." may become next topper 🔥";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Leaderboard</title>

<style>
body{
margin:0;
background:#020617;
color:white;
font-family:"Book Antiqua";
}

/* BACK */
.back{
position:absolute;
top:20px;
left:20px;
background:#1e293b;
padding:10px 16px;
border-radius:8px;
text-decoration:none;
color:white;
}
.back:hover{background:#334155;}

/* MAIN */
.container{
padding:40px;
max-width:1100px;
margin:auto;
}

/* TITLE */
.title{
font-size:26px;
margin-bottom:25px;
}

/* GRID */
.grid{
display:grid;
grid-template-columns:2fr 1fr;
gap:25px;
}

/* CARD */
.card{
background:#1e293b;
padding:25px;
border-radius:14px;
box-shadow:0 10px 30px rgba(0,0,0,0.4);
}

/* TABLE */
table{
width:100%;
border-collapse:collapse;
}

th,td{
padding:15px;
text-align:center;
}

th{background:#111827;}

tr{border-bottom:1px solid #0f172a;}

tr:hover{background:#0f172a;}

/* TOPPER */
.topper{
font-weight:bold;
}

/* RANK */
.rank{
background:#111827;
padding:5px 12px;
border-radius:6px;
}

/* AI BOX */
.ai-box{
font-size:16px;
line-height:1.6;
}

/* BIG TEXT */
.highlight{
font-size:20px;
margin-top:10px;
}
</style>

</head>

<body>

<a href="student_dashboard.php" class="back">← Back</a>

<div class="container">

<div class="title">
🏆 Leaderboard (<?php echo $student['dept']; ?> - <?php echo $student['year_name']; ?>)
</div>

<div class="grid">

<!-- LEADERBOARD -->
<div class="card">
<table>
<tr>
<th>Rank</th>
<th>Name</th>
<th>Average</th>
</tr>

<?php
$rank=1;
foreach($data as $row){

$name = $row['name'];
$avg = round($row['avg_marks'],2);

if($rank==1){
    $name = "<span class='topper'>$name 👑</span>";
}

echo "<tr>
<td><span class='rank'>#$rank</span></td>
<td>$name</td>
<td>$avg%</td>
</tr>";

$rank++;
}
?>
</table>
</div>

<!-- AI PREDICTION -->
<div class="card ai-box">
<h3>🤖 AI Insight</h3>

<p><b>Top Performer:</b> <?php echo $data[0]['name']; ?></p>

<div class="highlight">
<?php echo $prediction; ?>
</div>

<p style="margin-top:15px;font-size:14px;color:#94a3b8;">
Prediction based on performance gap analysis.
</p>
</div>

</div>

</div>

</body>
</html>