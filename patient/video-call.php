<?php
session_start();
include '../php/db_config.php';

if (isset($_SESSION['userType'])) {
    if ($_SESSION['userType'] != 3) {
        header('Location: ../login.php');
    }
} else {
    header('Location: ../login.php');
}

$token = $_GET['token'];
$sql = "SELECT * FROM  videocall a INNER JOIN consultations b ON a.consultationID = b.consultationID WHERE token = '$token'";
$vcdata = mysqli_query($conn, $sql);

if ($vcdata->num_rows > 0) {
    $vcdata = $vcdata->fetch_assoc();
    // echo "Success";
} else {
    // echo "Not found";
    header("Location: ../page-not-found.php");
}

$display_name = $_SESSION['user']['firstName'] . " " . $_SESSION['user']['lastName'];
// echo $display_name;

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../favicon.ico" type="image/x-icon">
    <link rel="icon" href="../favicon.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../css/style.css" />
    <title>Consultation #<?= $vcdata['code'] ?></title>

    <style>
        .container {
            max-width: 900px;
        }

        body {
            background-image: url("../assets/images/bg.jpg");
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }
    </style>
</head>

<body>
    <div class="bg-white p-3 shadow-sm mb-3">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <div class="">
                    <img src="../assets/images/logo.PNG?" alt="" height="30" />

                </div>
                <div class="d-flex ">

                </div>


            </div>
        </div>
    </div>
    <div class="container">
        <div class="mb-3">
            <button type="button" class="btn btn-danger w-100 shadow" onclick="endCall()"><i class="fas fa-phone-slash"></i> Leave Consultation Session</button>
        </div>
        <div class="h6 mb-0 smallTxt">Consultation #<?= $vcdata['code'] ?></div>
        <div class="bg-white shadow p-2" style="overflow: hidden;">
            <div id="meet" class="w-100 m-0" style="min-height: 500px;"></div>
        </div>

    </div>


    <script src=" https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <script src='https://meet.jit.si/external_api.js'></script>

    <script>
        const domain = 'meet.jit.si';
        const options = {
            roomName: 'C' + '<?= $vcdata['code'] ?>',
            width: $("#meet").width(),
            height: $("#meet").height(),
            parentNode: document.querySelector('#meet'),
            userInfo: {

                displayName: '<?= $display_name ?>'
            }
        };
        const api = new JitsiMeetExternalAPI(domain, options);
        // set new password for channel
        api.addEventListener('participantRoleChanged', function(event) {
            if (event.role === "moderator") {
                api.executeCommand('password', '<?= $vcdata['password'] ?>');
                // window.close();
            }

        });


        api.on('passwordRequired', function() {
            api.executeCommand('password', '<?= $vcdata['password'] ?>');
        });


        function endCall() {
            if (confirm("Are you sure?")) {


                window.close();

            }

        }
    </script>



</body>

</html>