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

    <title>iConsult | Select Symptoms</title>
</head>

<body>
    <div class="container-fluid p-0">
        <?php include('components/navbar.php') ?>
        <div class="row m-0">
            <?php include('components/sidebar.php') ?>
            <div class="col-md-9 col-sm-12 col-12">
                <div class="vh-100 py-3">
                    <div class="p-3">
                        <div class="d-flex float-end d-none" id="loader">
                            <div class="me-2">Checking symptoms...</div>
                            <div class="spinner-border text-primary" role="status"></div>
                        </div>

                        <div class="h4 fw-bolder">Check Health</div>

                        <div class="p-2 round-1 bg-light text-dark shadow-sm mb-4">
                            <div class="d-flex align-items-center">
                                <div class="h6 mb-0 py-2 px-3 bg-info round-1 text-white">
                                    1
                                </div>
                                <div class="h6 mb-0 py-2 px-3 me-2">Terms of Service</div>
                                <div class="h6 mb-0 py-2 px-3 bg-info round-1 text-white">
                                    2
                                </div>
                                <div class="h6 mb-0 py-2 px-3 me-2">Select symptoms</div>
                                <div class="h6 mb-0 py-2 px-3 bg-light round-1 text-muted me-2">
                                    3
                                </div>
                                <div class="h6 mb-0 py-2 px-3 bg-light round-1 text-muted me-2">
                                    4
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-5">
                                <div class="h6">
                                    Add symptoms <i class="fas fa-caret-down"></i>
                                </div>
                                <input type="text" class="form-control round-2 mb-3" id="search" onkeyup="searchSymptom($(this).val())" placeholder="Search Symptoms" />

                                <div>
                                    <ul class="list-group list-group-flush" id="result"></ul>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <?php

                                if (isset($_GET['status']) && $_GET['status'] == 2) {
                                    echo ' <div class="alert  alert-danger smallTxt p-2" role="alert">
                                    Sorry, we cannot distinguised the relationship of your sysmptoms. Please refine your symptoms.
                                </div>';
                                }

                                ?>

                                <div class="smallTxt text-muted mb-3">
                                    <i class="fas fa-info-circle"></i> Symptoms you have added appears here.
                                </div>
                                <div id="mySymptoms"></div>
                                <div class="text-end">
                                    <a id="next" class="btn btn-primary">Next </a>
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
    <script>
        $("#navcheck").addClass("bg-info text-white shadow");
        $("#mySymptoms").load("../ajax/loadMySymptoms.php");

        function searchSymptom(str) {
            $("#result").load("../ajax/searchSymptom.php", {
                search: str,
            });
        }

        function addSymptom(id, name) {
            $.post(
                "../ajax/addSymptom.php", {
                    id: id,
                    name: name,
                },
                function(data) {
                    if (data == 1) {
                        alert("Already added.");
                    } else {
                        $("#mySymptoms").load("../ajax/loadMySymptoms.php");
                        $("#result").load("../ajax/searchSymptom.php", {
                            search: "",
                        });
                        $("#search").val("");
                    }
                }
            );
        }

        function deleteSymptom(id) {

            $.post(
                "../ajax/deleteSymptom.php", {
                    id: id
                },
                function() {
                    $("#mySymptoms").load("../ajax/loadMySymptoms.php");


                }
            );
        }

        $("#next").click(function() {
            $("#loader").removeClass("d-none");
            window.location.href = "3.php";
        });
    </script>
</body>

</html>