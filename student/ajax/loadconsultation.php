<?php
session_start();
include('../../php/db_config.php');

$sql = "SELECT * FROM  consultations a INNER JOIN useraccount b ON a.doctorID = b.userAccountID INNER JOIN doctortbl c ON b.linkedAccount = c.doctorID  WHERE patientID = " . $_SESSION['userdata']['userAccountID'] . " AND status = 1 ORDER BY a.consultationID DESC";


$html1 = '';

$result = mysqli_query($conn, $sql);
echo $conn->error;
if ($result->num_rows > 0) {
    $html1 .= '<div class="smallTxt fw-bold mb-2">Active <span class="badge rounded-pill bg-primary">' . $result->num_rows . '</span></div>';
    while ($row = $result->fetch_assoc()) {

        $original_date = $row['date'];

        // Creating timestamp from given date
        $timestamp = strtotime($original_date);

        // Creating new date format from that timestamp
        $date = date("F d, h:sa", $timestamp);

        $html1 .= '<div class="d-flex p-3 round-1 align-items-center  mb-2  reqs border " onclick="openChat(' . $row['consultationID'] . ', ' . $row['userAccountID'] . ', ' . $row['code'] . ')">
        <div class="mb me-3"><img src="../assets/images/' . $row['imagefile'] . '" class="round shadow-sm" height="50" width="50" alt=""></div>
            <div class="">
                <div class="smallTxt mb-0">Consultation ID: #' . $row['code'] . '</div>
                <div class="h6 fw-bold mb-0">Dr. ' . $row['firstName'] . " " . $row['lastName'] . '</div>
                <div class="smallTxt mb-0"><?= $date ?></div>
            </div>
        </div>';
    }
}




$html2 = '';
$sql = "SELECT * FROM  consultations a INNER JOIN useraccount b ON a.doctorID = b.userAccountID INNER JOIN doctortbl c ON b.linkedAccount = c.doctorID  WHERE patientID = " . $_SESSION['userdata']['userAccountID']  . " AND (status = 0 OR status = 3) ORDER BY a.consultationID DESC";

$result = mysqli_query($conn, $sql);
echo $conn->error;
if ($result->num_rows > 0) {
    $html2 .= '<div class="smallTxt fw-bold mb-2">Sent requests <span class="badge rounded-pill bg-warning">' . $result->num_rows . '</span></div>';
    while ($row = $result->fetch_assoc()) {
        if ($row['status'] == 0) {
            $status = '<span class="text-primary">Waiting</span>';
        } else if ($row['status'] == 1) {
            $status = '<span class="text-primary">Active</span>';
        } else if ($row['status'] == 2) {
            $status = 'Closed';
        } else if ($row['status'] == 3) {
            $status = '<span class="text-danger">Declined</span>';
        }

        $original_date = $row['date'];

        // Creating timestamp from given date
        $timestamp = strtotime($original_date);

        // Creating new date format from that timestamp
        $date = date("F d, h:sa", $timestamp);
        $html2 .= '<div class="d-flex p-3 round-1 align-items-center  mb-2  reqs border ">
        <div class="mb me-3"><img src="../assets/images/' . $row['imagefile'] . '" class="round shadow-sm" height="50" width="50" alt=""></div>
            <div class="">
                <div class="h6 fw-bold mb-0">Dr. ' . $row['firstName'] . " " . $row['lastName'] . '</div>
                <div class="smallTxt mb-0">' . $date . '</div>
            </div>
            <div class="ms-auto align-self-start">
                <div class="smallTxt"><span class="fw-bold">' . $status . '</span>
                </div>
                <div class="float-end">
                    <i class="far fa-trash-alt text-danger" onclick="deleteconsultation(' . $row['consultationID'] . ')"></i>
                </div>


            </div>
        </div>';
    }
}


$html3 = '';
$sql = "SELECT * FROM  consultations a INNER JOIN useraccount b ON a.doctorID = b.userAccountID INNER JOIN doctortbl c ON b.linkedAccount = c.doctorID  WHERE patientID = " . $_SESSION['userdata']['userAccountID']  . " AND status = 2 ORDER BY a.consultationID DESC";

$result = mysqli_query($conn, $sql);
echo $conn->error;
if ($result->num_rows > 0) {
    $html3 .= '<div class="smallTxt fw-bold mb-2">Closed <span class="badge rounded-pill bg-success">' . $result->num_rows . '</span></div>';
    while ($row = $result->fetch_assoc()) {

        $original_date = $row['date'];

        // Creating timestamp from given date
        $timestamp = strtotime($original_date);

        // Creating new date format from that timestamp
        $date = date("F d, h:sa", $timestamp);
        $html3 .= '<div class="d-flex p-3 round-1 align-items-center mb-2  reqs border " onclick="openChat(' . $row['consultationID'] . ', ' . $row['userAccountID'] . ', ' . $row['code'] . ')">
        <div class="mb me-3"><img src="../assets/images/' . $row['imagefile'] . '" class="round shadow-sm" height="50" width="50" alt=""></div>
            <div class="">
                <div class="smallTxt mb-0">Consultation ID: #' . $row['code'] . '</div>
                <div class="h6 fw-bold mb-0">Dr. ' . $row['firstName'] . " " . $row['lastName'] . '</div>
                <div class="smallTxt mb-0">' . $date . '</div>
            </div>
        </div>';
    }
}
exit(json_encode(array($html1, $html2, $html3)));
