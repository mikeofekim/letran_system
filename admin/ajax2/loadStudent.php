<?php
session_start();
include('../../php/db_config.php');

$keyword = $_POST['keyword'];
$sql = "SELECT * FROM usertbl";

if ($keyword != "") {
    $sql = "SELECT * FROM usertbl WHERE school_id LIKE '$keyword%' OR course LIKE '$keyword%' OR firstName LIKE '$keyword%' OR lastName LIKE '$keyword%'";
}
$result = mysqli_query($conn, $sql);


?>

<div class="smallTxt">Displaying <?= $result->num_rows ?> result/s</div>
<table class="table table-borderless">
    <thead>
        <tr class="bg-light">
            <th scope="col" class="pd">#</th>
            <th scope="col" class="pd">Student ID #</th>
            <th scope="col" class="pd">Name</th>
            <th scope="col" class="pd">Course</th>
            <th scope="col" class="pd">Actions</th>
        </tr>
    </thead>
    <tbody>

        <?php

        if ($result->num_rows > 0) {
            $count = 0;
            while ($row = $result->fetch_assoc()) {
        ?>
                <tr>
                    <th scope="row" class="pd"><?= ++$count ?></th>
                    <td class="pd"><?= $row['school_id'] ?></td>
                    <td class="pd text-nowrap"> <?= $row['lastName'] . ', ' . $row['firstName'] . " " . $row['middleName']  ?></td>

                    <td class="pd text-nowrap"><?= $row['course'] ?></td>

                    <td class="pd text-nowrap"><button class="btn btn-sm btn-light text-danger me-2 round-1" onclick="deleteDoc(<?= $row['userID'] ?>)"><i class="fas fa-user-times"></i></button>
                    </td>
                </tr>
        <?php
            }
        }

        ?>


    </tbody>
</table>