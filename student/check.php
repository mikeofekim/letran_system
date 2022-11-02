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
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <title>iConsult | Check Health</title>
    <style>
        .mycard {
            height: calc(100vh - 95px);
            overflow-y: auto;
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
                        <div class="h4 fw-bolder">Check Health</div>
                        <div class="row">
                            <div class="col-md-7">
                                <div class="mb-3">
                                    <img src="../assets/images/check.jpg" alt="" class="w-100 round-1 mb-3 shadow-sm" data-aos="fade-in" />
                                    <div class="h2" data-aos="fade-up">
                                        What concerns you about your health today?
                                    </div>
                                    <div class="h6" data-aos="fade-up">
                                        Check your symptoms and find out<br /> what could be causing them.
                                    </div>
                                    <div class="text-end">
                                        <button type="button" onclick="startdiagnose()" class="btn btn-primary">
                                            Start
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="card bg-white round-1 border-0 shadow-sm mycard" id="rightpanel" data-aos="fade-in">
                                    <div class="card-body">
                                        <div class="h5 fw-bold mb-3">My History</div>
                                        <input type="date" class="form-control round-2 mb-2" name="" id="date" value="<?= date("Y-m-d") ?>">
                                        <div class="d-flex justify-content-between">
                                            <div class="w-100 me-2">
                                                <input type="text" class="form-control round-2 mb-2" id="search" placeholder="Search history">
                                            </div>
                                            <div>
                                                <button class="btn  btn-primary shadow-sm round-2 px-3 " onclick="loadhistory()"><i class="fas fa-search"></i></button>
                                            </div>
                                        </div>

                                        <hr>

                                        <div id="history" data-aos="fade-in">

                                        </div>
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
    <script src="sweetalert2.all.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
        updateScreen();
        loadhistory();
        $("#navcheck").addClass("bg-info text-white shadow");
        $("#mySymptoms").load("../ajax/loadMySymptoms.php");

        window.addEventListener('resize', updateScreen);

        function updateScreen() {
            if (window.innerWidth < 600) {
                $("#rightpanel").removeClass('mycard');
            } else {
                $("#rightpanel").addClass('mycard');
            }
        }



        function loadhistory() {
            $("#history").html("");
            var keyword = $("#search").val();
            var date = $("#date").val();

            $("#history").load("ajax/loadhistory.php", {
                keyword: keyword,
                date: date
            });
        }

        function startdiagnose() {
            $.post('ajax/check-diagnosis.php', function(response) {
                if (response == 1) {



                    alert("You have already diagnose today.");
                } else if (response == 0) {
                    window.location.href = "1.php";
                }
            });
        }
    </script>
</body>

</html>