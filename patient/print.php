<?php
session_start();
include('../php/db_config.php');
$id = $_GET['id'];


$sql = "SELECT * FROM  finalized a INNER JOIN consultations b ON a.consultationID = b.consultationID INNER JOIN useraccount c ON b.doctorID = c.userAccountID INNER JOIN doctortbl d ON c.linkedAccount = d.doctorID WHERE a.consultationID = $id";
// echo $sql;
$result = mysqli_query($conn, $sql);

$user = $_SESSION['user'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="css/style.css" />

    <title>iConsult</title>

    <style>
        /* body {
            font-family: Arial, Helvetica, sans-serif;
        } */

        /* body {
            background-image: url("assets/images/bg.jpg");
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        } */


        .container {
            max-width: 8in;
        }

        .icon {
            width: 50px;
            height: 50px;
        }

        .box {
            min-height: 180px;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="py-4">
            <img src="../assets/images/logo.png" height="60" alt="">
        </div>
        <div class="bg px-3 border-0 fw-bold">
            <?php

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();

                $original_date = $row['date_final'];

                // Creating timestamp from given date
                $timestamp = strtotime($original_date);

                // Creating new date format from that timestamp
                $date = date("F d, Y", $timestamp);
            ?>
                <div class="card bg-light p-3 border-0">
                    <div class="h5 fw-bold text-primary">Comprehensive Consultation Report</div>

                    <div class="h6 mb-0 ">Date: <u><?= $date ?></u></div>
                    <div class="h6 ">Consultation ID: <u>#<?= $row['code'] ?></u></div>
                </div>


                <hr class="mt-4">
                <div class="h6 badge bg-light shadow-sm text-dark p-2 round-1"><i class="fas fa-info-circle"></i> Patient Information</div>
                <div class="ps-3">
                    <div class="d-flex justify-content-between">
                        <div class="h6">
                            <span class="fw-bold">Name:</span> <?= $user['lastName'] . ", " . $user['firstName'] ?>
                            <div> <span class="fw-bold">Contact:</span> <?= $user['phonenumber'] ?></div>
                        </div>
                        <div class="h6"> <span class="fw-bold">Birthday:</span> <?= $user['birthday'] ?>
                            <div> <span class="fw-bold">Address:</span> <?= $user['muncity'] . ', ' . $user['province'] . " " . $user['region'] ?></div>
                        </div>
                        <div></div>
                    </div>

                </div>

                <hr class="mt-4">
                <div class="h6 badge bg-light shadow-sm text-dark p-2 round-1"><i class="fas fa-diagnoses"></i> Symptoms</div>
                <div class="h6 bg- p-2 px-3 round-2 fst-italic" style="min-height: 50"><?= $row['symptoms'] ?></div>

                <hr class="mt-4">
                <div class="h6 badge bg-light shadow-sm text-dark p-2 round-1"><i class="fas fa-comment-medical"></i> Diagnosis</div>
                <div class="h6  bg- p-2 px-3 round-2 fst-italic" style="min-height: 50"><?= $row['diagnosis'] ?></div>

                <hr class="mt-4">
                <div class="h6 badge  bg-light shadow-sm text-dark p-2 round-1"><i class="fas fa-briefcase-medical"></i> Recommendation</div>
                <div class="h6  bg- p-2 px-3 round-2 fst-italic" style="min-height: 50"><?= $row['recommendation'] ?></div>



                <hr class="mt-5">
                <div class="h6 fw-bold ">
                    Dr. <?= $row['firstName'] . " " . $row['lastName'] ?>
                </div>
                <div class="h6 mb-0">
                    <?= $row['specialization'] ?>
                </div>
                <div class="h6 mb-0">
                    <?= $row['email'] ?>
                </div>
                <div class="h6 mb-0">
                    <?= $row['contact'] ?>
                </div>
            <?php



            }

            ?>



        </div>


    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script>
        window.print();
    </script>
</body>

</html>