<?php
session_start();
include('../php/db_config.php');

$username =  $conn->real_escape_string($_POST['username']);

$sss = "SELECT * FROM useraccount WHERE username = '$username'";
$res = mysqli_query($conn, $sss);
if ($res->num_rows > 0) {
    echo 1;
}
