<?php
session_start();
include('../../php/db_config.php');


$fname = $conn->real_escape_string($_POST['firstname']);
$mname = $conn->real_escape_string($_POST['middlename']);
$lname = $conn->real_escape_string($_POST['lastname']);
$bd = $_POST['birthday'];
$gender = $_POST['gender'];

$course = $_POST['course'];
$year = $_POST['year'];
$school_id = $_POST['school_id'];



$username =  $conn->real_escape_string($_POST['username']);
$password =  md5($conn->real_escape_string($_POST['password']));


$dateOfBirth = $bd;
$today = date("Y-m-d");
$diff = date_diff(date_create($dateOfBirth), date_create($today));
$age = $diff->format('%Y');


$sql = "INSERT INTO `usertbl`( `firstName`, `middleName`, `lastName`, `birthday`, `gender`, `course`, `year`, `school_id`, `imagefile`) VALUES ('$fname','$mname','$lname','$bd','$gender','$course','$year','$school_id', 'default.jpg')";

mysqli_query($conn, $sql);
$last_id = $conn->insert_id;
$sql = "INSERT INTO `useraccount`( `username`, `password`, `userType`, `linkedAccount`, `a_status`) VALUES ('$username','$password',3,$last_id, 1)";
mysqli_query($conn, $sql);
echo $conn->error;

echo 1;