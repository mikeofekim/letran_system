<?php
session_start();
include('../../php/db_config.php');
date_default_timezone_set("Asia/Manila");
$myid = $_SESSION['userdata']['userAccountID'];
$conid = $_POST['conid'];
$doc = $_POST['doc'];

$token = bin2hex(random_bytes(32));
$message = '<i class="fas fa-video"></i> Meeting started. 
        <div class="round-2 mt-1 p-2 bg-warning text-center"><a href="video-call.php?token=' . $token . '" class="text-white text-decoration-none smallTxt fw-bold fst-italic" target="_blank">Click to join <i class="fas fa-sign-in-alt"></i></a></div>';
$date = date('Y-m-d H:i:s');

$sql = "SELECT * FROM  consultations  WHERE consultationID = $conid";
$cons = mysqli_query($conn, $sql)->fetch_assoc();

if ($cons['status'] == 1) {
    $pass = rand(10000000, 99999999);
    $sql = "INSERT INTO videocall VALUES(null, $conid, '$token', '$pass')";
    mysqli_query($conn, $sql);
    $sql = "INSERT INTO messages VALUES(null, $conid, $doc, $myid, '$message', 0,'$date' )";
    if (mysqli_query($conn, $sql)) {
        echo 1;
    } else echo $conn->error;
} else echo 2;
