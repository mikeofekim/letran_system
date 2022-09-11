<?php
session_start();
include('../../php/db_config.php');
date_default_timezone_set("Asia/Manila");

$filter_month = $_POST['month'];
$filter_year = $_POST['year'];
$count1 = 0;
$count2 = 0;
$date = $filter_year . "-" . $filter_month;

$sql = "SELECT id, date FROM diagnosis";

$result = mysqli_query($conn, $sql);


if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {

        $dateValue = strtotime($row['date']);

        $month = date("m", $dateValue);
        $y = date("Y", $dateValue);
        if (($filter_year == $y || $filter_year == "") && ($filter_month == $month || $filter_month == 0)) {
            $count1++;
        }
    }
}



$sql = "SELECT consultationID, date FROM consultations ";
$result = mysqli_query($conn, $sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {

        $dateValue = strtotime($row['date']);

        $month = date("m", $dateValue);
        $y = date("Y", $dateValue);
        if (($filter_year == $y || $filter_year == "") && ($filter_month == $month || $filter_month == 0)) {
            $count2++;
        }
    }
}
exit(json_encode(array($count1, $count2)));
