<?php
session_start();
include('../php/db_config.php');
if (isset($_SESSION['userType'])) {
    if ($_SESSION['userType'] != 1) {
        header('Location: ../login.php');
    }
} else {
    header('Location: ../login.php');
}

$user = $_SESSION['user'];
$userdata = $_SESSION['userdata']
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

    <title>iConsult | Account</title>
    <style>
        .mycard {
            height: calc(100vh - 95px);
        }
    </style>
</head>

<body>
    <div class="container-fluid p-0">
        <?php include('components/navbar.php') ?>
        <div class="row m-0">
            <?php include('components/sidebar.php') ?>
            <div class="col-md-9 col-sm-12 col-12">
                <div class="vh-100 py-3">
                    <div class="p-3">
                        <div class="h4 fw-bolder mb-5">Account settings</div>

                        <div>


                            <div class="h6 text-primary fw-bold  mb-0">Credentials</div>
                            <div class="smallTxt text-muted fst-italic mb-2">Click to edit.</div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="smallTxt fw-bold  shadow-sm ">Username</div>
                                    <input type="text" class="form-control round-2 mb-2 pointer" value="<?= $userdata['username'] ?>" readonly onclick="editThis('username', 'text', '[A-Za-z0-9]{8,}', '8 characters and above, A-Z|a-z|0-9', $(this).val())">
                                </div>

                            </div>
                            <div class="col-md-4">
                                <button class="btn btn-primary round-2 smallTxt fw-bold shadow" data-bs-toggle="modal" data-bs-target="#exampleModal1">Change password</button>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Button trigger modal -->
    <button type="button" id="openmodal" class="btn btn-primary d-none" data-bs-toggle="modal" data-bs-target="#exampleModal">
        Launch demo modal
    </button>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update <span class="mytext text-lowercase"></span> </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" id="editform" method="post">
                        <!-- <div class="smallTxt fw-bold">Enter new <span class="mytext"></span></div> -->
                        <input type="hidden" id="edittype">
                        <input id="newtext" class="form-control round-2" required>
                        <div class="smallTxt" id="mymessage"></div>
                    </form>

                </div>
                <div class="modal-footer">
                    <button type="submit" form="editform" class="btn btn-primary smallTxt fw-bold round-2 shadow">Save changes</button>
                </div>
            </div>
        </div>
    </div>




    <!-- Modal -->
    <div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Change password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" id="editform1" method="post">
                        <!-- <div class="smallTxt fw-bold">Enter new <span class="mytext"></span></div> -->
                        <input type="hidden" id="edittype">
                        <div class="smallTxt fw-bold">Old password</div>
                        <input id="oldpass" type="password" class="form-control round-2" pattern="[A-Za-z0-9]{8,}" required>
                        <div class="smallTxt fw-bold">New password</div>
                        <input id="newpass" type="password" class="form-control round-2" pattern="[A-Za-z0-9]{8,}" required>
                        <div class="smallTxt fw-bold">Repeat password</div>
                        <input id="rpass" type="password" class="form-control round-2" pattern="[A-Za-z0-9]{8,}" required>
                        <div class="smallTxt" id="mymessage"></div>
                        <div class="smallTxt">8 characters and above, A-Z|a-z|0-9</div>
                    </form>

                </div>
                <div class="modal-footer">
                    <button type="submit" form="editform1" class="btn btn-primary smallTxt fw-bold round-2 shadow">Save changes</button>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8" crossorigin="anonymous"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <script>
        $("#navaccount").addClass("bg-info text-white shadow");

        window.addEventListener('resize', updateScreen);

        function updateScreen() {
            if (window.innerWidth < 600) {
                $("#rightpanel").removeClass('mycard');
            } else {
                $("#rightpanel").addClass('mycard');
            }
        }


        function editThis(key, mytype, pattern, message, val) {
            $(".mytext").text(key);
            $("#mymessage").text(message);
            $("#edittype").val(key);
            $("#newtext").get(0).type = mytype;
            $("#newtext").val(val);
            $("#newtext").get(0).pattern = pattern;
            $("#openmodal").click();
        }

        $("#editform").submit(function(e) {
            e.preventDefault();
            var str = $("#edittype").val().toLowerCase();
            $.post('ajax/editprof.php', {
                edittype: $("#edittype").val(),
                newtext: $("#newtext").val()
            }, function(response) {
                // alert(response);
                Swal.fire(
                    'Success!',
                    'Your ' + str + ' has been updated.',
                    'success'
                ).then((result) => {
                    if (result.isConfirmed) {
                        location.reload();
                    }
                })

            });
        });


        $("#editform1").submit(function(e) {
            e.preventDefault();
            var newpass = $("#newpass").val();
            var rpass = $("#rpass").val();

            if (newpass != rpass) {
                alert("Password did not match.");
            } else {

                $.post('ajax/editprof.php', {
                    edittype: 'password',
                    oldpass: $("#oldpass").val(),
                    newtext: newpass
                }, function(response) {
                    // alert(response);
                    if (response == 1) {
                        Swal.fire(
                            'Success!',
                            'Your password has been updated.',
                            'success'
                        ).then((result) => {
                            if (result.isConfirmed) {
                                location.reload();
                            }
                        })

                    } else {
                        alert("Old password entered is incorrect.");
                    }

                });
            }

        });
    </script>
</body>

</html>