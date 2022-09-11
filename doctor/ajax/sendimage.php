<?php
session_start();
include('../../php/db_config.php');

date_default_timezone_set("Asia/Manila");
$filename = $_FILES['file']['name'];

/* Location */
$location = "../../assets/uploads/" . $filename;
$imageFileType = pathinfo($location, PATHINFO_EXTENSION);
$imageFileType = strtolower($imageFileType);

/* Valid extensions */
$valid_extensions = array("jpg", "jpeg", "png");

$response = 0;
/* Check file extension */
if (in_array(strtolower($imageFileType), $valid_extensions)) {
    /* Upload file */
    if (move_uploaded_file($_FILES['file']['tmp_name'], $location)) {
        $myid = $_SESSION['userdata']['userAccountID'];
        $conid = $_POST['conid'];
        $doc = $_POST['doc'];
        $message = $filename;
        $date = date('Y-m-d H:i:s');

        $sql = "SELECT * FROM  consultations  WHERE consultationID = $conid";
        $cons = mysqli_query($conn, $sql)->fetch_assoc();

        if ($cons['status'] == 1) {
            $sql = "INSERT INTO messages VALUES(null, $conid, $doc, $myid, '$message', 1 ,'$date' )";
            if (mysqli_query($conn, $sql)) {
                echo 1;
            } else echo $conn->error;
        } else echo 2;
    }
}
