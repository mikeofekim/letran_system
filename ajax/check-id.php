<?php
session_start();
include('../php/db_config.php');

$student_id =  $conn->real_escape_string($_POST['school_id']);

$sss = "SELECT * FROM school_id WHERE school_id = '$student_id'";
$res = mysqli_query($conn, $sss);
if ($res->num_rows > 0) {
    echo 1;
}

