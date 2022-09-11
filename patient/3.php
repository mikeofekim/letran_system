<?php
session_start();
include('../php/db_config.php');
include('../php/token.php');

if (isset($_SESSION['userType'])) {
    if ($_SESSION['userType'] != 3) {
        header('Location: ../login.php');
    }
} else {
    header('Location: ../login.php');
}

$token = new token();
$data = $token->getTokenNow($conn);
$token = $data['1'];
$tokenID = $data['0'];
$symptoms = $_SESSION['symptoms'];
$arr = [];
foreach ($symptoms as $item) {
    array_push($arr, $item[0]);
}

$dateOfBirth = $_SESSION['user']['birthday'];
$today = date("Y-m-d");
$diff = date_diff(date_create($dateOfBirth), date_create($today));
$age = $diff->format('%y');
if ($_SESSION['user']['gender'] == 0) {
    $gender = 'male';
} else {
    $gender = 'female';
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
    <link rel="stylesheet" href="../css/style.css?" />

    <title>iConsult | Refine Symptoms</title>
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
                            <div class="me-2">Analyzing symptoms...</div>
                            <div class="spinner-border text-primary" role="status"></div>
                        </div>

                        <div class="h4 fw-bolder">Check Health</div>
                        <div class="p-2 round-1 bg-light text-dark shadow-sm mb-4">
                            <div class="d-flex align-items-center " style="overflow-x: auto">
                                <div class="h6 mb-0 py-2 px-3 bg-info round-1 text-white">
                                    1
                                </div>
                                <div class="h6 mb-0 py-2 px-3 me-2 text-nowrap">Terms of Service</div>
                                <div class="h6 mb-0 py-2 px-3 bg-info round-1 text-white">
                                    2
                                </div>
                                <div class="h6 mb-0 py-2 px-3 me-2 text-nowrap">Select symptoms</div>
                                <div class="h6 mb-0 py-2 px-3 bg-info round-1 text-white">
                                    3
                                </div>
                                <div class="h6 mb-0 py-2 px-3 me-2 text-nowrap">Refine symptoms</div>
                                <div class="h6 mb-0 py-2 px-3 bg-light round-1 text-muted">
                                    4
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-5">
                                <div class="h5 fw-bold mb-0">Do you feel one of these symptoms?</div>
                                <div class="smallTxt mb-3">Select below if necessary.</div>

                                <?php

                                $token = $token . "&format=json&language=en-gb";

                                $url = "https://healthservice.priaid.ch/symptoms/proposed?symptoms=" . json_encode($arr) . "&gender=$gender&year_of_birth=$age&token=" . $token;

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

                                if (count($output) != 0) {
                                    foreach ($output as $row) {
                                ?>
                                        <!-- <div class="mb-2">
                                        <input class="form-check-input" type="radio" name="symptom[]" value="<?= $row->ID ?>" />
                                        <label class="form-check-label" for="">
                                            <?= $row->Name ?>
                                        </label>
                                    </div> -->


                                <?php
                                        echo '  <li class="list-group-item border-0" onclick="addSymptom(\'' . $row->ID . '\',\'' . $row->Name . '\')" style="cursor: pointer"><div class="mb-0 h6">' . $row->Name . '</div>';
                                    }
                                } else {
                                    echo "Sorry, we cannot distinguised the relationship of your symptoms. Please go back and refine symptoms. ";
                                    echo '  <script>
                                window.location.href = "2.php?status=2";
                            </script>';
                                    $isReady = 1;
                                }

                                $sql = "SELECT * FROM tokens WHERE tokenID = $tokenID";
                                $tokenData = mysqli_query($conn, $sql)->fetch_assoc();
                                $requests = $tokenData['no_request'];
                                if ($requests == 99) {
                                    $date = date('Y-m-d');

                                    $sql = "UPDATE tokens SET no_request = 0, date_ended = '$date' WHERE tokenID = $tokenID";
                                    mysqli_query($conn, $sql);
                                } else {
                                    $sql = "UPDATE tokens SET no_request = ($requests+1) WHERE tokenID = $tokenID";
                                    mysqli_query($conn, $sql);
                                }

                                ?>
                            </div>

                            <div class="col-md-5">
                                <div class="smallTxt text-muted mb-3">
                                    <i class="fas fa-info-circle"></i> Symptoms you have added appears here.
                                </div>
                                <div id="mySymptoms"></div>
                            </div>

                        </div>
                    </div>
                    <div class="text-end">
                        <a id="next" class="btn btn-primary">Next </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script>
        $("#navcheck").addClass("bg-info text-white shadow");
        $("#next").click(function() {

            $("#loader").removeClass("d-none");
            window.location.href = "4.php";
        });

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
                        $("#next").click();
                    }
                }
            );
        }
        $("#mySymptoms").load("../ajax/loadMySymptoms.php");
    </script>


</body>

</html>