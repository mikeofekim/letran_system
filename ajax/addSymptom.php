<?php
session_start();
include('../php/db_config.php');


$id = $_POST['id'];
$name = $_POST['name'];
$array = $_SESSION['symptoms'];
$isExist = 0;
foreach ($array as $ar) {
    if ($id == $ar[0]) {
        $isExist = 1;
        break;
    }
}

if ($isExist == 0) {
    array_push($array, array($id, $name));
    $_SESSION['symptoms'] = $array;
}

echo $isExist;
