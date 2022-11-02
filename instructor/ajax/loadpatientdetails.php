<?php
session_start();
include('../../php/db_config.php');
$id = $_POST['id'];

$sql = "SELECT * FROM usertbl WHERE userID = $id";
$result = mysqli_query($conn, $sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();




?>



    <div class="text-center mb-4">
        <img src="../assets/images/<?= $row['imagefile'] ?>" height="100" width="100" alt="" class="shadow round">

    </div>
    <div class="card round-2 ">

        <div class="card-body">
            <div class="smallTxt fw-bold">Name</div>
            <div class="h6"><?= $row['firstName'] . ' ' . $row['lastName'] ?></div>
            <div class="smallTxt fw-bold">Brithday</div>
            <div class="h6"><?= $row['birthday'] ?></div>
            <div class="smallTxt fw-bold">Gender</div>
            <div class="h6"><?= ($row['gender'] == 0) ? "Male" : "Female" ?></div>
            <div class="smallTxt fw-bold">Email</div>
            <div class="h6"><?= $row['email'] ?></div>
            <div class="smallTxt fw-bold">Contact</div>
            <div class="h6"><?= $row['phonenumber'] ?></div>

            <div class="smallTxt fw-bold">Address</div>
            <div class="h6"><?= $row['muncity'] . ', ' . $row['province'] ?></div>
        </div>
    </div>

<?php

}
?>