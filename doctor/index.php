<?php
session_start();
include('../php/db_config.php');

// print_r($_SESSION['user']);
if (isset($_SESSION['userType'])) {
    if ($_SESSION['userType'] != 2) {
        header('Location: ../login.php');
    }
} else {
    header('Location: ../login.php');
}

date_default_timezone_set("Asia/Manila");
$feel = date("H");
if ($feel >= 0 && $feel < 12) {
    $message = "Good morning";
} else if ($feel >= 12 && $feel < 18)
    $message = "Good afternoon";
else if ($feel >= 18 && $feel < 24)
    $message = "Good evening";


$_SESSION['symptoms'] = [];


$url = "https://api.apify.com/v2/key-value-stores/lFItbkoNDXKeSWBBA/records/LATEST?disableRedirect=true";

// echo $url;
//  Initiate curl
$ch = curl_init();
// Will return the response, if false it print the response
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// Set the url
curl_setopt($ch, CURLOPT_URL, $url);
// Execute
$result = curl_exec($ch);
// Closing
curl_close($ch);

// Will dump a beauty json :3
// var_dump(json_decode($result, true));

$output = json_decode($result);


if (!$output) {
    $output = (object) [];
    $output->infected = 0;
    $output->recovered = 0;
    $output->deceased = 0;
    $output->activeCases = 0;
    $output->unique = 0;
    $output->tested = 0;
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
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <title>iConsult | Home</title>
    <style>
        .mygradient {
            background-image: linear-gradient(to left bottom, #ffffff, #f1feff, #d3ffff, #c0fff5, #d0ffcb);
        }

        .lowvh {
            height: calc(100vh - 315px);
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
                        <div class="h4 mb-0" data-aos="flip-up"><?= $message ?> <span class="fw-bold">Dr. <?= $_SESSION['user']['firstName'] ?>,</span></div>
                        <hr>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="card border-0 round-1 shad mb-3 ">
                                    <div class="card-body p-0">

                                        <div class="d-flex align-items-center" data-aos="fade-left">
                                            <div class="me-2">
                                                <img src="../assets/images/virus.png" height="45" alt="">
                                            </div>
                                            <div>
                                                <div class="h5 mb-0 fw-bold">Philippines | <span class="fw-light">Covid 19 Update</span></div>
                                                <div class="smallTxt">As of <?= date('F d, Y') ?> | endcov.ph</div>
                                            </div>


                                        </div>


                                        <div class="row mt-3">
                                            <div class="col-md-4">
                                                <div class="p-3 bg-white shadow-sm round-1 mb-3" data-aos="fade-up">
                                                    <span class="float-end"><i class="fas fa-user-check"></i></span>
                                                    <div class="smallTxt text-primary text-capitalize mb-2 fw-bold">Infected</div>
                                                    <div class="h1 mb-0 text- bg-light round-2 p-2 px-3"><?= number_format($output->infected) ?> </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 ">
                                                <div class="p-3 bg-white shadow-sm  round-1 mb-3" data-aos="fade-up">
                                                    <span class="float-end"><i class="fas fa-user-clock"></i></span>
                                                    <div class="smallTxt text-success text-capitalize mb-2 fw-bold">Recovered</div>
                                                    <div class="h1 mb-0  text- bg-light round-2 p-2 px-3"><?= number_format($output->recovered) ?> </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="p-3 bg-white shadow-sm round-1 mb-3" data-aos="fade-up">
                                                    <span class="float-end"><i class="fas fa-user-slash"></i></span>
                                                    <div class="smallTxt text-danger text-capitalize mb-2 fw-bold">Deceased</div>
                                                    <div class="h1 mb-0  text- bg-light round-2 p-2 px-3"><?= number_format($output->deceased) ?></div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="p-3 bg-white shadow-sm round-1 mb-3" data-aos="fade-up">
                                                    <span class="float-end"><i class="fas fa-user-injured"></i></span>
                                                    <div class="smallTxt text-warning text-capitalize mb-2 fw-bold">Active Cases</div>
                                                    <div class="h1  mb-0 text- bg-light round-2 p-2 px-3"><?= number_format($output->activeCases) ?></div>
                                                </div>

                                            </div>
                                            <div class="col-md-4">
                                                <div class="p-3 bg-white shadow-sm round-1 mb-3" data-aos="fade-up">
                                                    <span class="float-end"><i class="fas fa-user-tag"></i></span>
                                                    <div class="smallTxt text-muted text-capitalize mb-2 fw-bold">Cumulative Unique Individuals</div>
                                                    <div class="h1  mb-0 text- bg-light round-2 p-2 px-3"><?= number_format($output->unique) ?></div>
                                                </div>

                                            </div>
                                            <div class="col-md-4">
                                                <div class="p-3 bg-white shadow-sm round-1 mb-3" data-aos="fade-up">
                                                    <span class="float-end"><i class="fas fa-user-md"></i></span>
                                                    <div class="smallTxt text-muted text-capitalize mb-2 fw-bold">Cumulative Sample Tested</div>
                                                    <div class="h1  mb-0 text- bg-light round-2 p-2 px-3"><?= number_format($output->tested) ?></div>
                                                </div>

                                            </div>
                                            <div class="col-md-6">
                                                <img src="../assets/images/info1.png" alt="" class="img-fluid round-2 shadow-sm mb-3" data-aos="zoom-in">
                                            </div>
                                            <div class="col-md-6">
                                                <img src="../assets/images/info2.JPG" alt="" class="img-fluid round-2 shadow-sm" data-aos="zoom-in">
                                            </div>
                                            <div class="text-end">
                                                <div class="smallTxt fst-italic text-muted">Images source: WHO</div>
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
    </div>

    <script src=" https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
        $("#navhome").addClass("bg-info text-white shadow");
        updateScreen();
        window.addEventListener('resize', updateScreen);


        function updateScreen() {
            if (window.innerWidth < 600) {
                $("#data").removeClass('data');

            } else {
                $("#data").addClass('data');

            }
        }

        function calcBMI() {
            var weight = document.bmiform.pounds.value,
                height = document.bmiform.inches.value;
            document.bmiform.bmi.text = parseInt((weight * 703) / (height * height));
        }
    </script>
</body>

</html>