<?php
session_start();
include('../../php/db_config.php');

$html1 = '';
$sql = "SELECT * FROM  consultations a INNER JOIN useraccount b ON a.patientID = b.userAccountID INNER JOIN usertbl c ON b.linkedAccount = c.userID  WHERE a.doctorID = " . $_SESSION['userdata']['userAccountID'] . " AND status = 1 ORDER BY a.consultationID DESC";

$result = mysqli_query($conn, $sql);

// if ($result->num_rows == 0) {
//     $html1 .= '<div class="g6 fst-italic text-muted mb-2">No consultations at the moment. </div>';
// }

if ($result->num_rows > 0) {
    $html1 .= '<div class="smallTxt fw-bold mb-2">Active <span class="badge rounded-pill bg-primary">' . $result->num_rows . '</span></div>';
    while ($row = $result->fetch_assoc()) {

        $original_date = $row['date'];

        // Creating timestamp from given date
        $timestamp = strtotime($original_date);

        // Creating new date format from that timestamp
        $date = date("F d, h:sa", $timestamp);



        $html1 .= '<div class="d-flex p-3 border round-1 align-items-center  mb-2  reqs" onclick="openChat(' . $row['consultationID'] . ', ' . $row['userAccountID'] . ', ' . $row['code'] . ')">
        <div class="mb me-3"><img src="../assets/images/' . $row['imagefile'] . '" class="round shadow-sm" height="50" width="50" alt=""></div>
            <div class="">
                <div class="smallTxt mb-0">Consultation ID: #' . $row['code'] . '</div>
                <div class="h6 fw-bold mb-0">' . $row['firstName'] . " " . $row['lastName'] . '</div>
                <div class="smallTxt mb-0">' . $date . '</div>
            </div>
        </div>';
    }
}
$html2 = '';

$sql = "SELECT * FROM  consultations a INNER JOIN useraccount b ON a.patientID = b.userAccountID INNER JOIN usertbl c ON b.linkedAccount = c.userID  WHERE a.doctorID = " . $_SESSION['userdata']['userAccountID']  . " AND status = 0 ORDER BY a.consultationID DESC";

$result = mysqli_query($conn, $sql);
echo $conn->error;


if ($result->num_rows > 0) {
    $html2 .= '<div class="smallTxt fw-bold mb-2">Requests <span class="badge rounded-pill bg-warning">' . $result->num_rows . '</span></div>';
    while ($row = $result->fetch_assoc()) {

        $original_date = $row['date'];

        // Creating timestamp from given date
        $timestamp = strtotime($original_date);

        // Creating new date format from that timestamp
        $date = date("F d, h:sa", $timestamp);




        $html2 .= ' <div class="p-3 border round-1  mb-2 reqs">
        <div class="float-end smallTxt">
        New
    </div>
        <div class="d-flex align-items-center">
        <div class="mb me-3"><img src="../assets/images/' . $row['imagefile'] . '" class="round shadow-sm" height="50" width="50" alt=""></div>
         
            <div class="">
                <div class="h6 fw-bold mb-0"> <span onclick="viewpatient(' . $row['linkedAccount'] . ')" style="cursor: pointer;" class="smallTxt text-primary">' . $row['firstName'] . " " . $row['lastName'] . '</span></div>
                <div class="smallTxt mb-0">' . $date . '</div>
            </div>
            </div>
            <div class="d-flex justify-content-end">
                <div>
                    <button class="btn btn-sm btn-danger py-1 shadow-sm px-3 round-1 smallTxt fw-bold me-2" onclick="rejectstate(3, ' . $row['consultationID'] . ', ' . $row['userAccountID'] . ', ' . $row['code'] . ')"><i class="fas fa-times"></i></button>
                </div>
                <div>
                    <button class="btn btn-sm btn-primary py-1 shadow-sm px-3 round-1 smallTxt fw-bold" onclick="acceptstate(1, ' . $row['consultationID'] . ', ' . $row['userAccountID'] . ', ' . $row['code'] . ')">Accept</button>
                </div>
            </div>
        </div>';
    }
}

$html3 = '';

$sql = "SELECT * FROM  consultations a INNER JOIN useraccount b ON a.patientID = b.userAccountID INNER JOIN usertbl c ON b.linkedAccount = c.userID  WHERE a.doctorID = " . $_SESSION['userdata']['userAccountID']   . " AND status = 2 ORDER BY a.consultationID DESC";

$result = mysqli_query($conn, $sql);


if ($result->num_rows > 0) {
    $html3 .= '<div class="smallTxt fw-bold mb-2">Closed <span class="badge rounded-pill bg-success">' . $result->num_rows . '</span></div>';
    while ($row = $result->fetch_assoc()) {

        $original_date = $row['date'];

        // Creating timestamp from given date
        $timestamp = strtotime($original_date);

        // Creating new date format from that timestamp
        $date = date("F d, h:sa", $timestamp);



        $html3 .= '<div class="d-flex p-3 border round-1 align-items-center  mb-2  reqs" onclick="openChat(' . $row['consultationID'] . ', ' . $row['userAccountID'] . ', ' . $row['code'] . ')">
        <div class="mb me-3"><img src="../assets/images/' . $row['imagefile'] . '" class="round shadow-sm" height="50" width="50" alt=""></div>
            <div class="">
                <div class="smallTxt mb-0">Consultation ID: #' . $row['code'] . '</div>
                <div class="h6 fw-bold mb-0">' . $row['firstName'] . " " . $row['lastName'] . '</div>
                <div class="smallTxt mb-0"><?= $date ?></div>
            </div>

        </div>';
    }
}

exit(json_encode(array($html1, $html2, $html3)));
