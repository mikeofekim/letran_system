<?php
session_start();
include('../php/db_config.php');

if (isset($_SESSION['userType'])) {
    if ($_SESSION['userType'] != 3) {
        header('Location: ../login.php');
    }
} else {
    header('Location: ../login.php');
}
$id = $_GET['id'];
$sql = "SELECT * FROM diagnosis WHERE id = $id";
$result = mysqli_query($conn, $sql);

if ($result->num_rows > 0) {
    $diagnosis = $result->fetch_assoc();
} else {
    header('Location: check.php');
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" href="../favicon.ico" type="image/x-icon">
    <link rel="icon" href="../favicon.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../css/style.css" />

    <title>iConsult | Check Health</title>
</head>

<body>
    <div class="container-fluid p-0">
        <?php include('components/navbar.php') ?>
        <div class="row m-0">
            <?php include('components/sidebar.php') ?>
            <div class="col-md-9 col-sm-12 col-12">
                <div class="vh-100 py-3">
                    <div class="p-3">
                        <div class="h4 fw-bolder"><a href="check.php"><i class="fas fa-angle-left"></i></a> History</div>
                        <div class="row">

                            <div class="col-md-6">
                                <div class="card bg-white round-1 border-0 shadow-sm">
                                    <div class="card-body">
                                        <div class="h6 fw-bold mb-3 text-primary">Details</div>
                                        <div class="p-3 round-2 bg-light mb-3">
                                            <div class="smallTxt fw-bold text-muted">Date & Time</div>
                                            <div class="h6"><?= $diagnosis['date'] ?></div>
                                            <div class="smallTxt fw-bold text-muted">Symptoms</div>
                                            <div class="h6 mb-0">
                                                <ul class="mb-0"><?php
                                                                    $symp = json_decode($diagnosis['symptoms']);
                                                                    foreach ($symp as $s) {
                                                                        $sql = "SELECT * FROM symptoms WHERE symptomID =$s";
                                                                        $result = mysqli_query($conn, $sql)->fetch_assoc();
                                                                        echo "<li>" . $result['name'] . "</li>";
                                                                    }
                                                                    ?>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="h6 fw-bold mb-3 text-primary">Result</div>
                                        <div class="">
                                            <?php
                                            $output = json_decode($diagnosis['result']);
                                            if (count($output) != 0) {
                                                $count = 0;
                                                foreach ($output as $row) {
                                                    if ($count == 3) break;
                                                    $obj1 = $row->Issue;
                                                    $obj2 = $row->Specialisation; ?>

                                                    <div class="card round-1 bg-light border-0 mb-3">
                                                        <div class="card-body">
                                                            <a href="view.php?id=<?= $obj1->ID ?>" class="float-end text-decoration-none">View</a>
                                                            <div class="d-flex">
                                                                <div class="me-3">
                                                                    <div class="d-flex align-items-center justify-content-center round-2 shadow-2 " style=" width: 50px; height: 50px; border: 3px solid ">
                                                                        <div class="h4 mb-0"><?= ++$count ?></div>
                                                                    </div>
                                                                </div>
                                                                <div>
                                                                    <div class="h6 fw-bold mb-0">
                                                                        <?= $obj1->Name ?>
                                                                    </div>
                                                                    <!-- <div class="h6 mb-3">
                                                                    <?= $obj1->IcdName ?>
                                                                </div> -->
                                                                    <div class="smallTxt text-muted">
                                                                        Recommended Specialist:
                                                                    </div>
                                                                    <?php
                                                                    echo $obj2[0]->Name
                                                                        . "<br />"; ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                            <?php

                                                }
                                            } else {
                                                echo 'Nothing to show, please click next.';
                                            }

                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card border-0 round-1 ">

                                    <div class="card-body">
                                        <div class="h6">Recommended Doctor:</div>
                                        <?php
                                        $docs = explode(",", $diagnosis['doctor']);

                                        for ($x = 0; $x < count($docs); $x++) {
                                            $sql = "SELECT * FROM  useraccount a Inner JOIN doctortbl b ON a.linkedAccount = b.doctorID WHERE a.userAccountID = '$docs[$x]'";
                                            $result = mysqli_query($conn, $sql);
                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {

                                        ?>
                                                    <div class="d-flex p-3 border round-1 align-items-center  mb-2 ">
                                                        <div class="me-3">
                                                            <img src="../assets/images/profiledefault.png" height="40" alt="" />
                                                        </div>
                                                        <div class="">

                                                            <div class="h6 fw-bold mb-0">Dr. <?= $row['firstName'] . " " . $row['lastName'] ?> </div>
                                                            <div class="smallTxt mb-0"><?= $row['specialization'] ?></div>
                                                        </div>
                                                        <div class="ms-auto align-self-start"><a class="text-primary" style="cursor: pointer" onclick="sendRequest(<?= $row['userAccountID'] ?>)"><i class="far fa-paper-plane"></i></a></div>

                                                    </div>
                                        <?php
                                                }
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $("#navcheck").addClass("bg-info text-white shadow");
        $("#mySymptoms").load("../ajax/loadMySymptoms.php");




        function sendRequest(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "Request for Consultation",
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.isConfirmed) {


                    $.post('ajax/sendrequest.php', {
                        id: id
                    }, function(data) {
                        if (data == 1) {
                            Swal.fire(
                                'Sent!',
                                'Your request has been submitted.',
                                'success'
                            );
                        }
                        if (data == 0) {
                            Swal.fire(
                                'Oops!',
                                'You still have active request/consultation.',
                                'warning'
                            );
                        }
                    });
                }
            })
        }
    </script>
</body>

</html>