<?php
session_start();
include('../../php/db_config.php');
date_default_timezone_set("Asia/Manila");
$myid = $_SESSION['userdata']['userAccountID'];
$conid = $_POST['conid'];
$doc = $_POST['doc'];

if (isset($_POST['message'])) {
    $message = nl2br(htmlspecialchars($_POST['message'], ENT_QUOTES));
} else if (isset($_POST['notif'])) {
    $message = $_POST['notif'];
}

$date = date('Y-m-d H:i:s');

$sql = "INSERT INTO messages VALUES(null, $conid, $doc, $myid, '$message' , 0, '$date')";
if (mysqli_query($conn, $sql)) {
    echo 1;
} else echo $conn->error;
