<?php
include("../config/db_connect.php");

$result = mysqli_query($conn,"
SELECT s.id, s.name, d.name AS dept, y.year_name,
AVG(m.marks) AS avg_marks
FROM students s
JOIN marks m ON s.id=m.student_id
JOIN departments d ON s.department_id=d.id
JOIN years y ON s.year_id=y.id
GROUP BY s.id
ORDER BY avg_marks DESC
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Rank List</title>

<style>
body{
background:#020617;
color:white;
font-family:"Book Antiqua";
padding:20px;
}

h1{text-align:center;}

table{
width:90%;
margin:auto;
border-collapse:collapse;
}

th,td{
padding:12px;
text-align:center;
}

th{background:#111827;}

tr:nth-child(even){background:#0f172a;}

.top{
color:#facc15;
font-weight:bold;
}
</style>

</head>

<body>

<h1>🏆 Rank List</h1>

<table>
<tr>
<th>Rank</th>
<th>Name</th>
<th>Department</th>
<th>Year</th>
<th>Average</th>
</tr>

<?php
$rank=1;
while($row=mysqli_fetch_assoc($result)){
$class = ($rank==1) ? "top" : "";

echo "<tr class='$class'>
<td>$rank</td>
<td>{$row['name']}</td>
<td>{$row['dept']}</td>
<td>{$row['year_name']}</td>
<td>".round($row['avg_marks'],2)."%</td>
</tr>";

$rank++;
}
?>

</table>

</body>
</html>