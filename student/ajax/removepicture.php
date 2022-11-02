<?php
session_start();
include('../../php/db_config.php');


$id = $_SESSION['user']['userID'];

$sql = "UPDATE usertbl SET imagefile = 'default.jpg' WHERE userID = $id";
if (mysqli_query($conn, $sql)) {

    unlink('../../assets/images/' . $_SESSION['user']['imagefile']);
    $_SESSION['user'] = mysqli_query($conn, "SELECT * FROM usertbl WHERE userID =" . $_SESSION['user']['userID'])->fetch_assoc();
    mysqli_query($conn, $sql);
} else {
}
