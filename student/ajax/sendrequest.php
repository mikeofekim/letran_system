<?php
session_start();
include('../../php/db_config.php');
date_default_timezone_set("Asia/Manila");
$myid = $_SESSION['userdata']['userAccountID'];
$id = $_POST['id'];
$code = rand(10000, 99999);
$time = date('Y-m-d H:i:s');

$sql = "SELECT * FROM consultations WHERE patientID = $myid AND doctorID = $id AND (status = 0 OR status = 1)";
$result = mysqli_query($conn, $sql);

if ($result->num_rows == 0) {
    $sql = "INSERT INTO consultations VALUES(null, $code, $myid, $id, 0, '$time' )";
    if (mysqli_query($conn, $sql)) {
        echo 1;
    } else echo $conn->error;
} else echo 0;
