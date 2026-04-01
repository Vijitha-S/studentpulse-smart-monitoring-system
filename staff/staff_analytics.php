<?php
include("../config/db_connect.php");

$result = mysqli_query($conn,"SELECT * FROM students");

$total_students = 0;
$total_attendance = 0;
$total_fees_pending = 0;

$cad_total = 0;
$hadoop_total = 0;
$oe_total = 0;
$track_total = 0;

while($row = mysqli_fetch_assoc($result)){

    $total_students++;

    $total_attendance += $row['attendance'];

    $cad_total += $row['cad'];
    $hadoop_total += $row['hadoop'];
    $oe_total += $row['oe'];
    $track_total += $row['track'];

    if($row['fees_total'] > 0){
        $total_fees_pending++;
    }
}

// Avoid division error
$avg_attendance = ($total_students > 0) ? round($total_attendance / $total_students,2) : 0;

$avg_cad = ($total_students > 0) ? round($cad_total / $total_students,2) : 0;
$avg_hadoop = ($total_students > 0) ? round($hadoop_total / $total_students,2) : 0;
$avg_oe = ($total_students > 0) ? round($oe_total / $total_students,2) : 0;
$avg_track = ($total_students > 0) ? round($track_total / $total_students,2) : 0;

?>

<!DOCTYPE html>
<html>
<head>

<title>Analytics</title>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>

body{
background:#020617;
color:white;
font-family:"Book Antiqua";
padding:40px;
}

.card{
background:#1e293b;
padding:20px;
margin-bottom:20px;
border-radius:10px;
}

.chart-box{
max-width:500px;
margin:30px auto;
}

</style>

</head>

<body>

<h1>Analytics Dashboard</h1>

<!-- Cards -->

<div class="card">Total Students: <?php echo $total_students; ?></div>
<div class="card">Average Attendance: <?php echo $avg_attendance; ?>%</div>
<div class="card">Fees Pending Students: <?php echo $total_fees_pending; ?></div>

<!-- Chart 1 -->

<div class="chart-box">
<canvas id="marksChart"></canvas>
</div>

<!-- Chart 2 -->

<div class="chart-box">
<canvas id="attendanceChart"></canvas>
</div>

<script>

// 🔥 Subject Average Chart
new Chart(document.getElementById("marksChart"),{
type:'bar',
data:{
labels:['CAD','Hadoop','OE','Track'],
datasets:[{
label:'Average Marks',
data:[
<?php echo $avg_cad; ?>,
<?php echo $avg_hadoop; ?>,
<?php echo $avg_oe; ?>,
<?php echo $avg_track; ?>
],
backgroundColor:[
'#000000',
'#1e3a8a',
'#374151',
'#581c87'
]
}]
},
options:{
plugins:{
legend:{labels:{color:'white'}}
}
}
});

// 🔥 Attendance Chart
new Chart(document.getElementById("attendanceChart"),{
type:'doughnut',
data:{
labels:['Attendance','Remaining'],
datasets:[{
data:[
<?php echo $avg_attendance; ?>,
<?php echo 100 - $avg_attendance; ?>
],
backgroundColor:[
'#22c55e',
'#ef4444'
]
}]
}
});

</script>

</body>
</html>