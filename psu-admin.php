<?php
session_start();
include('php/db_config.php');



if (isset($_POST['uploadcsv'])) {
    $target_dir = "uploads/";
    $target_file = $target_dir . basename("psu-data.csv");
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    $file_pointer = "uploads/" . "psu-data.csv";

    // Use unlink() function to delete a file 
    if (unlink($file_pointer)) {
    }

    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        // echo "The file " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " has been uploaded.";
    } else {
        // echo "Sorry, there was an error uploading your file.";
    }
}

if (isset($_POST['filename'])) {
    $file_pointer = "uploads/" . $_POST['filename'];

    // Use unlink() function to delete a file 
    if (!unlink($file_pointer)) {
        // echo ("$file_pointer cannot be deleted due to an error");
    } else {
        // echo ("$file_pointer has been deleted");
    }
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
    <link rel="stylesheet" href="css/style.css" />

    <title>iConsult | Home</title>
    <style>
        body {
            background-image: url('bg-psu.jpg');
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            background-attachment: fixed;
        }
    </style>
</head>

<body class="bg-light">
    <div class="container p-0">

        <div class="row m-0">

            <div class="col-md-12 col-sm-12 col-12">
                <div class="">
                    <div class="p-3">

                        <div class="row mt-3">

                            <div class="col-md-12">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="me-2">
                                        <img src="assets/images/psu.png" height="45" alt="">
                                    </div>
                                    <div>
                                        <div class="h5 mb-0 fw-bold">Pangasinan State University | <span class="fw-light">Admin</span></div>
                                        <div class="smallTxt"><?= date('F d, Y') ?> </div>
                                    </div>


                                </div>
                            </div>


                            <div class="col-md-12">
                                <form action="" method="post" enctype="multipart/form-data" class="d-none">
                                    Select image to upload:
                                    <input type="file" name="fileToUpload" id="fileToUpload" accept=".csv" onchange="$('#uploadbtn').click()">
                                    <input type="submit" id="uploadbtn" value="Upload Image" name="uploadcsv">
                                </form>
                                <div class="row">
                                    <div class="col-md-12 ">
                                        <div class="card round-1 border-0  shadow-sm mb-3">
                                            <div class="card-body">

                                                <div class="float-end">
                                                    <button class="btn btn-light btn-sm round-2 shadow-sm text-primary px-4 border fw-bold" onclick="up()">Update CSV</button>
                                                </div>
                                                <div class="smallTxt text-primary text-capitalize fw-bold">PSU COVID Data File</div>
                                                <div class="smallTxt text-muted mb-2 fst-italic">Click CSV file to load dashboard.</div>
                                                <hr>
                                                <form action="" method="post" id="deleteform" class="d-none">
                                                    <input type="text" name="filename" id="csvtodelete">

                                                </form>
                                                <div class="d-flex">
                                                    <?php

                                                    if ($handle = opendir('uploads/')) {

                                                        while (false !== ($entry = readdir($handle))) {

                                                            if ($entry != "." && $entry != "..") {

                                                    ?>
                                                                <div class="text-center m-3" style="max-width: 150px">
                                                                    <a href="psu.php"> <img src="assets/images/csv.png" height="50" alt="" class="pointer"></a>

                                                                    <div class="smallTxt fw-bold text-truncate"><?= $entry ?></div>
                                                                    <!-- <div><i class="far fa-trash-alt fa-sm text-danger pointer" onclick="deletecsv('<?= $entry ?>')"></i></div> -->
                                                                </div>
                                                    <?php
                                                            }
                                                        }

                                                        closedir($handle);
                                                    }

                                                    ?>

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
    </div>



    <script src=" https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.5.1/dist/chart.min.js"></script>
    <script>
        $("#navhome").addClass("bg-info text-white shadow");


        function deletecsv(file) {
            if (confirm("Are you sure to delete this file?")) {
                $("#csvtodelete").val(file);
                $("#deleteform").submit();
            }

        }

        function up() {
            $("#fileToUpload").click();
        }
    </script>
</body>

</html>