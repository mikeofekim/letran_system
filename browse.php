<?php
include('php/db_config.php');



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
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
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


    <div class="container p-0">


        <div class="p-3">
            <div class="h4 fw-bolder">Browse</div>
            <div class=" p-2 round-1 bg-light text-dark shadow-sm mb-4 d-flex align-items-center">
                <div class="mx-2">
                    <i class="fas fa-search"></i>
                </div>
                <div class="ms-1 w-100">
                    <input type="text" class="form-control round-2" placeholder="Search health issue" onkeyup="search($(this).val())">
                </div>
            </div>
            <div class="d-flex justify-content-between flex-wrap mb-3">
                <?php
                $str = "A";

                while ($str != "AA") {
                    if ($str == "Q" || $str == "X" || $str == "Z") {
                    } else {
                        echo "<a href='?keyword=" . $str . "' class='mx-2 text-decoration-none fw-bold'>" . $str . "</a>";
                    }

                    $str++;
                }
                ?>


            </div>
            <div id="main">

                <div class=" row " id="query">

                    <?php

                    if (isset($_GET['keyword'])) {
                        $key = $_GET['keyword'];
                    } else $key = "A";

                    $sql = "SELECT * FROM issues WHERE isdisplayed = 0 AND name LIKE '" . $key . "%' ORDER BY name";
                    $result = mysqli_query($conn, $sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '<div class="col-md-4 "><div class=" bg-light round-2 p-3 mb-3 issues shadow-sm" style="height: 100px" onclick="window.location.href=\'view.php?id=' . $row['id'] . '\'" >';
                            echo "<div class='h6 text-truncate'>" . $row['name'] . " <i class='fas fa-angle-right'></i></div><div class='form-text'>Learn more about <span class='text-lowercase'>" . $row['name'] . "</span> symptoms & treatments</div></div></div>";
                        }
                    }

                    ?>

                </div>
            </div>

        </div>


    </div>





    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // AOS.init();
        $("#navbrowse").addClass("bg-info text-white shadow");
        updateScreen();
        window.addEventListener('resize', updateScreen);

        // function updateScreen() {
        //     if (window.innerWidth < 600) {
        //         $("#main").removeClass('mycontent');
        //     } else {
        //         $("#main").addClass('mycontent');
        //     }
        // }
        $("#mySymptoms").load("patient/ajax/loadMySymptoms.php");

        function searchSymptom(str) {
            $("#result").load("patient/ajax/searchSymptom.php", {
                search: str
            });
        }


        function search(key) {
            $("#query").load("patient/ajax/searchIssue.php", {
                keyword: key
            });
        }
    </script>
</body>

</html>