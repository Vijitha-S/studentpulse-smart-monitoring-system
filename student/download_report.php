<?php
session_start();
include("../config/db_connect.php");

// ✅ CHECK FILE EXISTS (DEBUG)
if(!file_exists('../tcpdf/tcpdf.php')){
    die("❌ TCPDF NOT FOUND → Check folder path");
}

require_once('../tcpdf/tcpdf.php');

$id = $_GET['id'];

// STUDENT
$student = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT s.*, d.name AS dept, y.year_name
FROM students s
JOIN departments d ON s.department_id=d.id
JOIN years y ON s.year_id=y.id
WHERE s.id='$id'
"));

// MARKS
$marks = mysqli_query($conn,"
SELECT sub.subject_name, m.marks
FROM marks m
JOIN subjects sub ON m.subject_id=sub.id
WHERE m.student_id='$id'
");

// CREATE PDF
$pdf = new TCPDF();
$pdf->AddPage();

$html = "
<h2>Student Report Card</h2>

<b>Name:</b> {$student['name']}<br>
<b>Department:</b> {$student['dept']}<br>
<b>Year:</b> {$student['year_name']}<br><br>

<table border='1' cellpadding='6'>
<tr>
<th>Subject</th>
<th>Marks</th>
</tr>
";

$total=0; $count=0;

while($m=mysqli_fetch_assoc($marks)){
$html .= "
<tr>
<td>{$m['subject_name']}</td>
<td>{$m['marks']}</td>
</tr>";

$total += $m['marks'];
$count++;
}

$avg = $count ? round($total/$count,2) : 0;

$html .= "</table><br><b>Average: $avg%</b>";

$pdf->writeHTML($html);

// DOWNLOAD
$pdf->Output("report.pdf","I");
?>