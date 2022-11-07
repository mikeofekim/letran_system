<?php
session_start();
include('php/db_config.php');

if (isset($_SESSION['userType'])) {
    if ($_SESSION['userType'] == 1) {
        header('Location: admin');
    } else if ($_SESSION['userType'] == 2) {
        header('Location: instructor');
    } else if ($_SESSION['userType'] == 3) {
        header('Location: student');
    }
}

$username = '';
$user['a_status'] = 0;

if (isset($_POST['submit'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM useraccount WHERE username='$username'";
    $result = mysqli_query($conn, $sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if ($user['a_status'] == 2) {
            $error_message = 'Sorry, your account is temporariliy deactivated!';
        } else {
            if (md5($password) == $user['password']) {
                $_SESSION['userid'] = $user['linkedAccount'];
                $_SESSION['userdata'] = $user;
                $_SESSION['userType'] = $user['userType'];
                if ($user['userType'] == 3) {
                    $_SESSION['user'] = mysqli_query($conn, "SELECT * FROM usertbl WHERE userID =" . $user['linkedAccount'])->fetch_assoc();

                    header('Location: student');
                }
                if ($user['userType'] == 2) {
                    $_SESSION['user'] = mysqli_query($conn, "SELECT * FROM teachers WHERE doctorID =" . $user['linkedAccount'])->fetch_assoc();

                    header('Location: instructor');
                }
                if ($user['userType'] == 1) {

                    $_SESSION['user']['firstName'] = 'Administrator';
                    $_SESSION['user']['lastName'] = '';
                    header('Location: admin');
                }
            } else {
                $error_message = 'Incorrect password!';
            }
        }
    } else {
        $error_message = 'Account not found.';
    }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" href="favicon.png" type="image/x-icon">
    <link rel="icon" href="favicon.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="css/style.css" />
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <title>Letran - Manaoag  |  Signin</title>

    <style>
        .cards {
            min-height: 300px;
        }

        .inputs {
            min-width: 300px;
        }
       .image{
           position: relative;
           top: 45px;
           left: 20px;
       }

        body {
            background-image: url("assets/images/bg.jpg");
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }
    </style>
</head>

<body>
    <div class="container d-flex align-items-center justify-content-center" data-aos="flip-left" style="min-height: 100vh">
        <div class="row round-1 border bg-white border-0 shadow-sm m-3 my-4">
            <div class="col-md-6 cards d-none d-md-block">
                <div class="w-100 text-center">
                    <img class="image" src="assets/images/go-further.png" style="object-fit: fill ; width: 300px" alt="" />
                </div>
            </div>
            <div class="col-md-6 cards">
                <div class="p-3">
                    <form action="" method="post" data-aos="fade-down">
                        <div class="text-end mb-5">
                            <a href="index.php"><img src="assets/images/letran_logo.PNG?" alt="" height="60" /></a>

                        </div>
                        <?php

                        if (isset($_GET['status'])) {
                            echo '<div class="bg-light p-3 mb-2 round-2">
                            <div class="h6 mb-0 text-success"><i class="fas fa-check me-2"></i> Great! you are now registered.</div>
                        </div>';
                        }

                        if (isset($error_message)) {
                            echo '<div class="bg-light p-3 mb-2 round-2">
                            <div class="h6 mb-0 text-danger"><i class="fas fa-exclamation-circle me-2"></i> ' . $error_message . '</div>
                        </div>';
                        }
                        ?>

                        <div class="h6 fw- text-secondary mb-0">Email or username</div>
                        <input type="text" class="form-control inputs mb-3 round-2" name="username" value="<?= $username ?>" required />
                        <div class="h6 fw-  text-secondary mb-0" d>Password</div>
                        <input type="password" class="form-control inputs mb-3 round-2" name="password" required />

                        <button type="submit" name="submit" class="btn btn-primary w-100 mb-5 fw-bold round-2">
                            Login
                        </button>
                        <div class="text-center text-muted " data-aos="zoom-in">No account?</div>
                        <a href="signup.php" class="btn btn-light w-100 round-2" data-aos="zoom-in">Register</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
        $("#navcheck").addClass("bg-info text-white");
        $("#mySymptoms").load("../ajax/loadMySymptoms.php");
    </script>
</body>

</html>