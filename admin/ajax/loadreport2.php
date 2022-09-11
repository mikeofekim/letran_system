<?php
session_start();
include('../../php/db_config.php');

$arr = [];
$filter_month = $_POST['month'];
$filter_year = $_POST['year'];
// 
// if ($filter_age == 1) {
//     $min = 18;
//     $max = 25;
// } else if ($filter_age == 2) {
//     $min = 26;
//     $max = 40;
// } else if ($filter_age == 3) {
//     $min = 41;
//     $max = 60;
// } else {
//     $min = 18;
//     $max = 60;
// }
$sql = "SELECT * FROM diagnosis a INNER JOIN usertbl b ON a.userid = b.userID";
$result = mysqli_query($conn, $sql);

if ($result->num_rows > 0) {
    $test = [];
    while ($row = $result->fetch_assoc()) {

        $dateOfBirth = $row['birthday'];
        $today = date("Y-m-d");
        $diff = date_diff(date_create($dateOfBirth), date_create($today));
        $age = $diff->format('%y');


        $dateValue = strtotime($row['date']);

        $month = date("m", $dateValue);
        $y = date("Y", $dateValue);
        if (($month == $filter_month  || $filter_month == 0) && ($y == $filter_year || $filter_year == '')) {
            $diagnosis = json_decode($row['result']);
            $c = 0;
            foreach ($diagnosis as $item) {
                array_push($arr, $item->Issue->ID);
                if (!array_key_exists("'" . strval($item->Issue->ID) . "'", $test)) {
                    $test["'" . strval($item->Issue->ID) . "'"] = array(0, 0, array(0, 0, 0, 0, 0, 0), array(0, 0, 0));
                }
                if ($row['gender'] == 0) {
                    $test["'" . strval($item->Issue->ID) . "'"][0] =   $test["'" . strval($item->Issue->ID) . "'"][0] + 1;
                } else {
                    $test["'" . strval($item->Issue->ID) . "'"][1] =   $test["'" . strval($item->Issue->ID) . "'"][1] + 1;
                }




                if ($age >= 18 && $age <= 25) {
                    $test["'" . strval($item->Issue->ID) . "'"][3][0]++;
                } else if ($age >= 26 && $age <= 40) {
                    $test["'" . strval($item->Issue->ID) . "'"][3][1]++;
                } else if ($age >= 41 && $age <= 60) {
                    $test["'" . strval($item->Issue->ID) . "'"][3][2]++;
                }


                $c++;
                if ($c == 1) break;
            }
        }
    }

    // print_r($arr);

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
    $sex1 = [];
    $sex2 = [];


    $age1 = [];
    $age2 = [];
    $age3 = [];
    for ($x = 0; $x < count($all); $x++) {
        if ($x == 10) break;
        $sql = "SELECT * FROM healthissues WHERE issueID =" . $all[$x][0];
        $result = mysqli_query($conn, $sql)->fetch_assoc();
        array_push($names, $result['issueName']);
        array_push($count, $all[$x][1]);

        $total =  $test["'" . $all[$x][0] . "'"][0] +  $test["'" . $all[$x][0] . "'"][1];
        array_push($sex1, $test["'" . $all[$x][0] . "'"][0] / $total * 100);
        array_push($sex2, $test["'" . $all[$x][0] . "'"][1] / $total * 100);


        array_push($age1, $test["'" . $all[$x][0] . "'"][3][0]);
        array_push($age2, $test["'" . $all[$x][0] . "'"][3][1]);
        array_push($age3, $test["'" . $all[$x][0] . "'"][3][2]);
    }
    exit(json_encode(array($names, $count, $sex1, $sex2, $age1, $age2, $age3)));
}
