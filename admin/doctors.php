<?php
session_start();
include('../php/db_config.php');

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../css/style.css" />

    <title>iConsult | Doctors</title>
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
                        <div class="float-end">
                            <button class="btn btn-sm btn-light border shadow-sm round-1 px-3 fw-bold" data-bs-toggle="modal" data-bs-target="#exampleModal">Add Doctor <i class="fas fa-user-plus"></i></button>
                        </div>
                        <div class="h4 mb-0 fw-bold">Doctors</div>

                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="card border  round-1  mb-3 ">
                                    <div class="card-body p-4">
                                        <div class="d-flex justify-content-between">
                                            <div class="w-100 me-3">
                                                <input type="text" class="form-control round-2 mb-3" id="keyword" placeholder="Search doctor">
                                            </div>
                                            <div>
                                                <button class="btn  btn-primary shadow-sm round-2 px-3 " onclick="loadMe()"><i class="fas fa-search"></i></button>
                                            </div>
                                        </div>


                                        <div class="d-flex align-items-center d-none" id="loading-text">
                                            <div class="spinner-border spinner-border-sm text-primary me-2" role="status">
                                                <span class="visually-hidden">Loading...</span>
                                            </div>
                                            <div class="h6 mb-0 text-primary">
                                                loading doctors...
                                            </div>
                                        </div>
                                        <div id="doctorlists" class="table-responsive">
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


    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Doctor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="float-end">
                        <button type="reset" form="doctorform" class="btn btn-sm btn-light shadow-sm">Reset <i class="fas fa-redo"></i></button>
                    </div>
                    <div class="h6 text-muted fst-italic"><i class="fas fa-info-circle"></i> Please fill up all required fields.</div>
                    <hr>

                    <form id="doctorform" method="post" action="">
                        <div class="h6 fw-bold">
                            Personal Information
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="smallTxt">Firstname</div>
                                <input type="text" class="form-control mb-2" name="fname" required>
                            </div>
                            <div class="col-md-4">
                                <div class="smallTxt">Middlename</div>
                                <input type="text" class="form-control mb-2" name="mname">
                            </div>
                            <div class="col-md-4">
                                <div class="smallTxt">Lastname</div>
                                <input type="text" class="form-control mb-2" name="lname" required>
                            </div>
                            <div class="col-md-6">
                                <div class="smallTxt">Address</div>
                                <input type="text" class="form-control mb-2" name="address" required>
                            </div>
                            <div class="col-md-6">
                                <div class="smallTxt">Email</div>
                                <input type="email" class="form-control mb-2" name="email" required>
                            </div>
                            <div class="col-md-4">
                                <div class="smallTxt">Contact</div>
                                <input type="text" class="form-control mb-2" name="contact" required>
                            </div>

                        </div>
                        <hr>
                        <div class="h6 fw-bold">Work Information</div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="smallTxt">Doctor License #</div>
                                <input type="text" class="form-control mb-2" name="license" required>
                            </div>
                            <div class="col-md-4">
                                <div class="smallTxt">Specialization</div>
                                <select id="" class="form-select mb-2" name="sp" required>
                                    <option value="">- - -</option>
                                    <option value="General Practice">General Practice</option>
                                    <option value="Opthalmologist">Opthalmologist</option>
                                    <option value="Dermatologist">Dermatologist</option>
                                </select>
                            </div>
                            <div class="col-md-4">

                            </div>

                            <div class="col-md-8">

                            </div>
                            <div class="col-md-6">
                                <div class="smallTxt">Hospital/Clinic</div>
                                <input type="text" class="form-control mb-2" name="hospital" required>
                            </div>
                            <div class="col-md-6">
                                <div class="smallTxt">Address</div>
                                <input type="text" class="form-control mb-2" name="h_address" required>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary d-none" data-bs-dismiss="modal" id="closeform">Close</button>
                    <button type="submit" form="doctorform" class="btn btn-primary shadow">Save</button>
                </div>
            </div>
        </div>
    </div>

    <script src=" https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $("#navdoctors").addClass("bg-info text-white shadow");
        loadMe();

        function loadMe() {
            $("#loading-text").removeClass("d-none");
            setTimeout(function() {
                var keyword = $("#keyword").val();
                $("#doctorlists").load('ajax/loadDoctors.php', {
                        keyword: keyword
                    },

                    function() {
                        $("#loading-text").addClass("d-none");
                    });

            }, 1000);
        }

        $("#doctorform").submit(function(e) {
            e.preventDefault();
            $.post('ajax/addDoctor.php', $("#doctorform").serialize(), function(data) {
                if (data == 1) {
                    Swal.fire(
                        'Success!',
                        'Doctor has been added!',
                        'success'
                    )
                    loadMe();
                } else {
                    alert(data);
                }
                $("#closeform").click();
            });
        });

        function deleteDoc(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.post('ajax/deleteDoctor.php', {
                        id: id
                    }, function(data) {
                        if (data == 1) {
                            loadMe();
                            Swal.fire(
                                'Deleted!',
                                'Doctor has been deleted.',
                                'success'
                            )
                        }


                    });

                }
            })
        }
    </script>
</body>

</html>