<?php
session_start();
include('../../php/db_config.php');

$id = $_POST['vcid'];


$sql = "DELETE FROM videocall WHERE vcid = $id";

if (mysqli_query($conn, $sql)) {
    echo 1;
} else echo $conn->error;
