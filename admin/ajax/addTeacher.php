<?php
session_start();
include('../../php/db_config.php');

$fname = $conn->real_escape_string($_POST['fname']);
$mname = $conn->real_escape_string($_POST['mname']);
$lname = $conn->real_escape_string($_POST['lname']);

$address = $conn->real_escape_string($_POST['address']);
$email = $conn->real_escape_string($_POST['email']);
$contact = $conn->real_escape_string($_POST['contact']);

$license = $conn->real_escape_string($_POST['license']);
$sp = $conn->real_escape_string($_POST['sp']);
$hospital = $conn->real_escape_string($_POST['hospital']);
$h_address = $conn->real_escape_string($_POST['h_address']);


$sql = "INSERT INTO `teachers`(`firstName`, `middleName`, `lastName`,  `specialization`, `address`, `email`, `contact`, `license`, `hospital`, `h_address`, `imagefile`, `gender`) VALUES ('$fname','$mname','$lname','$sp','$address','$email','$contact','$license','$hospital','$h_address', 'default.jpg', 0)";

if (mysqli_query($conn, $sql)) {
    $last_id = $conn->insert_id;
    $username = 'new_user' . rand(1000, 9999);
    $password = md5('12345678');
    $sql = "INSERT INTO `useraccount`(`username`, `password`, `userType`, `linkedAccount`, `a_status`) VALUES ('$username','$password',2,$last_id, 1)";
    mysqli_query($conn, $sql);
    echo 1;
} else {
    echo $conn->error;
}
