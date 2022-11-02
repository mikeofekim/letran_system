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

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="../favicon.ico" type="image/x-icon">
    <link rel="icon" href="../favicon.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../css/style.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <title>iConsult | Browse</title>
    <style>
        .mycontent {
            height: calc(100vh - 210px);
            overflow-y: auto;
            overflow-x: hidden;
        }
    </style>
</head>

<body>
    <div class="container-fluid p-0">
        <?php include('components/navbar.php') ?>
        <div class="row m-0">
            <?php include('components/sidebar.php') ?>
            <div class=" col-md-9 col-sm-12 col-12">
                <div class="vh-100  py-3">
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
                        <div class="d-flex justify-content-between flex-wrap mb-3" data-aos="fade-in">
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
                        <div class="mycontent p-2" id="main">

                            <div class="row " id="query">

                                <?php

                                if (isset($_GET['keyword'])) {
                                    $key = $_GET['keyword'];
                                } else $key = "A";

                                $sql = "SELECT * FROM issues WHERE isdisplayed = 0 AND name LIKE '" . $key . "%' ORDER BY name";
                                $result = mysqli_query($conn, $sql);

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo '<div class="col-md-4 "><div class=" bg-light round-2 p-3 mb-3 issues shadow-sm" style="height: 100px" onclick="window.location.href=\'view.php?id=' . $row['id'] . '\'" data-aos="fade-up">';
                                        echo "<div class='h6 text-truncate'>" . $row['name'] . " <i class='fas fa-angle-right'></i></div><div class='form-text'>Learn more about <span class='text-lowercase'>" . $row['name'] . "</span> symptoms & treatments</div></div></div>";
                                    }
                                }

                                ?>

                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
        $("#navbrowse").addClass("bg-info text-white shadow");
        updateScreen();
        window.addEventListener('resize', updateScreen);

        function updateScreen() {
            if (window.innerWidth < 600) {
                $("#main").removeClass('mycontent');
            } else {
                $("#main").addClass('mycontent');
            }
        }
        $("#mySymptoms").load("../ajax/loadMySymptoms.php");

        function searchSymptom(str) {
            $("#result").load("../ajax/searchSymptom.php", {
                search: str
            });
        }

        function addSymptom(id, name) {
            $.post("../ajax/addSymptom.php", {
                id: id,
                name: name
            }, function(data) {
                if (data == 1) {
                    alert("Already added.");
                } else {
                    $("#mySymptoms").load("../ajax/loadMySymptoms.php");
                    $("#result").load("../ajax/searchSymptom.php", {
                        search: ''
                    });
                    $('#search').val('');
                }
            });

        }

        function search(key) {
            $("#query").load("ajax/searchIssue.php", {
                keyword: key
            });
        }
    </script>
</body>

</html>