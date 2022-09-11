<?php
session_start();
include('../../php/db_config.php');

$userID = $_SESSION['userid'];
$userdata = $_SESSION['userdata'];
$edittype = $_POST['edittype'];
$newtext = $_POST['newtext'];

if ($edittype == 'username') {
    $sql = "UPDATE useraccount SET `$edittype` = '$newtext' WHERE userAccountID = " . $userdata['userAccountID'];
    mysqli_query($conn, $sql);
    $_SESSION['userdata'] = mysqli_query($conn, "SELECT * FROM useraccount WHERE userAccountID=" . $userdata['userAccountID'])->fetch_assoc();
} else if ($edittype == 'password') {
    $newtext = md5($newtext);
    $oldpass = $userdata['password'];
    $inputoldpass = md5($_POST['oldpass']);
    if ($oldpass == $inputoldpass) {
        $sql = "UPDATE useraccount SET `password` = '$newtext' WHERE userAccountID = " . $userdata['userAccountID'];
        mysqli_query($conn, $sql);
        $_SESSION['userdata'] = mysqli_query($conn, "SELECT * FROM useraccount WHERE userAccountID=" . $userdata['userAccountID'])->fetch_assoc();
        echo 1;
    } else echo 0;
}
