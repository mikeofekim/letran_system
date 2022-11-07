<?php
session_start();
include('../../php/db_config.php');
$id = $_POST['id'];
$status = $_POST['status'];

$sql = "UPDATE useraccount SET a_status = $status WHERE userAccountID = $id";

if (mysqli_query($conn, $sql)) {
    echo 1;
} else {
    echo $conn->error;
}
