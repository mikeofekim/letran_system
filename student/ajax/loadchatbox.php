<?php
session_start();
include('../../php/db_config.php');
$doc = $_POST['doc'];
$id = $_POST['id'];

$html1 = '';

$sql = "SELECT * FROM useraccount b INNER JOIN doctortbl a ON  b.linkedAccount = a.doctorID  WHERE b.userAccountID = $doc";
// echo $sql;
$aa = mysqli_query($conn, $sql);
if ($aa->num_rows > 0) {
    $doc = $aa->fetch_assoc();



    $html1 .= '<div class="d-flex align-items-center py-2">
        <div class="me-3">
            <img src="../assets/images/profiledefault.png" class="bg-light shadow round-2" height="40" alt="" />
        </div>
        <div>
            <div class="h6 fw-bold mb-0">Dr. ' . $doc['firstName'] . " " . $doc['lastName'] . ' <a onclick="viewdoc(' . $doc['doctorID'] . ')" style="cursor: pointer"><i class="fas fa-external-link-alt"></i></a></div>
            <div class="smallTxt mb-0">' . $doc['specialization'] . '</div>
        </div>

    </div>';
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
        <div class="me-3"><a style="cursor: pointer"  data-bs-toggle="modal" id="attachbtn" data-bs-target="#attach"><i class="fas fa-paperclip"></i></a></div>
            <div class="me-3"><i class="fas fa-image" style="cursor:pointer" onclick="imgattach()"></i></div>
            <div style="width:100%">
                <!-- <input type="text" /> -->

                <textarea name="" class="form-control round-2" id="mymessage" placeholder="Send message" id="" cols="30" rows="1" style="white-space: pre-line;"></textarea>
            </div>
            <div>
                <button class=" btn text-primary" type="submit"><i class="fas fa-paper-plane"></i></button>

    </form>';
    }
    if ($cons['status'] == 0) {

        $html2 .= '   <div>
        Waiting for doctor\'s response.
        <a class="float-end text-decoration-none btn btn-danger btn-sm " style="cursor: pointer" onclick="cancelreq()">Cancel request</a>
    </div>
';
    }
    if ($cons['status'] == 2) {

        $html2 .= '  <div class="d-flex justify-content-between">
        <div class="h6">
            This consultation is closed.
        </div>
        <div class="">
            <button class="btn border bg-white shadow-sm btn-sm " style="cursor:pointer" onclick="openFinalize()">View Result</button>
        </div>
    </div>';
    }
}


exit(json_encode(array($html1, $html2)));
