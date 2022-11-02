<?php
session_start();
include('../../php/db_config.php');

$key = $_POST['keyword'];

if ($key != "") {
    $sql = "SELECT * FROM issues WHERE isdisplayed = 0 AND name LIKE '%" . $key . "%' ORDER BY name";
} else {
    $sql = "SELECT * FROM issues WHERE isdisplayed = 0 AND name LIKE 'a%' ORDER BY name";
}

$result = mysqli_query($conn, $sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<div class="col-md-4 "><div class=" bg-light round-2 p-3 mb-3 issues shadow-sm" style="height: 100px" onclick="window.location.href=\'view.php?id=' . $row['id'] . '\'">';
        echo "<div class='h6 text-truncate'>" . $row['name'] . " <i class='fas fa-angle-right'></i></div><div class='form-text'>Learn more about <span class='text-lowercase'>" . $row['name'] . "</span> symptoms & treatments</div></div></div>";
    }
}
