<?php
include("../config/db_connect.php");

if(isset($_FILES['file'])){

    $file = fopen($_FILES['file']['tmp_name'], "r");

    while(($row = fgetcsv($file)) !== FALSE){

        $student_id = mysqli_real_escape_string($conn, $row[0]);
        $subject_id = mysqli_real_escape_string($conn, $row[1]);
        $marks = mysqli_real_escape_string($conn, $row[2]);

        // CHECK EXIST
        $check = mysqli_query($conn,"
        SELECT id FROM marks 
        WHERE student_id='$student_id' 
        AND subject_id='$subject_id'
        ");

        if(mysqli_num_rows($check) > 0){

            // UPDATE
            mysqli_query($conn,"
            UPDATE marks 
            SET marks='$marks'
            WHERE student_id='$student_id' 
            AND subject_id='$subject_id'
            ");

        } else {

            // INSERT
            mysqli_query($conn,"
            INSERT INTO marks(student_id,subject_id,marks)
            VALUES('$student_id','$subject_id','$marks')
            ");
        }
    }

    fclose($file);
}

header("Location: staff_dashboard.php");
exit();
?>