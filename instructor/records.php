<?php
session_start();
include('../php/db_config.php');
if (isset($_SESSION['userType'])) {
    if ($_SESSION['userType'] != 2) {
        header('Location: ../login.php');
    }
} else {
    header('Location: ../login.php');
}

$user = $_SESSION['user'];
$userdata = $_SESSION['userdata']
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" href="../favicon.ico" type="image/x-icon">
    <link rel="icon" href="../favicon.ico" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">



    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet" />

    <link rel="stylesheet" href="../css/style.css" />

    <title>iConsult | Account</title>
    <style>
        .mycard {
            height: calc(100vh - 95px);
        }
    </style>
</head>

<body>
    <div class="container-fluid p-0">
        <?php include('components/navbar.php') ?>
        <div class="row m-0">
            <?php include('components/sidebar.php') ?>
            <div class="col-md-9 col-sm-12 col-12">
                <div class="vh-100 py-3">
                    <div class="p-3">
                        <div class="h4 fw-bolder mb-3">Records</div>



                        <div class="card mycard round-2" id="rightpanel">
                            <div class="card-body">
                                <form action="" method="get">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <div class="w-100 me-3">
                                            <input type="text" name="search" class="form-control" value="<?= (isset($_GET['search'])) ? $_GET['search'] : "" ?>" placeholder="Search patient">
                                            <input type="submit" class="d-none">
                                        </div>

                                        <div>

                                            <i class="fas fa-search text-primary"></i>


                                        </div>
                                    </div>

                                </form>

                                <?php

                                $sql = "SELECT DISTINCT(a.patientID) FROM  consultations a  WHERE a.status != 0 AND doctorID = " . $userdata['userAccountID'];

                                $result = mysqli_query($conn, $sql);
                                // echo $result->num_rows;
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {

                                        $sql = "SELECT * FROM useraccount a INNER JOIN usertbl b ON a.linkedAccount = b.userID WHERE userAccountiD = " . $row['patientID'];
                                        $patient = mysqli_query($conn, $sql)->fetch_assoc();

                                        if (isset($_GET['search']) && $_GET['search'] != "") {
                                            if ((preg_match("/^" . strtolower($_GET['search']) . "/", strtolower($patient['firstName'])) == 0) && (preg_match("/^" . strtolower($_GET['search']) . "/", strtolower($patient['lastName'])) == 0)) {
                                                continue;
                                            }
                                        } else {
                                        }



                                        $sql = "SELECT * FROM finalized a INNER JOIN consultations b ON a.consultationID = b.consultationID WHERE b.patientID = " . $row['patientID'];

                                        $res = mysqli_query($conn, $sql);

                                ?>

                                        <div class="accordion-item mb-2 shadow-sm">
                                            <h2 class="accordion-header" id="flush-heading<?= $row['patientID'] ?>">
                                                <div class="d-flex justify-content-between px-3 py-1 pe-2">
                                                    <div class="d-flex flex-column flex-md-row justify-content-start align-items-start align-items-md-center">
                                                        <div class="text-end">
                                                            <img src="../assets/images/<?= $patient['imagefile'] ?>" class="round me-2 " height="35" width="35" alt="">
                                                        </div>

                                                        <div>
                                                            <div class="h6 mb-0">
                                                                <?= $patient['lastName'] . ", " . $patient['firstName'] ?>
                                                            </div>
                                                            <div class="smallTxt text-muted"><?= $patient['phonenumber'] ?></div>
                                                        </div>


                                                    </div>
                                                    <div>
                                                        <div class="d-flex flex-column flex-md-row align-items-center">
                                                            <div class="smallTxt mb-0"><?= $res->num_rows ?> record/s</div>
                                                            <div>
                                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse<?= $row['patientID'] ?>" aria-expanded="false" aria-controls="flush-collapse<?= $row['patientID'] ?>">


                                                                </button>
                                                            </div>

                                                        </div>

                                                    </div>
                                                </div>

                                            </h2>
                                            <div id="flush-collapse<?= $row['patientID'] ?>" class="accordion-collapse collapse" aria-labelledby="flush-heading<?= $row['patientID'] ?>" data-bs-parent="#accordionFlushExample">
                                                <div class="accordion-body pt-0">
                                                    <div class="table-responsive">
                                                        <table class="table table-sm">
                                                            <thead>
                                                                <tr valign="top">
                                                                    <th scope="col" class="smallTxt">Consultation ID</th>

                                                                    <th scope="col" class="smallTxt">Date Start</th>
                                                                    <th scope="col" class="smallTxt">Date Finalized</th>
                                                                    <th scope="col" class="smallTxt"></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php


                                                                if ($res->num_rows > 0) {
                                                                    while ($row1 = $res->fetch_assoc()) {
                                                                        // Creating new date format from that timestamp
                                                                        $start_date = $row1['date'];
                                                                        $end_date = $row1['date_final'];
                                                                        // Creating timestamp from given date
                                                                        $timestamp = strtotime($start_date);

                                                                        // Creating new date format from that timestamp
                                                                        $date = date("M d, h:sa", $timestamp);
                                                                        // Creating timestamp from given date
                                                                        $timestamp = strtotime($end_date);

                                                                        // Creating new date format from that timestamp
                                                                        $date_final = date("M d, h:sa", $timestamp);

                                                                        echo '  <tr valign="middle">
                                                                        <th scope="row" class="smallTxt">#' . $row1['code'] . '</th>
                                                                        <td class="smallTxt">' . $date . '</td>
                                                                        <td class="smallTxt">' . $date_final . '</td>
                                                                        <td class="smallTxt">  <button class="btn btn-light py-2 smallTxt text-primary round-2 fw-bold me-1" onclick="viewfinal(\'' . $row1['symptoms'] . '\',\'' . $row1['diagnosis'] . '\',\'' . $row1['recommendation'] . '\', \'' . $row1['code'] . '\')">View</button></td>
                                                                    </tr>';
                                                                    }
                                                                }



                                                                ?>


                                                            </tbody>
                                                        </table>
                                                    </div>


                                                </div>
                                            </div>
                                        </div>
                                <?php
                                    }
                                }



                                ?>

                                <div class="accordion accordion-flush" id="accordionFlushExample">
                                    <?php

                                    $sql = "SELECT * FROM finalized";

                                    // $sql = "SELECT * FROM finalized a INNER JOIN consultations b ON a. consultationID = b.consultationID INNER JOIN useraccount c ON b.patientID = c.userAccountID INNER JOIN usertbl d ON c.linkedAccount = d.userID WHERE b.doctorID = " . $userdata['userAccountID'];
                                    // echo $sql;
                                    $result = mysqli_query($conn, $sql);
                                    // echo $result->num_rows;
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
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

    <!-- Button trigger modal -->
    <button type="button" id="openmodal" class="btn btn-primary d-none" data-bs-toggle="modal" data-bs-target="#exampleModal">
        Launch demo modal
    </button>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Consultation #<span id="v_code"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="smallTxt">Symptoms</div>
                    <div class="h6" id="v_symptoms"></div>
                    <div class="smallTxt">Diagnosis</div>
                    <div class="h6" id="v_diagnosis"></div>
                    <div class="smallTxt">Recommendations</div>
                    <div class="h6" id="v_recommendation"></div>

                </div>

            </div>
        </div>
    </div>


    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8" crossorigin="anonymous"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <script>
        $(document).ready(function() {
            $('#table_id').DataTable();
        });
        $("#navrecord").addClass("bg-info text-white shadow");

        window.addEventListener('resize', updateScreen);

        function updateScreen() {
            if (window.innerWidth < 600) {
                $("#rightpanel").removeClass('mycard');
            } else {
                $("#rightpanel").addClass('mycard');
            }
        }


        function viewfinal(a, b, c, e) {
            $("#v_symptoms").text(a);
            $("#v_diagnosis").text(b);
            $("#v_recommendation").text(c);
            $("#v_code").text(e);
            $("#openmodal").click();
        }
    </script>
</body>

</html>