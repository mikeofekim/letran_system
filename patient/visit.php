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
$sql = "SELECT * FROM diagnosis a INNER JOIN usertbl b ON a.userid = b.userID WHERE a.id = $id";
$result = mysqli_query($conn, $sql);

if ($result->num_rows > 0) {
    $diagnosis = $result->fetch_assoc();
    $diff = date_diff(date_create($diagnosis['birthday']), date_create(date('Y-m-d')));
    $age = $diff->format('%y');
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

    <title>iConsult | <?= $diagnosis['firstName'] . " " . $diagnosis['lastName'] ?></title>
    <style>
        .container {
            max-width: 600px;
        }
    </style>
</head>

<body>
    <div class="container p-0">


        <div class="p-3">
            <div class="card bg-white round-1 border-0 ">
                <div class="card-body">
                    <div class="d-flex mb-3">
                        <div>
                        </div>
                        <div>
                            <div class="h6 mb-0 fw-bold">
                                <?= $diagnosis['firstName'] . " " . $diagnosis['lastName'] ?>
                            </div>
                            <div class="smallTxt"><?= $age ?> years old</div>
                        </div>
                    </div>
                    <div class="h6  mb-3 text-primary">Details</div>
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
                    <div class="h6  mb-3 text-primary">Result</div>
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
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script>
        $("#navcheck").addClass("bg-info text-white shadow");
        $("#mySymptoms").load("../ajax/loadMySymptoms.php");
    </script>
</body>

</html>