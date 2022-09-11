<?php
session_start();
include('../php/db_config.php');

$id = $_GET['4762387523'];


$sql = "SELECT * FROM useraccount a INNER JOIN doctortbl b ON a.linkedAccount = b.doctorID WHERE a.linkedAccount=$id AND a.userType = 2";
$result = mysqli_query($conn, $sql);

$doc = $result->fetch_assoc();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../css/style.css" />

    <title>iConsult | Home</title>
    <style>
        .mygradient {
            background-image: linear-gradient(to left bottom, #ffffff, #f1feff, #d3ffff, #c0fff5, #d0ffcb);
        }

        .lowvh {
            height: calc(100vh - 315px);
        }

        table tr .pd {
            padding: 15px;
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

                        <div class="h4 mb-0 fw-bold"><a href="doctors.php"><i class="fas fa-angle-left"></i></a> Doctors</div>

                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="card  border-0 round-1  mb-3 ">
                                    <div class="card-body p-0">
                                        <div class="row">

                                            <div class="col-md-8">
                                                <div class="card round-2 mb-3 ">
                                                    <div class="card-body">
                                                        <div class="mb-2 me-2 round-1 me-3"><img src="../assets/images/<?= $doc['imagefile'] ?>" class="round shadow-sm" height="60" width="60" alt="">
                                                        </div>
                                                        <form id="doctorform" method="post" action="">
                                                            <div class="h6 fw-bold text-primary">
                                                                Personal Information
                                                            </div>
                                                            <input type="hidden" class="form-control mb-2" name="id" value="<?= $doc['doctorID'] ?>" required>
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <div class="smallTxt">Firstname</div>
                                                                    <input type="text" class="form-control mb-2 round-2" name="fname" value="<?= $doc['firstName'] ?>" required>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="smallTxt">Middlename</div>
                                                                    <input type="text" class="form-control mb-2 round-2" name="mname" value="<?= $doc['middleName'] ?>">
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="smallTxt">Lastname</div>
                                                                    <input type="text" class="form-control mb-2 round-2" name="lname" value="<?= $doc['lastName'] ?>" required>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="smallTxt">Address</div>
                                                                    <input type="text" class="form-control mb-2 round-2" name="address" value="<?= $doc['address'] ?>" required>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="smallTxt">Email</div>
                                                                    <input type="email" class="form-control mb-2 round-2" name="email" value="<?= $doc['email'] ?>" required>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="smallTxt">Contact</div>
                                                                    <input type="text" class="form-control mb-2 round-2" name="contact" value="<?= $doc['contact'] ?>" required>
                                                                </div>

                                                            </div>
                                                            <hr>
                                                            <div class="h6 fw-bold text-primary">Work Information</div>
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <div class="smallTxt">Doctor License #</div>
                                                                    <input type="text" class="form-control mb-2 round-2" name="license" value="<?= $doc['license'] ?>" required>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="smallTxt">Specialization</div>
                                                                    <select id="" class="form-select mb-2 round-2" name="sp" required>
                                                                        <option value="">- - -</option>
                                                                        <option value="General Practice" <?= ($doc['specialization'] == 'General Practice') ? "selected" : "" ?>>General Practice</option>
                                                                        <option value="Opthalmologist" <?= ($doc['specialization'] == 'Opthalmologist') ? "selected" : "" ?>>Opthalmologist</option>
                                                                        <option value="Dermatologist" <?= ($doc['specialization'] == 'Dermatologist') ? "selected" : "" ?>>Dermatologist</option>
                                                                        <option value="Dentist" <?= ($doc['specialization'] == 'Dentist') ? "selected" : "" ?>>Dentist</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-4">

                                                                </div>

                                                                <div class="col-md-8">

                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="smallTxt">Hospital/Clinic</div>
                                                                    <input type="text" class="form-control mb-2 round-2" name="hospital" value="<?= $doc['hospital'] ?>" required>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="smallTxt">Address</div>
                                                                    <input type="text" class="form-control mb-2 round-2" name="h_address" value="<?= $doc['h_address'] ?>" required>
                                                                </div>
                                                            </div>

                                                            <hr>
                                                            <div class="text-end">
                                                                <button type="submit" class="btn btn-success round-1 shadow"><i class="far fa-save"></i></button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="card round-2 mb-3">
                                                    <div class="card-body">
                                                        <div class="h6 fw-bold text-primary">
                                                            Account Maintenance
                                                        </div>
                                                        <?php

                                                        if ($doc['a_status'] == 1) {
                                                            echo '<div class="bg-light p-3 mb-2 round-2">
                                                                    <div class="h6 mb-0 text-success"><i class="fas fa-check me-2"></i>Doctor is active.</div>
                                                                </div>';
                                                        } else if ($doc['a_status'] == 2) {
                                                            echo '<div class="bg-light p-3 mb-2 round-2">
                                                                    <div class="h6 mb-0 text-danger"><i class="fas fa-times me-2"></i>Account deactivated.</div>
                                                                </div>';
                                                        }



                                                        ?>

                                                        <div class="smallTxt fw-bold">Username</div>
                                                        <input type="text" class="form-control mb-5  round-2" value="<?= $doc['username'] ?>" readonly>
                                                        <button class="btn btn-primary btn-sm w-100 mb-2 round-1 shadow fw-bold">Reset Password</button>
                                                        <?php

                                                        if ($doc['a_status'] == 1) {
                                                            echo '<button class="btn btn-light text-danger fw-bold btn-sm w-100 shadow-sm round-1" onclick="accountStatus(' . $doc['userAccountID'] . ',2)">Deactivate Account</button>';
                                                        } else {
                                                            echo '<button class="btn btn-light text-danger fw-bold btn-sm w-100 shadow-sm round-1" onclick="accountStatus(' . $doc['userAccountID'] . ',1)">Re-activate Account</button>';
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
    </div>



    <script src=" https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $("#navdoctors").addClass("bg-info text-white shadow");

        $("#doctorform").submit(function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Are you sure?',
                text: "Update doctor's information.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.post('ajax/updateDoctor.php', $("#doctorform").serialize(), function(data) {
                        // alert(data);
                        if (data == 1) {
                            Swal.fire(
                                'Updated!',
                                'Doctor\'s Information has been updated',
                                'success'
                            )
                        }
                        // $("#closeform").click();
                    });
                }
            })

        });

        function accountStatus(id, code) {
            Swal.fire({
                title: 'Are you sure?',
                text: "Change account status.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.post("ajax/account-status.php", {
                        id: id,
                        status: code
                    }, function(response) {
                        if (response == 1) {
                            location.reload();
                        }
                    });
                }
            })

        }
    </script>
</body>

</html>