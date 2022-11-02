<?php
session_start();
include '../php/db_config.php';
if (isset($_SESSION['userType'])) {
    if ($_SESSION['userType'] != 2) {
        header('Location: ../login.php');
    }
} else {
    header('Location: ../login.php');
}
$_SESSION['symptoms'] = [];
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
    <link rel="stylesheet" href="../css/style.css?" />

    <title>iConsult | Check Health</title>
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

                        <div class="h4 fw-bolder"><span id="backmobile"><a class="pointer"><i class="fas fa-chevron-left"></i></a></span> Consultations</div>
                        <div class="row">
                            <div class="col-md-4">
                                <div id="main1" class="card round-2 cards border-0">
                                    <div class="card-body p-2">

                                        <div class="myinbox" id="myinbox" style="overflow-y: auto">
                                            <div id="" style="overflow-y: auto">
                                                <div class="" id="requests"></div>
                                                <div id="active"></div>
                                                <div class="" id="closed"></div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div id="main2" class="card round-1 cards">
                                    <div class="card-header bg-transparent border-bottom" id="conshead">

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


    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Final</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" id="finalizeform">
                        <div class="smallTxt">Symptoms</div>
                        <textarea name="" id="a" cols="30" rows="3" class="form-control" style="white-space: pre-line;" required></textarea>
                        <div class="smallTxt">Diagnosis</div>
                        <textarea name="" id="b" cols="30" rows="3" class="form-control" style="white-space: pre-line;" required></textarea>
                        <div class="smallTxt">Recommendation</div>
                        <textarea name="" id="c" cols="30" rows="5" class="form-control" style="white-space: pre-line;" required></textarea>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="closefinalize" data-bs-dismiss="modal">Close</button>
                    <button type="submit" form="finalizeform" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary d-none" id="view-patient" data-bs-toggle="modal" data-bs-target="#patient-info">
        Launch demo modal
    </button>

    <!-- Modal -->
    <div class="modal fade" id="patient-info" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Patient Information</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="patient-details">

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
    <script>
        var screen = 0;

        updateScreen();
        loadconsultations();

        $("#backmobile").hide();
        window.addEventListener('resize', updateScreen);

        $("#navconsult").addClass("bg-info text-white shadow");
        var selected = '0';
        var doc = '0';
        var code = '';
        chatBox = document.querySelector("#chats");

        setInterval(() => {
            loadconvo();
            loadconsultations();
            if (!chatBox.classList.contains("active") && window.innerWidth >= 600) {
                scrollToBottom();
            }
            console.log("Fetching chat");
        }, 2000);


        function viewpatient(id) {
            $("#patient-details").load("ajax/loadpatientdetails.php", {
                id
            });
            $("#view-patient").click();


        }

        function loadconsultations() {
            $.post('ajax/loadconsultation.php', function(data) {
                var array = JSON.parse(data);
                $("#active").html(array[0]);
                $("#requests").html(array[1]);
                $("#closed").html(array[2]);
            });
        }

        function loadconvo() {
            $("#chats").load("ajax/loadconvo.php", {
                id: selected,
                doc: doc,
                code: code
            });

        }


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

                $("#main1").show('');
                $("#main2").hide('');
                $("#backmobile").hide();
                screen = 0;
            } else {

            }
        });



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

        function acceptstate(mystate, id, id1, id2) {
            Swal.fire({
                title: 'Accept?',
                text: "This consultation will be opened.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.isConfirmed) {

                    selected = id;
                    doc = id1;
                    code = id2;


                    updateStatus(mystate);

                    openChat(selected, doc, code);
                    loadconsultations();


                }
            })
        }

        function rejectstate(mystate, id, id1, id2) {
            Swal.fire({
                title: 'Decline?',
                text: "This request will be removed.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.isConfirmed) {

                    selected = id;
                    doc = id1;
                    code = id2;

                    updateStatus(mystate);
                    loadconsultations();

                }
            })
        }

        function endstate(mystate) {
            Swal.fire({
                title: 'Are you sure?',
                text: "This consultation will be closed.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.isConfirmed) {
                    updateStatus(mystate);
                    loadchatbox();
                    loadconsultations();

                }
            })
        }

        function updateStatus(mystate) {


            $.ajax({
                url: "ajax/updatestatus.php",
                type: "POST",
                data: {
                    id: selected,
                    status: mystate
                },
                success: function(res) {

                    if (res == 11) {
                        Swal.fire(
                            'Request accepted!',
                            'Consultation is now active.',
                            'success'
                        )
                    } else if (res == 13) {
                        Swal.fire(
                            'Oops!',
                            'You can only have 1 active consultation session at a time.',
                            'info'
                        )
                    } else if (res == 21) {
                        Swal.fire(
                            'Request declined!',
                            'This will now be removed.',
                            'success'
                        )
                    } else if (res == 31) {
                        Swal.fire(
                            'Ended!',
                            'Consultation is closed.',
                            'success'
                        )
                    }
                }
            });


        }

        function sendme(data) {

            cinfo = data;

        }


        $("#finalizeform").submit(function(event) {
            event.preventDefault();



            $.post("ajax/finalize.php", {
                conid: selected,
                a: $("#a").val(),
                b: $("#b").val(),
                c: $("#c").val()
            }, function(data) {
                if (data == 1) {
                    $("#closefinalize").click();
                    Swal.fire(
                        'Finalized!',
                        'Result has been forwarded',
                        'success'
                    );

                    loadchatbox();
                } else {
                    Swal.fire(
                        'Oops!',
                        'Already finalized',
                        'success'
                    )
                }
                loadchatbox();
            });



        });

        function imgattach() {
            $("#file").click();
        }

        function selimg() {
            $("#imagesend").submit();
        }

        $("#imagesend").submit(function(e) {

            e.preventDefault();

            $("#sending-text").removeClass("d-none");
            $(".d-buttons").addClass("d-none");
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
                        $(".d-buttons").removeClass("d-none");
                        loadconvo();

                    },
                });
            } else {
                alert("Please select a file.");
            }
            scrollToBottom();
        });


        function initiate_video(id) {
            Swal.fire({
                title: 'Start?',
                text: "You are creating a consultation session.",
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Start'
            }).then((result) => {
                if (result.isConfirmed) {


                    $("#sending-text").removeClass("d-none");
                    $(".d-buttons").addClass("d-none");

                    $.post("ajax/sendattach.php", {
                        conid: selected,
                        doc: doc,
                        message: id
                    }, function(data) {



                        $("#sending-text").addClass("d-none");
                        $(".d-buttons").removeClass("d-none");
                        // alert(data);

                        if (data == 2) {
                            Swal.fire(
                                'Failed!',
                                'Not sent',
                                'info'
                            )
                        }
                    });
                    loadconvo();
                    scrollToBottom();
                }
            })

        }
    </script>
</body>

</html>