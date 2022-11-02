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
$id = $_SESSION['user']['userID'];
$_SESSION['symptoms'] = [];



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

    <title>iConsult | Terms of Service</title>
</head>

<body>
    <div class="container-fluid p-0">
        <?php include('components/navbar.php') ?>
        <div class="row m-0">
            <?php include('components/sidebar.php') ?>
            <div class="col-md-9 col-sm-12 col-12">
                <div class="vh-100 py-3">
                    <div class="p-3">
                        <div class="h4 fw-bolder">Check Health</div>

                        <div class="p-2 round-1 bg-light text-dark shadow-sm mb-4">
                            <div class="d-flex align-items-center">
                                <div class="h6 mb-0 py-2 px-3 bg-info round-1 text-white">
                                    1
                                </div>
                                <div class="h6 mb-0 py-2 px-3 me-2">Terms of Service</div>
                                <div class="h6 mb-0 py-2 px-3 bg-light round-1 text-muted me-2">
                                    2
                                </div>
                                <div class="h6 mb-0 py-2 px-3 bg-light round-1 text-muted me-2">
                                    3
                                </div>
                                <div class="h6 mb-0 py-2 px-3 bg-light round-1 text-muted me-2">
                                    4
                                </div>
                            </div>
                        </div>
                        <div class="d-flex flex-column flex-sm-colum flex-md-row">
                            <div class="text-center mx-5">
                                <img src="../assets/images/tos.jpg" height="300" alt="" />
                            </div>
                            <div class="mt-5 bg-light p-3 round-2">
                                <div class="h4 fw-bold">Terms of Service</div>

                                <div class="h6 mb-4">
                                    Before checking your health, please read Terms of Service.
                                    <br />Remember that:
                                </div>

                                <ul>
                                    <li>
                                        <b>Checkup is not a diagnosis.</b> Checkup is for informational purposes and is not a qualified medical opinion.
                                    </li>
                                    <li>
                                        <b>Do not use in emergencies.</b> In case of health emergency, call your local emergency number immediately.
                                    </li>
                                    <li>
                                        <b>Your data is safe.</b> Information that you provide is anonymous and not shared with anyone.
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="text-end mt-4">
                            <a href="2.php" class="btn btn-primary">Accept </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script>
        $("#navcheck").addClass("bg-info text-white shadow");
        $("#mySymptoms").load("../ajax/loadMySymptoms.php");
    </script>
</body>

</html>