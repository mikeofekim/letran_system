<?php
session_start();
include('../php/db_config.php');
date_default_timezone_set("Asia/Manila");
$arr = [];


$campuses = [array("Alaminos", 0), array("Asingan", 0), array("Bayambang", 0), array("Binmaley", 0), array("Infanta", 0), array("Lingayen", 0), array("San Carlos", 0), array("Sta Maria", 0), array("Urdaneta", 0)];

$row = 1;
if (($handle = fopen("../test.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $num = count($data);
        $row++;
        if ($row == 2) continue;


        for ($x = 0; $x < count($campuses); $x++) {
            if ($campuses[$x][0] == $data[1]) {
                $campuses[$x][1]++;
                break;
            } else {
            }
        }
    }
    fclose($handle);
}


// exit(json_encode(array($names, $count)));
$campus_name = [];
$cases = [];
foreach ($campuses as $campus) {
    array_push($campus_name, $campus[0]);
    array_push($cases, $campus[1]);
}


exit(json_encode(array($campus_name, $cases)));
