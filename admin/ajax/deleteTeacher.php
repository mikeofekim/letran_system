<?php
session_start();
include('../../php/db_config.php');
$id = $_POST['id'];


$sql = "DELETE FROM teachers WHERE doctorID= $id";

if (mysqli_query($conn, $sql)) {
    echo 1;
} else {
    echo $conn->error;
}
