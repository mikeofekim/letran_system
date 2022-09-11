<?php
session_start();
include('../php/db_config.php');


$array = $_SESSION['symptoms'];

if (count($array) != 0) {
    for ($x = 0; $x < count($array); $x++) {
        echo '<div class="p-3 bg-light round-2 mb-2">
        <div class="h6 mb-0">' . $array[$x][1] . '<a onclick="deleteSymptom(' . $x . ')" class="float-end"><i class="fas fa-times"></i></a></div></div>';
    }
}
