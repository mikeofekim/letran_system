<?php
session_start();
include('php/db_config.php');



$sql = "SELECT * FROM healthissues WHERE issueID='" . $_GET['id'] . "'";
$issue = mysqli_query($conn, $sql)->fetch_assoc();
$symptoms = explode(',', $issue['possibleSymptoms']);


$keyword = $issue['issueName'] . ' ' . $issue['profName'];
$keyword = str_replace(" ", "+", $keyword);


if ($issue['imagefile'] == null) {

    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_URL => "https://google-search3.p.rapidapi.com/api/v1/images/q=" . $keyword,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => [
            "x-rapidapi-host: google-search3.p.rapidapi.com",
            "x-rapidapi-key: e4bd8299d1msh5e36c2feb1b81c0p1b5f18jsn24ebc218ea83"
        ],
    ]);

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);



    if ($err) {
        echo "cURL Error #:" . $err;
    } else {

        $image = json_decode($response)->image_results;
        $thumbnail = $image[0]->image;
        $thumbnail = $thumbnail->src;
        // echo $thumbnail;

        $sql = "UPDATE healthissues SET imagefile = '$thumbnail' WHERE issueID = " . $_GET['id'];
        mysqli_query($conn, $sql);
    }
} else {
    $thumbnail = $issue['imagefile'];
}

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="../favicon.ico" type="image/x-icon">
    <link rel="icon" href="../favicon.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="css/style.css?">

    <title>iConsult | Browse</title>
    <style>
        .container {
            max-width: 950px;
        }

        .icon {
            width: 50px;
            height: 50px;
        }
    </style>
</head>

<body>
    <div class="bg-white py-3 ">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <div class=""><a href="index.php"> <img src="assets/images/logo.PNG?" alt="" height="30" /></a>


                </div>
                <div class="d-flex align-items-center">
                    <!-- <div class="fw-bold me-4 text-secondary">Explore</div> -->
                    <div class="fw-bold text-primary">
                        <a href="login.php" class=" text-decoration-none btn btn-outline-primary smallTxt fw-bold round-1 px-3">Login</a>
                    </div>
                </div>


            </div>
        </div>
    </div>
    <div class="container p-0">
        <div class="p-3">
            <div class="float-end">
                <a href="<?= $thumbnail ?>" target="_blank">
                    <img src="<?= $thumbnail ?>" height="100" alt="" class="shadow round-2">
                </a>
            </div>
            <div class="h4 fw-bolder">Browse</div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a style="cursor:pointer; " class="text-primary text-decoration-none" onclick="window.history.back()">Go back</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        <?= $issue['issueName'] ?>
                    </li>
                </ol>
            </nav>
            <div class="h4 fw-bold mb-0 text-primary">
                <?= $issue['issueName'] ?>
            </div>
            <div class="smallTxt text-muted">
                also known as <?= $issue['profName'] ?>
            </div>
            <hr>
            <div class="row mycontent " id="main">
                <div class="col-md-12">

                </div>
                <div class="col-md-8">

                    <div class="smallTxt fw-bold">Description</div>
                    <div class="h6 fw-light lh-base ">
                        <?= $issue['description'] ?>
                    </div>
                    <hr>
                    <div class="smallTxt fw-bold">Medical Information</div>
                    <div class="h6 fw-light lh-base">
                        <?= $issue['medicalCondition'] ?>
                    </div>
                    <hr>
                    <div class="smallTxt fw-bold">Treatment</div>
                    <div class="h6 fw-light lh-base">
                        <?= $issue['treatmentDescription'] ?>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card round-2 shadow-sm border-0 bg-light">
                        <div class="card-body">
                            <div class="smallTxt fw-bold">Symptoms</div>
                            <div class="h6 font-weight-light lh-base">
                                <ul>
                                    <?php
                                    foreach ($symptoms as $s) {
                                        echo '<li class="fw-light">' . $s . '</li>';
                                    }
                                    ?>
                                </ul>
                            </div>

                        </div>
                    </div>
                </div>

            </div>

            <?php





            ?>


        </div>
    </div>





    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script>
        updateScreen();
        $("#navbrowse").addClass("bg-info text-white shadow");

        function updateScreen() {
            if (window.innerWidth < 600) {
                $("#main").removeClass('mycontent');
            } else {
                $("#main").addClass('mycontent');
            }
        }
        $("#mySymptoms").load("patient/ajax/loadMySymptoms.php");

        function searchSymptom(str) {
            $("#result").load("patient/ajax/searchSymptom.php", {
                search: str
            });
        }
    </script>
</body>

</html>