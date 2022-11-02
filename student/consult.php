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
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <title>iConsult | Consultation</title>
    <style>
        .cards {
            height: calc(100vh - 93px);
        }

        .myinbox {
            height: calc(100vh - 140px);
        }

        .sender {
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
            border-bottom-left-radius: 15px;
        }

        .receiver {
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
            border-bottom-right-radius: 15px;
        }

        .chats {
            height: calc(100vh - 170px);
            overflow-y: auto;
        }


        .reqs:hover {
            cursor: pointer;
            background-color: #eee;
        }

        /* body {
            background-image: url("assets/images/bg.jpg");
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        } */
    </style>
</head>

<body>
    <div class="container-fluid p-0">
        <?php include 'components/navbar.php'; ?>
        <div class="row m-0">
            <?php include 'components/sidebar.php'; ?>
            <div class="col-md-9 col-sm-12 col-12">
                <div class="vh-100 py-3">
                    <div class="p-3">
                        <button class="btn btn-outline-primary shadow-sm round-1 fw-bold btn-sm float-end px-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">Find a Doctor <i class="fas fa-search"></i></button>
                        <div class="h4 fw-bolder"><span id="backmobile"><a class="pointer"><i class="fas fa-chevron-left"></i></a></span> Consult</div>
                        <div class="row">
                            <div class="col-md-4">
                                <div id="main1" class="card round-2 cards border-0">
                                    <div class="card-body p-2">

                                        <div class="myinbox" id="myinbox" style="overflow-y: auto">


                                            <div id="requests">
                                            </div>
                                            <div class="" id="active"></div>
                                            <div class="" id="closed"></div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div id="main2" class="card round-1 cards">
                                    <div class="card-header bg-transparent border-bottom  " id="conshead">
                                        <div class="h6 fw-light fst-italic text-muted mb-0">Choose a consultation</div>
                                    </div>
                                    <div id="chats" class="card-body pb-0 chats">

                                    </div>


                                    <div class="card-footer" id="consfoot">

                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header mb-0">
            <h5 id="offcanvasRightLabel">Doctors</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <!-- <div class="h6 fw-bold">Find Doctor</div> -->
            <select name="" id="category" class="form-control bg-white round-2 mb-2" onchange="load_doctor()">
                <option value="0">All</option>
                <option value="1">General Practice</option>
                <option value="2">Opthalmologist</option>
                <option value="3">Dermatologist</option>
            </select>
            <input type="text" id="search" class="form-control mb-3 round-2" placeholder="Search" onkeyup="load_doctor()">
            <div id="doctors">

            </div>
        </div>
    </div>
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary d-none" id="viewdoc" data-bs-toggle="modal" data-bs-target="#exampleModal">
        Launch demo modal
    </button>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Doctor Information</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="docdetails">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="attach" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">My History</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="">
                        <?php

                        $sql = "SELECT * FROM diagnosis WHERE userid = " . $_SESSION['user']['userID'] . " ORDER BY id DESC";
                        $result = mysqli_query($conn, $sql);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $output = json_decode($row['result']);

                        ?>

                                <div class="
                                                    bg-white
                                                    p-2
                                                    border
                                                    round-1
                                                    mb-3
                                                ">
                                    <div>
                                        <a style="cursor: pointer" class="text-decoration-none smallTxt float-end mb-0" onclick="attachme(<?= $row['id'] ?>)">Send <i class="fas fa-share-square"></i></a>
                                        <div class="smallTxt mb-0"><?= $row['date'] ?></div>

                                        <div class="bg-light round-2 p-2">
                                            <div class="smallTxt mb-0">Symptoms:
                                                <?php
                                                $symp = json_decode($row['symptoms']);
                                                foreach ($symp as $s) {
                                                    $sql = "SELECT * FROM symptoms WHERE symptomID = $s";
                                                    $res = mysqli_query($conn, $sql)->fetch_assoc();
                                                    echo $res['name'] . ", ";
                                                }

                                                ?>
                                            </div>
                                            <div class="smallTxt mb-0">Top result: <span class="fw-bold"><?= (count($output) != 0) ? $output[0]->Issue->Name : "No result" ?></span></div>
                                        </div>


                                    </div>
                                    <!-- <div class="ms-auto">View</div> -->
                                </div>
                        <?php

                            }
                        }

                        ?>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <button type="button" class="btn btn-primary d-none" id="finalizeopen" data-bs-toggle="modal" data-bs-target="#finalize">
        Launch demo modal
    </button>

    <div class="modal fade" id="finalize" tabindex="-1" aria-labelledby="finalize" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable moddal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Consultation Summary</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="result"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <form action="" class="d-none" id="imagesend" method="post" enctype="multipart/form-data">
        <input type="file" name="file" id="file" accept="image/*" onchange="selimg()">
        <input type="submit" value="Upload Image" name="submit" id="imagebtn">
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
        var screen = 0;
        updateScreen();
        $("#backmobile").hide();
        window.addEventListener('resize', updateScreen);


        function updateScreen() {
            if (window.innerWidth < 600) {
                $("#myinbox").removeClass('myinbox');
                $("#main1").removeClass('cards');
                if (screen == 0) {
                    $("#main2").hide();
                }

            } else {
                $("#myinbox").addClass('myinbox');
                $("#main1").addClass('cards');
                $("#main2").show();
                $("#main1").show();
                $("#backmobile").hide();
            }
        }

        $("#backmobile").click(function() {
            if (window.innerWidth < 600) {
                screen = 0;
                $("#main1").show('');
                $("#main2").hide('');
                $("#backmobile").hide();
            } else {

            }
        });

        loadconsultation();

        function loadconsultation() {

            $.post('ajax/loadconsultation.php', function(data) {
                var array = JSON.parse(data);
                $("#active").html(array[0]);
                $("#requests").html(array[1]);
                $("#closed").html(array[2]);

            });
        }

        load_doctor();

        function load_doctor() {
            $("#doctors").load('ajax/loaddoctors.php', {
                search: $("#search").val(),
                category: $("#category").val()
            });
        }

        function loadconvo() {
            $("#chats").load("ajax/loadconvo.php", {
                id: selected,
                doc: doc,
                code: code
            });
        }

        $("#navconsult").addClass("bg-info text-white shadow");
        var selected = '0';
        var doc = '0';
        var code = '';
        chatBox = document.querySelector("#chats");
        setInterval(() => {
            console.log("Fetching chat");

            loadconvo();
            loadconsultation();
            if (!chatBox.classList.contains("active") && window.innerWidth >= 600) {
                scrollToBottom();
            }

        }, 2000);

        function openChat(id, id1, id2) {
            selected = id;
            doc = id1;
            code = id2;
            loadchatbox();
            loadconvo();




            if (window.innerWidth < 600) {

                $("#main2").show('');
                $("#main1").hide('');
                $("#backmobile").show();
                screen = 1;
            } else {

            }

            scrollToBottom();

        }

        function loadchatbox() {
            $.post('ajax/loadconvobox.php', {
                doc: doc,
                id: selected
            }, function(data) {
                var array = JSON.parse(data);
                $("#conshead").html(array[0]);
                $("#consfoot").html(array[1]);
            });
        }

        chatBox.onmouseenter = () => {

            chatBox.classList.add("active");

        }

        chatBox.onmouseleave = () => {

            chatBox.classList.remove("active");
        }

        function scrollToBottom() {

            chatBox.scrollTop = chatBox.scrollHeight;

            // $('#chats').stop().animate({
            //     scrollTop: $('#chats')[0].scrollHeight
            // }, 800);


        }

        function sendRequest(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "Request for Consultation",
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.isConfirmed) {


                    $.post('ajax/sendrequest.php', {
                        id: id
                    }, function(data) {
                        if (data == 1) {
                            loadconsultation();
                            Swal.fire(
                                'Sent!',
                                'Your request has been submitted.',
                                'success'
                            );
                        }
                        if (data == 0) {
                            Swal.fire(
                                'Oops!',
                                'You still have active request/consultation.',
                                'warning'
                            );
                        }
                    });
                }
            })
        }

        function viewdoc(iddoc) {
            $("#docdetails").load("ajax/loaddocdetails.php", {
                id: iddoc
            });
            $("#viewdoc").click();

        }

        function attachme(id) {
            $("#sending-text").removeClass("d-none");
            $.post("ajax/sendattach.php", {
                conid: selected,
                doc: doc,
                message: id
            }, function(data) {
                // alert(data);
                $("#sending-text").addClass("d-none");
                loadconvo();
                if (data == 2) {
                    Swal.fire(
                        'Failed!',
                        'Not sent',
                        'info'
                    )
                }

            });
            scrollToBottom();
        }

        function openFinalize() {
            $("#finalizeopen").click();
            $("#result").load('ajax/loadfinalize.php', {
                id: selected
            });
        }

        function imgattach() {
            $("#file").click();
        }

        function selimg() {
            $("#imagesend").submit();
        }

        $("#imagesend").submit(function(e) {

            e.preventDefault();
            $("#sending-text").removeClass("d-none");
            var fd = new FormData();
            var files = $('#file')[0].files;

            // Check file selected or not
            if (files.length > 0) {
                fd.append('file', files[0]);
                fd.append('conid', selected);
                fd.append('doc', doc);
                $.ajax({
                    url: 'ajax/sendimage.php',
                    type: 'post',
                    data: fd,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        // if (response != 0) {
                        //     $("#img").attr("src", response);
                        //     $(".preview img").show(); // Display image element
                        // } else {
                        //     alert('file not uploaded');
                        // }
                        // alert(response);
                        $("#sending-text").addClass("d-none");
                        loadconvo();
                        scrollToBottom();
                    },
                });
            } else {
                alert("Please select a file.");
            }
        });



        function deleteconsultation(id) {

            Swal.fire(
                'Deleted!',
                'Your request has been deleted.',
                'success'
            )

            $.post('ajax/cancelrequest.php', {
                id: id
            }, function() {
                loadconsultation();
            });
        }
    </script>
</body>

</html>