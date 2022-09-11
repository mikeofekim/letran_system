<?php
session_start();
include('../../php/db_config.php');
$doc = $_POST['doc'];
$id = $_POST['id'];


$html1 = '';
$html2 = '';


$sql = "SELECT * FROM useraccount b INNER JOIN usertbl a ON  b.linkedAccount = a.userID  WHERE b.userAccountID = $doc";
$aa = mysqli_query($conn, $sql);
$sql = "SELECT * FROM  consultations  WHERE consultationID = $id";
$cons = mysqli_query($conn, $sql)->fetch_assoc();





if ($aa->num_rows > 0) {
    $doc = $aa->fetch_assoc();
    $html1 .= '<div class="d-flex align-items-center py-2">
        <div class="me-3">
            <img src="../assets/images/profiledefault.png" class="round-2 shadow bg-light" height="40" alt="" />
        </div>
        <div>
            <div class="h6 fw-bold mb-0">' . $doc['firstName'] . " " . $doc['lastName'] . '</div>
         
        </div>';



    if ($cons['status'] == 1) {
        $str = 'Consultation#' . $cons['code'];
        $html1 .= '<div class="ms-auto me-3">
            <i class="fas fa-video pointer text-primary" onclick="initiate_video(' . $str . ')"></i>
        </div>
        <div class=align-self-start">
            <button class="btn btn-sm btn-light py-1 border shadow-sm px-3 round-1 smallTxt fw-bold" onclick="endstate(2)">End Consultation</button>

        </div>';
    }

    $html1 .= '</div>';
}
$html2 = '';

$sql = "SELECT * FROM  consultations  WHERE consultationID = $id";
// echo $sql;
$aa = mysqli_query($conn, $sql);
if ($aa->num_rows > 0) {
    $cons = $aa->fetch_assoc();

    if ($cons['status'] == 1) {
        $html2 .= ' <form action="" method="post" id="sendform">
        <div class="d-flex align-items-center">
            <div class="me-3"><i class="fas fa-image" style="cursor:pointer" onclick="imgattach()"></i></div>
            <div style="width:100%">
                <!-- <input type="text" /> -->

                <textarea name="" class="form-control round-2" id="mymessage" placeholder="Send message" id="" cols="30" rows="1" style="white-space: pre-wrap;"></textarea>
            </div>
            <div>
                <button class=" btn text-primary" type="submit"><i class="fas fa-paper-plane"></i></button>

    </form>';
    }
    if ($cons['status'] == 0) {

        $html2 .= 'This consultation is pending.';
    }
    if ($cons['status'] == 2) {

        $html2 .= '  <div class="d-flex justify-content-between">
        <div class="h6">
            This consultation is closed.
        </div>
        <div class="">
            <button class="btn btn-success btn-sm " data-bs-toggle="modal" data-bs-target="#exampleModal">Finalize</button>
        </div>
    </div>';
    }
}


$html2 .= '<script>
$("#sendform").submit(function(event) {
    event.preventDefault();



    $.post("ajax/sendmessage.php", {
        conid: selected,
        doc: doc,
        message: $("#mymessage").val()
    }, function(data) {

    });
    loadconvo();
    scrollToBottom();
    $("#mymessage").val("");

});</script>';
exit(json_encode(array($html1, $html2)));
