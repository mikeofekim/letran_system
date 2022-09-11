<?php
$servername = "sql208.epizy.com";
$username = "epiz_29461960";
$password = "5CdAsL0mTM";
$db = "epiz_29461960_iconsult";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $db);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
