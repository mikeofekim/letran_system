<?php
include('php/db_config.php');

$keyword = $_POST['keyword'];

$sql = "SELECT * FROM symptoms WHERE `name` LIKE '$keyword%'";
$result = mysqli_query($conn, $sql);


if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {

        echo '<a href="">' . $row['name'] . '</a><br>';
    }
}
