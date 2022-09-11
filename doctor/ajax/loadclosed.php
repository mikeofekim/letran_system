<?php
session_start();
include('../../php/db_config.php');


?>


<?php

$sql = "SELECT * FROM  consultations a INNER JOIN useraccount b ON a.patientID = b.userAccountID INNER JOIN usertbl c ON b.linkedAccount = c.userID  WHERE a.doctorID = " . $_SESSION['userid'] . " AND status = 2 ORDER BY a.consultationID DESC";

$result = mysqli_query($conn, $sql);
echo $conn->error;


if ($result->num_rows > 0) {
    echo '<div class="smallTxt fw-bold mb-2">Closed <span class="badge rounded-pill bg-success">' . $result->num_rows . '</span></div>';
    while ($row = $result->fetch_assoc()) {

        $original_date = $row['date'];

        // Creating timestamp from given date
        $timestamp = strtotime($original_date);

        // Creating new date format from that timestamp
        $date = date("F d, h:sa", $timestamp);


?>
        <div class="d-flex p-3 border round-1 align-items-center  mb-2  reqs" onclick="openChat(<?= $row['consultationID'] . ', ' . $row['userAccountID'] . ', ' . $row['code'] ?>)">
            <!-- <div class="me-3">
                <img src="../assets/images/profiledefault.png" height="40" alt="" />
            </div> -->
            <div class="">
                <div class="smallTxt mb-0">Consultation ID: #<?= $row['code'] ?></div>
                <div class="h6 fw-bold mb-0"><?= $row['firstName'] . " " . $row['lastName'] ?></div>
                <div class="smallTxt mb-0"><?= $date ?></div>
            </div>

        </div>
<?php
    }
}
?>