<?php
session_start();
include('../../php/db_config.php');
date_default_timezone_set("Asia/Manila");
$conid = $_POST['conid'];
$a = nl2br(htmlspecialchars($_POST['a'], ENT_QUOTES));
$b = nl2br(htmlspecialchars($_POST['b'], ENT_QUOTES));
$c = nl2br(htmlspecialchars($_POST['c'], ENT_QUOTES));
$date = date('Y-m-d H:i:s');

$sql = "INSERT INTO finalized VALUES(null, $conid, '$a', '$b', '$c' , '$date')";
if (mysqli_query($conn, $sql)) {
    echo 1;
} else echo $conn->error;
