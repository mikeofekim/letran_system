<?php
session_start();
include('../../php/db_config.php');
$id = $_SESSION['user']['userID'];
$_SESSION['symptoms'] = [];


$sql = "SELECT * FROM diagnosis WHERE userID = $id ORDER BY id DESC";
$result = mysqli_query($conn, $sql);
$isGood = 0;
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $date = date("Y-m-d", strtotime($row['date']));
        if ($date == date('Y-m-d')) {
            $isGood = 1;
            break;
        } else {
            continue;
        }
    }
}

echo $isGood;
