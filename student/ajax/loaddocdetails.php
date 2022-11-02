<?php
session_start();
include('../../php/db_config.php');
$id = $_POST['id'];

$sql = "SELECT * FROM doctortbl WHERE doctorID = $id";
$result = mysqli_query($conn, $sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();




?>



    <div class="text-center mb-4">
        <img src="../assets/images/<?= $row['imagefile'] ?>" class="shadow round" height="100" alt="">

    </div>
    <div class="card round-2 ">

        <div class="card-body">
            <div class="smallTxt fw-bold">Name</div>
            <div class="h6"><?= $row['firstName'] . ' ' . $row['lastName'] ?></div>
            <div class="smallTxt fw-bold">Specialization</div>
            <div class="h6"><?= $row['specialization'] ?></div>
            <div class="smallTxt fw-bold">Hospital/Clinic</div>
            <div class="h6"><?= $row['hospital'] ?></div>
            <div class="smallTxt fw-bold">Email</div>
            <div class="h6"><?= $row['email'] ?></div>
            <div class="smallTxt fw-bold">Contact</div>
            <div class="h6"><?= $row['contact'] ?></div>


        </div>
    </div>

<?php

}
?>