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

date_default_timezone_set("Asia/Manila");

$token = new token();
$data = $token->getTokenNow($conn);
$token = $data['1'];
$tokenID = $data['0'];
$symptoms = $_SESSION['symptoms'];
$arr = [];
foreach ($symptoms as $item) {
    array_push($arr, $item[0]);
}
$id = $_SESSION['user']['userID'];
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

    <title>iConsult | Diagnosis</title>
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
                        <div class="p-2 round-1 bg-light text-dark shadow-sm mb-4" style="overflow-x: auto">
                            <div class="d-flex align-items-center">
                                <div class="h6 mb-0 py-2 px-3 bg-info round-1 text-white">
                                    1
                                </div>
                                <div class="h6 mb-0 py-2 px-3 me-2 text-nowrap">
                                    Terms of Service
                                </div>
                                <div class="h6 mb-0 py-2 px-3 bg-info round-1 text-white">
                                    2
                                </div>
                                <div class="h6 mb-0 py-2 px-3 me-2 text-nowrap">
                                    Select symptoms
                                </div>
                                <div class="h6 mb-0 py-2 px-3 bg-info round-1 text-white">
                                    3
                                </div>
                                <div class="h6 mb-0 py-2 px-3 me-2 text-nowrap">
                                    Refine symptoms
                                </div>
                                <div class="h6 mb-0 py-2 px-3 bg-info round-1 text-white">
                                    4
                                </div>
                                <div class="h6 mb-0 py-2 px-3 me-2">Diagnosis</div>
                            </div>
                        </div>

                        <div class="row">

                            <div class="col-md-5">
                                <div class="card border-0 bg-light shadow-sm round-1">
                                    <div class="card-body">
                                        <div class="h5 fw-bold">Results</div>
                                        <div class="smallTxt text-muted mb-3">
                                            Please note that the list below may not be complete and is provided solely for informational purposes and is not qualified medical opinion.
                                        </div>
                                        <?php

                                        $token = $token . "&format=json&language=en-gb";

                                        $url = "https://healthservice.priaid.ch/diagnosis?symptoms=" . json_encode($arr) . "&gender=$gender&year_of_birth=$age&token=" . $token;
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
                                        $date =  date("Y-m-d H:i:s");
                                        // Will dump a beauty json :3
                                        // var_dump(json_decode($result, true));
                                        $symp = $conn->real_escape_string(json_encode($arr));
                                        $test = $conn->real_escape_string($result);
                                        $output = json_decode($result);


                                        $doc = [];
                                        $sql = "SELECT * FROM healthissues WHERE issueID > 999";
                                        $result = mysqli_query($conn, $sql);
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                $sym = explode(',', $row['possibleSymptoms']);
                                                $possibility = 0;
                                                for ($x = 0; $x < count($symptoms); $x++) {
                                                    for ($y = 0; $y < count($sym); $y++) {
                                                        if ($symptoms[$x][1] == $sym[$y]) {
                                                            $possibility++;
                                                        }
                                                    }
                                                }


                                                $p = ($possibility / count($sym)) * 100;
                                                // echo $possibility;
                                                if ($p > 20) {
                                                    $aaa = (object) array("Issue" => (object) array("ID" => $row['issueID'], "Name" => $row['issueName'], "IcdName" => ''), "Specialisation" =>  array((object) array("Name" => "General Practice")));

                                                    array_unshift($output, $aaa);
                                                }
                                            }
                                        }






                                        // print_r($output);
                                        // print_r($output);
                                        //special code

                                        $last_id;
                                        if (count($output) != 0) {




                                            $sql = "INSERT INTO diagnosis VALUES (null, $id, '$symp', '" . json_encode($output) . "','', '$date')";
                                            mysqli_query($conn, $sql);

                                            $last_id = $conn->insert_id;
                                            echo $conn->error;
                                            $count = 0;
                                            foreach ($output as $row) {
                                                if ($count == 3) break;
                                                $obj1 = $row->Issue;
                                                $obj2 = $row->Specialisation; ?>

                                                <div class="card round-1 border-0 mb-3">
                                                    <div class="card-body">
                                                        <a href="view.php?id=<?= $obj1->ID ?>" class="float-end text-decoration-none smallTxt">View <i class="fas fa-angle-right"></i></a>
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
                                                                    Recommmended Specialist:
                                                                </div>
                                                                <?php
                                                                echo $obj2[0]->Name
                                                                    . "<br />";


                                                                array_push($doc, $obj2[0]->Name);

                                                                ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                        <?php

                                            }
                                        } else {
                                            echo 'Nothing to show, please click next.';
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
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="p-3">
                                    <div class="text-start">
                                        <img src="../assets/images/consultdoc.jpg" height="200" alt="" />
                                    </div>

                                    <div class="h3 fw-bold">Consult a Doctor</div>
                                    <div class="h6 mb-3 text-secondary">
                                        Your symptoms may require medical evaluation. If your symptoms get worse, see a doctor immediately.
                                    </div>
                                    <div class="smallTxt fw-bold">Recommended Doctor</div>
                                    <?php

                                    for ($x = 0; $x < count($doc); $x++) {
                                        $sql = "SELECT * FROM  useraccount a Inner JOIN doctortbl b ON a.linkedAccount = b.doctorID WHERE a.usertype = 2 AND specialization = '" . $doc[$x] . "'";
                                        $result = mysqli_query($conn, $sql);


                                        // print_r($doc);
                                        if ($result->num_rows > 0) {
                                            $count = 0;
                                            $docs = [];
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

                                                array_push($docs, $row['userAccountID']);
                                                ++$count;
                                                if ($count == 3) break;
                                            }

                                            $sql = "UPDATE diagnosis SET doctor = '" . implode(",", $docs) . "' WHERE id = $last_id";
                                            mysqli_query($conn, $sql);
                                            break;
                                        }
                                    }


                                    ?>


                                </div>
                            </div>
                        </div>

                        <div class="text-end">
                            <!-- <a href="2.php" class="btn btn-primary">Next
                            </a> -->
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