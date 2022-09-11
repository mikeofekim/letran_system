<?php
session_start();
include('../../php/db_config.php');
date_default_timezone_set("Asia/Manila");
$myid = $_SESSION['userdata']['userAccountID'];
$conid = $_POST['conid'];
$doc = $_POST['doc'];
$message = nl2br(htmlspecialchars($_POST['message'], ENT_QUOTES));
$date = date('Y-m-d H:i:s');

$sql = "SELECT * FROM  consultations  WHERE consultationID = $conid";
$cons = mysqli_query($conn, $sql)->fetch_assoc();

if ($cons['status'] == 1) {
    $sql = "INSERT INTO messages VALUES(null, $conid, $doc, $myid, '$message',0, '$date' )";
    if (mysqli_query($conn, $sql)) {
        echo 1;
    } else echo $conn->error;
} else echo 2;
