<?php
session_start();
include('../../php/db_config.php');


$id = $_POST['id'];

$sql = "DELETE FROM consultations WHERE consultationID = $id";
if (mysqli_query($conn, $sql)) {
    echo 1;
} else {
    echo 0;
}
