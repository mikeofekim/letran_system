<?php
session_start();
include('../php/db_config.php');

$id = $_POST['id'];
$array = $_SESSION['symptoms'];


array_splice($array, $id, 1);
$_SESSION['symptoms'] = $array;
