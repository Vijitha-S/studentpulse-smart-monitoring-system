<?php

$conn = mysqli_connect("localhost","root","root","college_system");

if($conn){
    echo "Database Connected Successfully!";
}
else{
    echo "Database Connection Failed!";
}

?>