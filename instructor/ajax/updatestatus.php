<?php
session_start();
include('../../php/db_config.php');

$id = $_POST['id'];
$status = $_POST['status'];
$doctor_id = $_SESSION['userdata']['userAccountID'];
if ($status == 1) {

    $sql = "SELECT * FROM consultations WHERE doctorID = $doctor_id AND status = 1";
    $result = mysqli_query($conn, $sql);
    if ($result->num_rows > 0) {
        echo 13;
    } else {
        $sql = "UPDATE consultations SET status = $status WHERE consultationID = $id";

        if (mysqli_query($conn, $sql)) {
            echo 11;
        } else echo $conn->error;
    }
} else {
    $sql = "UPDATE consultations SET status = $status WHERE consultationID = $id";

    if (mysqli_query($conn, $sql)) {
        if ($status == 2) {
            echo 31;
        } else if ($status == 3) {
            echo 21;
        }
    } else echo $conn->error;
}
