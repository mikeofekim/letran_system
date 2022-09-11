<?php
session_start();
include('../../php/db_config.php');

$keyword = $_POST['keyword'];
$sql = "SELECT * FROM doctortbl";

if ($keyword != "") {
    $sql = "SELECT * FROM doctortbl WHERE license LIKE '$keyword%' OR specialization LIKE '$keyword%' OR firstName LIKE '$keyword%' OR lastName LIKE '$keyword%'";
}
$result = mysqli_query($conn, $sql);


?>

<div class="smallTxt">Displaying <?= $result->num_rows ?> result/s</div>
<table class="table table-borderless">
    <thead>
        <tr class="bg-light">
            <th scope="col" class="pd">#</th>
            <th scope="col" class="pd">Doctor License #</th>
            <th scope="col" class="pd">Name</th>
            <th scope="col" class="pd">Specialization</th>
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
                    <td class="pd"><?= $row['license'] ?></td>
                    <td class="pd text-nowrap">Dr. <?= $row['lastName'] . ', ' . $row['firstName'] . " " . $row['middleName']  ?></td>

                    <td class="pd text-nowrap"><?= $row['specialization'] ?></td>
                    <td class="pd text-nowrap"><button class="btn btn-sm btn-light text-danger me-2 round-1" onclick="deleteDoc(<?= $row['doctorID'] ?>)"><i class="fas fa-user-times"></i></button>
                        <a href="viewdoc.php?4762387523=<?= $row['doctorID'] ?>" class="btn btn-sm btn-primary round-1 px-3 fw-bold">View</a>
                    </td>
                </tr>
        <?php
            }
        }

        ?>


    </tbody>
</table>