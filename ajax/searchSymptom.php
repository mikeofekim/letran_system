<?php
session_start();
include('../php/db_config.php');


if ($_SESSION['user']['gender'] == 0) {
    $gender = 0;
} else {
    $gender = 3;
}
$search = $conn->real_escape_string($_POST['search']);
if ($search != "") {
    $sql = "SELECT * FROM symptoms WHERE (`name` LIKE '%$search%' OR `synonyms` LIKE '%$search%')  AND gender = $gender LIMIT 7";

    $result = mysqli_query($conn, $sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '  <li class="list-group-item"><div class="mb-0 h6">' . $row['name'] . "</div><span class='smallTxt text-muted'>" . $row['synonyms'] . '</span><a style="cursor: pointer" onclick="addSymptom(\'' . $row['symptomID'] . '\',\'' . $row['name'] . '\')" class="float-end"><i class="fas fa-plus-circle"></i></span></a>';
        }
    }
} else {
    echo "";
}


function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
