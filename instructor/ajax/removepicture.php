<?php
session_start();
include('../../php/db_config.php');


$id = $_SESSION['user']['doctorID'];

$sql = "UPDATE doctortbl SET imagefile = 'default.jpg' WHERE doctorID = $id";
if (mysqli_query($conn, $sql)) {

    unlink('../../assets/images/' . $_SESSION['user']['imagefile']);
    $_SESSION['user'] = mysqli_query($conn, "SELECT * FROM doctortbl WHERE doctorID =" . $_SESSION['user']['doctorID'])->fetch_assoc();
    mysqli_query($conn, $sql);
} else {
}
