<?php
session_start();
include 'php/db_config.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <link rel="shortcut icon" href="favicon.png" type="image/x-icon">
    <link rel="icon" href="favicon.png" type="image/x-icon">
    <title>Letran - Manaoag | Signup</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="css/style.css" />
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        .cards {
            min-height: 300px;
        }

        .inputs {
            min-width: 300px;
        }
       .image{
           margin-top: 50px;
           margin-left: 50px;
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
    <div class="d-flex justify-content-center align-items-center" style="min-height: 100vh; " data-aos="flip-right">
        <div class="card round-1 m-3 border-0 shadow-sm" style="max-width: 1000px;">
            <div class="card-body">
                <div class="row">

                    <div class="col-md-5">
                        <div>
                            

                            <div class="d-flex align-items-center mb-3 d-none d-md-block image">
                                <img src="assets/images/letran_logo.png" style="object-fit: contain; width: 300px" alt="" />
                            </div>

                            <img src="img/consultation.jpg" alt="" style="width: 100%;" class="round-2 mb-3">
                            <div class="smallTxt text-center">Already have account?</div>
                            <a href="signin.php" class="btn  btn-light shadow-sm w-100 mb-3 ">Signin</a>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div>
                            <form action="" method="post" id="signup-form" data-aos="fade-up">
                                <div class="h4 fw-bold text-primary">Sign up</div>
                                <div class="smallTxt fw-bold">Personal Information</div>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <div class="smallTxt">Firstname</div>
                                        <input type="text" class="form-control mb-2 round-2" name="firstname" id="fname" required>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="smallTxt">Middlename</div>
                                        <input type="text" class="form-control mb-2 round-2" name="middlename">
                                    </div>
                                    <div class="col-md-4">
                                        <div class="smallTxt">Lastname</div>
                                        <input type="text" class="form-control mb-2 round-2" name="lastname" id="lname" required>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="smallTxt">Course</div>
                                        <input type="text" class="form-control mb-2 round-2" name="course" id="course" required>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="smallTxt">Year</div>
                                        <input type="text" class="form-control mb-2 round-2" name="year" pattern="[0-9]{0,16}" id="year" required>
                                    </div>


                                    <div class="col-md-4">
                                        <div class="smallTxt">Birthday</div>
                                        <input type="date" class="form-control mb-2 round-2" name="birthday" id="bd" required>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="smallTxt">Gender</div>
                                        <select class="form-select round-2 mb-2" name="gender" required>
                                            <option value="">- - -</option>
                                            <option value="0">Male</option>
                                            <option value="1">Female</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="smallTxt fw-bold">Contact Information</div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="smallTxt">Email</div>
                                        <input type="email" class="form-control mb-2 round-2" name="email" id="email" required>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="smallTxt">Phonenumber</div>
                                        <input type="text" class="form-control mb-2 round-2" pattern="[0-9]{0,11}" name="phone" required>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="smallTxt">Region</div>
                                        <select id="regions" class="form-select round-2 mb-2" onchange="loadProvince($(this).val())" required>
                                        </select>
                                        <input type="hidden" id="myregions" name="region">
                                    </div>
                                    <div class="col-md-4">
                                        <div class="smallTxt">Province</div>
                                        <select id="provinces" class="form-select round-2 mb-2" onchange="loadCity($(this).val())" required>
                                        </select>
                                        <input type="hidden" id="myprovinces" name="province">
                                    </div>
                                    <div class="col-md-4">
                                        <div class="smallTxt">Municipality/City</div>
                                        <select id="cities" class="form-select round-2 mb-2" name="muncity" required>
                                        </select>

                                    </div>
                                    <div class="col-md-12">
                                        <div class="smallTxt">Address</div>
                                        <input type="text" class="form-control mb-2 round-2" name="address"  id="address" required>
                                    </div>
                                </div>
                                <div class="smallTxt fw-bold">Account Information</div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="smallTxt">School ID</div>
                                        <input type="text" class="form-control mb-2 round-2" name="school_id" pattern="[0-9]{0,16}" id="school_id" required>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="smallTxt">Username <span class="fw-light fst-italic text-muted">(A-Z,a-z,0-9 | 8+ characters)</span></div>
                                        <input type="text" class="form-control mb-2 round-2" name="username" minlength="8" pattern="[A-Za-z0-9]{8,16}" id="username" required>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="smallTxt">Password <span class="fw-light fst-italic text-muted">(A-Z,a-z,0-9 | 8+ characters)</span></div>
                                        <input type="password" class="form-control mb-2 round-2" name="password" id="password" minlength="8" pattern="[A-Za-z0-9]{8,16}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="smallTxt">Confirm Password</div>
                                        <input type="password" class="form-control mb-2 round-2" id="confirm-password" required>
                                    </div>
                                </div>

                                <div>

                                    <button type="submit" name="submit" class="btn px-3 round-2 btn-sm shadow btn-primary fw-bold float-end">Submit</button>
                                   
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>





    <!-- MDB -->
    <script type="text/javascript" src="js/mdb.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        function yearsDiff(d1, d2) {
            let date1 = new Date(d1);
            let date2 = new Date(d2);
            let yearsDiff = date2.getFullYear() - date1.getFullYear();
            return yearsDiff;
        }
        var code = "";

        function mytimer() {
            var timer = 5000;


            var myvar = setInterval(() => {
                $("#timer").text("(" + timer / 1000 + ")");
                timer -= 1000;

            }, 1000);

            setTimeout(() => {
                clearInterval(myvar);
                $("#resend").attr("disabled", false);
                $("#timer").text("");
            }, 6000);

        };



        AOS.init();
        $.getJSON('extras/regions.json', function(data) {
            $("#regions").html('<option value="">- - -</option>');
            data.forEach(element => {
                var html = `<option value="${element.key}">${element.name}</option>`;
                $("#regions").append(html);
            });
        })

        function loadProvince(myKey) {
            $.getJSON('extras/provinces.json', function(data) {
                $("#provinces").html('<option value="">- - -</option>');
                data.forEach(element => {
                    if (element.region == myKey) {
                        var html = `<option value="${element.key}">${element.name}</option>`;
                        $("#provinces").append(html);
                    }

                });
            })

            $("#myregions").val($("#regions option:selected").text());
        }

        function loadCity(myKey) {
            $.getJSON('extras/cities.json', function(data) {
                $("#cities").html('<option value="">- - -</option>');
                data.forEach(element => {
                    if (element.province == myKey) {
                        var html = `<option value="${element.name}">${element.name}</option>`;
                        $("#cities").append(html);
                    }

                });
            })

            $("#myprovinces").val($("#provinces option:selected").text());
        }








        $("#signup-form").submit(function(e) {
            e.preventDefault();

           if ($("#confirm-password").val() != $("#password").val()) {
                Swal.fire(
                    'Oops!',
                    'You password did not match.',
                    'info'
                )
            } else {

                $.post("ajax/check-id.php", {
                    school_id: $("#school_id").val()
                }, function(data) {
                    if (data == 0) {
                        Swal.fire(
                            'Oops!',
                            'Your ID is not registered to our database.',
                            'info'
                        )

                        }else {
                            
                            $.post("ajax/signup.php",
                                $("#signup-form").serialize(),
                                function(response) {
                                    if (response == 1) {
                                        window.location.href = "signin.php?status=registered";
                                    } else console.log(response);
                                });
                    }
                });



            }

        });



    </script>
</body>

</html>