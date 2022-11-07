<?php
session_start();
include('../php/db_config.php');


date_default_timezone_set("Asia/Manila");
$feel = date("H");
if ($feel >= 0 && $feel < 12) {
    $message = "Good morning";
} else if ($feel >= 12 && $feel < 18)
    $message = "Good afternoon";
else if ($feel >= 18 && $feel < 24)
    $message = "Good evening";







// $start_month = date("m") - 5;

if (isset($_GET['yy'])) {
    $current_year = $_GET['yy'];
} else
    $current_year = date("Y");
$start_month = 1;
$end_month = 12;
$months = [];
for ($x = $start_month; $x < ($start_month + $end_month); $x++) {
    array_push($months, date("M " . $current_year, mktime(0, 0, 0, $x, 10)));
}
$trends = [array(0, 0, 0, 0, 0, 0), array(0, 0, 0, 0, 0, 0), array(0, 0, 0, 0, 0, 0), array(0, 0, 0, 0, 0, 0), array(0, 0, 0, 0, 0, 0)];


date_default_timezone_set("Asia/Manila");
$arr = [];
$arr1 = [];



    



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" href="components/favicon.png" type="image/x-icon">
    <link rel="icon" href="components/favicon.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../css/style.css" />
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <title>Administrator | Home</title>
    <style>
        .mygradient {
            background-image: linear-gradient(to left bottom, #ffffff, #f1feff, #d3ffff, #c0fff5, #d0ffcb);
        }

        .lowvh {
            height: calc(100vh - 480px);
        }

        .data {
            overflow-y: auto;
            height: calc(100vh - 50px);
        }
    </style>
</head>

<body>
    <div class="container-fluid p-0">
        <?php include('components/navbar.php') ?>
        <div class="row m-0">
            <?php include('components/sidebar.php') ?>
            <div class="col-md-9 col-sm-12 col-12">
                <div class=" mt-4 data" id="data">
                    <div class="p-3">
                        <div class="h4 mb-0" data-aos="zoom-in"><?= $message ?> <span class="fw-bold">Admin</span></div>
                     
                                        <hr>
                                        



                                    </div>
                                </div>
                            </div>


                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src=" https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        AOS.init();
        $("#navhome").addClass("bg-info text-white shadow");
        updateScreen();
        window.addEventListener('resize', updateScreen);

      
    </script>
</body>

</html>