<?php
session_start();
include('../../php/db_config.php');

$sql = "SELECT * FROM  consultations a INNER JOIN useraccount b ON a.doctorID = b.userAccountID INNER JOIN doctortbl c ON b.linkedAccount = c.doctorID  WHERE patientID = " . $_SESSION['user']['userID'] . " ORDER BY a.consultationID DESC";

$result = mysqli_query($conn, $sql);
echo $conn->error;
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        if ($row['status'] == 0) {
            $status = 'Waiting';
        } else if ($row['status'] == 1) {
            $status = '<span class="text-primary">Active</a>';
        } else if ($row['status'] == 2) {
            $status = 'Closed';
        } else if ($row['status'] == 3) {
            $status = 'Declined';
        }

        $original_date = $row['date'];

        // Creating timestamp from given date
        $timestamp = strtotime($original_date);

        // Creating new date format from that timestamp
        $date = date("F d, h:sa", $timestamp);
?>
        <div class="d-flex p-3 round-1 align-items-center shadow-sm mb-2  reqs border " onclick="openChat(<?= $row['consultationID'] . ', ' . $row['userAccountID'] . ', ' . $row['code'] ?>)">
            <!-- <div class="me-3">
                <img src="../assets/images/profiledefault.png" height="40" alt="" />
            </div> -->
            <div class="">
                <div class="smallTxt mb-0">Consultation ID: #<?= $row['code'] ?></div>
                <div class="h6 fw-bold mb-0">Dr. <?= $row['firstName'] . " " . $row['lastName'] ?></div>
                <div class="smallTxt mb-0"><?= $date ?></div>
            </div>
            <div class="ms-auto align-self-start">
                <div class="smallTxt">Status: <span class="fw-bold"><?= $status ?></span></div>
            </div>
        </div>
<?php
    }
}
?>