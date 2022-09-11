<?php
session_start();
include('../../php/db_config.php');
date_default_timezone_set("Asia/Manila");
$arr = [];
$filter_month = $_POST['month'];
$filter_year = $_POST['year'];


$sql = "SELECT * FROM diagnosis a INNER JOIN usertbl b ON a.userid = b.userID";
$result = mysqli_query($conn, $sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {

        $dateOfBirth = $row['birthday'];
        $today = date("Y-m-d");
        $diff = date_diff(date_create($dateOfBirth), date_create($today));
        $age = $diff->format('%d');


        $dateValue = strtotime($row['date']);

        $month = date("m", $dateValue);
        $y = date("Y", $dateValue);
        // echo $age;
        if (($month == $filter_month)  && ($y == $filter_year || $filter_year == '')) {
            $symptoms = json_decode($row['symptoms']);

            foreach ($symptoms as $symp) {
                array_push($arr, $symp);
            }
            // echo 1;
        }
    }

    $arr = array_count_values($arr);
    arsort($arr);
    $keys = array_keys($arr);
    $values = array_values($arr);
    $all = [];
    for ($x = 0; $x < count($keys); $x++) {
        array_push($all, array($keys[$x], $values[$x]));
    }



    $names = [];
    $count = [];
    for ($x = 0; $x < count($all); $x++) {
        if ($x == 10) break;
        $sql = "SELECT * FROM symptoms WHERE symptomID =" . $all[$x][0];
        $res = mysqli_query($conn, $sql);

        $result = $res->fetch_assoc();
        array_push($names, $result['name']);
        array_push($count, $all[$x][1]);
    }
    exit(json_encode(array($names, $count)));
}
