<?php
session_start();
include('../../php/db_config.php');

$target_dir = "../../assets/images/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));




if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    echo "The file " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " has been uploaded.";


    $sql = "UPDATE usertbl SET imagefile = '" . $_FILES["fileToUpload"]["name"] . "' WHERE userID = " . $_SESSION['user']['userID'];
    mysqli_query($conn, $sql);

    $_SESSION['user'] = mysqli_query($conn, "SELECT * FROM usertbl WHERE userID =" . $_SESSION['user']['userID'])->fetch_assoc();

    header("Location: ../account.php");
} else {
    echo "Sorry, there was an error uploading your file.";
}
