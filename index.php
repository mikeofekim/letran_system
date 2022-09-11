<?php
session_start();
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
}

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
            background-image: url("assets/images/bg.jpg");
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        } */


        .container {
            max-width: 950px;
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

    <div class="bg-white py-3 ">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <div class=""><a href="#"> <img src="assets/images/logo.PNG?" alt="" height="30" /></a>


                </div>
                <div class="d-flex align-items-center">
                    <!-- <div class="fw-bold me-4 text-secondary">Explore</div> -->
                    <div class="fw-bold text-primary">
                        <a href="login.php" class=" text-decoration-none btn btn-outline-primary smallTxt fw-bold round-1 px-3">
                            <?php

                            if (isset($_SESSION['userType'])) {
                                echo  $_SESSION['user']['firstName'] . " " . $_SESSION['user']['lastName'] . ' <i class="ms-2 fas fa-user-circle"></i>';
                            } else echo 'Login <i class="fas fa-sign-in-alt ms-2"></i>';


                            ?>

                        </a>
                    </div>
                </div>


            </div>
        </div>
    </div>

    <marquee direction="left" width="100%" class="mb-md-3 mb-0 py-1 bg-light d-block d-md-none ">
        <div class="d-flex align-items-center">
            <div class="me-2">
                <img src="assets/images/virus.png" height="45" alt="">
            </div>
            <div>
                <div class="h6 mb-0 fw-bold me-3">Philippines | <span class="fw-light">Covid 19 Update</span></div>
                <div class="smallTxt">As of <?= date('F d, Y') ?> </div>
            </div>

            <div class="p-2 bg-white shadow-sm round-1 d-flex align-items-center me-3">
                <div class="smallTxt text-primary text-capitalize fw-bold me-2">Infected</div>
                <div class="smallTxt mb-0 text- bg-light round-2 p-1 px-3"><?= number_format($output->infected) ?> </div>
            </div>
            <div class="p-2 bg-white shadow-sm round-1 d-flex align-items-center me-3">
                <div class="smallTxt text-success text-capitalize fw-bold me-2">Recovered</div>
                <div class="smallTxt mb-0 text- bg-light round-2 p-1 px-3"><?= number_format($output->recovered) ?> </div>
            </div>
            <div class="p-2 bg-white shadow-sm round-1 d-flex align-items-center me-3">
                <div class="smallTxt text-danger text-capitalize fw-bold me-2">Deceased</div>
                <div class="smallTxt mb-0 text- bg-light round-2 p-1 px-3"><?= number_format($output->deceased) ?> </div>
            </div>
            <div class="p-2 bg-white shadow-sm round-1 d-flex align-items-center me-3">
                <div class="smallTxt text-warning text-capitalize fw-bold me-2">Active Cases</div>
                <div class="smallTxt mb-0 text- bg-light round-2 p-1 px-3"><?= number_format($output->activeCases) ?> </div>
            </div>



    </marquee>
    <div class="mb-md-3 mb-0 py-1 bg-light d-none d-md-block ">
        <div class="d-flex align-items-center justify-content-start container">
            <div class="me-2">
                <img src="assets/images/virus.png" height="45" alt="">
            </div>

            <div>
                <div class="h6 mb-0 fw-bold me-3">Philippines | <span class="fw-light">Covid 19 Update</span></div>
                <div class="smallTxt">As of <?= date('F d, Y') ?> </div>
            </div>
            <div class="ms-auto d-flex align-items-center justify-content-start ">
                <div class="p-2 bg-white shadow-sm round-1 d-flex flex-column align-items-center me-3">
                    <div class="smallTxt text-primary text-capitalize fw-bold me-2">Infected</div>
                    <div class="smallTxt mb-0 text- bg-light round-2 p-1 px-3"><?= number_format($output->infected) ?> </div>
                </div>
                <div class="p-2 bg-white shadow-sm round-1 d-flex flex-column align-items-center me-3">
                    <div class="smallTxt text-success text-capitalize fw-bold me-2">Recovered</div>
                    <div class="smallTxt mb-0 text- bg-light round-2 p-1 px-3"><?= number_format($output->recovered) ?> </div>
                </div>
                <div class="p-2 bg-white shadow-sm round-1 d-flex flex-column align-items-center me-3">
                    <div class="smallTxt text-danger text-capitalize fw-bold me-2">Deceased</div>
                    <div class="smallTxt mb-0 text- bg-light round-2 p-1 px-3"><?= number_format($output->deceased) ?> </div>
                </div>
                <div class="p-2 bg-white shadow-sm round-1 d-flex flex-column align-items-center">
                    <div class="smallTxt text-warning text-capitalize fw-bold me-2">Active Cases</div>
                    <div class="smallTxt mb-0 text- bg-light round-2 p-1 px-3"><?= number_format($output->activeCases) ?> </div>
                </div>
            </div>




        </div>



    </div>

    <div class="container">
        <div class="row  mb-5">
            <div class="col-md-6">
                <div class="animate__animated animate__fadeIn">
                    <img src="assets/images/cover.jpg" style="object-fit: contain; width: 100%;" alt="">
                </div>
            </div>
            <div class="col-md-6">
                <div class="p-2 animate__animated animate__fadeInRight">
                    <div class="display-4 fw-bolder text-info mt-md-5 mt-sm-0">The greatest wealth is health.</div>
                    <div class="smallTxt mb-2 fst-italic text-secondary  ">-Virgil</div>
                    <div class="h6 text-secondary">
                        <span class="fw-bold">iConsult</span> is a web-based Online Health Diagnosis
                        and E-Consultation System.
                    </div>
                </div>

            </div>

        </div>
    </div>
    <div class="bg-light">
        <div class="container">

            <div class="row  animate__animated animate__zoomIn" style="padding: 150px 0">
                <div class="col-md-12">
                    <div class="h4 fw-bolder mb-3 text-center text-md-start text-info"><span>Features</span></div>
                </div>
                <div class="col-md-4">
                    <div class="p-2 text-center text-md-start mb-4">
                        <div class="box">
                            <div class="d-flex align-items-center justify-content-center p-3 round bg-info mb-3 mx-auto mx-md-0 d-inline-block text-white icon"><i class="fas fa-search fa-lg"></i></div>
                            <div class="h6 fw-bold">Explore & Learn</div>
                            <div class="smallTxt mb-2">Explore various health issues and learn about their medical information and symptoms.</div>
                        </div>
                        <a href="browse.php" class=" btn btn-outline-primary round-1 smallTxt text-decoration-none">Browse now</a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-2 text-center text-md-start mb-4">
                        <div class="box">
                            <div class="d-flex align-items-center justify-content-center p-3 round bg-info mb-3  mx-auto mx-md-0 d-inline-block text-white icon"><i class="fas fa-clipboard-list fa-lg"></i></div>
                            <div class="h6 fw-bold">AI Health Checker<a href="#how" class="text-decoration-none"> *</a></div>
                            <div class="smallTxt mb-2">Check your possible illness based on your symptoms. <span class="fst-italic">(Powered by ApiMedic)</span></div>
                        </div>
                        <a href="patient/check.php" class=" btn btn-outline-primary round-1 smallTxt text-decoration-none">Start now</a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-2 text-center text-md-start mb-4">
                        <div class="box">
                            <div class="d-flex align-items-center justify-content-center p-3 round bg-info mb-3  mx-auto mx-md-0 d-inline-block text-white icon"><i class="fas fa-laptop-medical fa-lg"></i></div>
                            <div class="h6 fw-bold">Consult a Doctor</div>
                            <div class="smallTxt mb-2">Reach out to our volunteer doctors to guide you in your health problem.</div>
                        </div>
                        <a href="patient/consult.php" class=" btn btn-outline-primary round-1 smallTxt text-decoration-none">Consult now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">


        <div class="row mt-5 mb-5">

            <div class="col-md-6">
                <div class="p-2  animate__animated animate__fadeInUp">
                    <div class="h6 fw-bold mb-3 text-primary" id="how">* How does it work?</div>
                    <div class="d-flex align-items-start  mb-3">
                        <div class="d-flex align-items-center justify-content-center round-2 shadow-2 me-3" style="min-width: 50px; height: 50px; border: 3px solid; ">
                            <div class="h4 mb-0 ">1</div>
                        </div>
                        <div class="smallTxt">To start, select the symptoms you have from a list which will be checked by the system.</div>
                    </div>
                    <div class="d-flex align-items-start mb-3">
                        <div class="d-flex align-items-center justify-content-center round-2 shadow-2 me-3" style="min-width: 50px; height: 50px; border: 3px solid; ">
                            <div class="h4 mb-0 ">2</div>
                        </div>
                        <div class="smallTxt">Refine your symptoms by selecting one of the suggested symptoms as needed.</div>
                    </div>
                    <div class="d-flex align-items-start mb-3">
                        <div class="d-flex align-items-center justify-content-center round-2 shadow-2 me-3" style="min-width: 50px; height: 50px; border: 3px solid; ">
                            <div class="h4 mb-0 ">3</div>
                        </div>
                        <div class="smallTxt">Wait while your symptoms are being analyzed, and 3 possible health issue will be displayed. Doctors are also recommended. **</div>
                    </div>

                    <div class="smallTxt text-muted fst-italic">**This feature is only available to registered users. (1x/day)</div>
                </div>

            </div>
            <div class="col-md-6">
                <div class="animate__animated animate__fadeIn">
                    <img src="assets/images/index2.png" style="object-fit: contain; width: 100%;" alt="">
                </div>
            </div>

        </div>

    </div>

    <footer>
        <div class="bg-light text-center p-2 py-3">
            <div class="smallTxt fw-light">Copyright &copy; 2021, iConsult. All Rights Reserved.</div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script>
        $("#navcheck").addClass("bg-info text-white");
        $("#mySymptoms").load("../ajax/loadMySymptoms.php");
    </script>
</body>

</html>