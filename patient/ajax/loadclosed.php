<?php
session_start();
include('../../php/db_config.php');


$html3 = '';
$sql = "SELECT * FROM  consultations a INNER JOIN useraccount b ON a.doctorID = b.userAccountID INNER JOIN doctortbl c ON b.linkedAccount = c.doctorID  WHERE patientID = " . $_SESSION['user']['userID'] . " AND status = 2 ORDER BY a.consultationID DESC";

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
 $html3 .= '<div class="d-flex p-3 round-1 align-items-center mb-2  reqs border " onclick="openChat('. $row['consultationID'] . ', ' . $row['userAccountID'] . ', ' . $row['code'] .')">
            <!-- <div class="me-3">
                <img src="../assets/images/profiledefault.png" height="40" alt="" />
            </div> -->
            <div class="">
                <div class="smallTxt mb-0">Consultation ID: #'. $row['code'] .'</div>
                <div class="h6 fw-bold mb-0">Dr. '. $row['firstName'] . " " . $row['lastName'] .'</div>
                <div class="smallTxt mb-0">'. $date .'</div>
            </div>
        </div>';
    }
}
