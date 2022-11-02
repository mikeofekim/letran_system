<?php
session_start();
include('../../php/db_config.php');


?>


<?php

$sql = "SELECT * FROM  consultations a INNER JOIN useraccount b ON a.patientID = b.userAccountID INNER JOIN usertbl c ON b.linkedAccount = c.userID  WHERE a.doctorID = " . $_SESSION['userid'] . " AND status = 0 ORDER BY a.consultationID DESC";

$result = mysqli_query($conn, $sql);
echo $conn->error;


if ($result->num_rows > 0) {
    echo '<div class="smallTxt fw-bold mb-2">Requests <span class="badge rounded-pill bg-warning">' . $result->num_rows . '</span></div>';
    while ($row = $result->fetch_assoc()) {

        $original_date = $row['date'];

        // Creating timestamp from given date
        $timestamp = strtotime($original_date);

        // Creating new date format from that timestamp
        $date = date("F d, h:sa", $timestamp);




?>
        <div class="p-3 border round-1  mb-2 reqs">
            <!-- <div class="me-3">
                <img src="../assets/images/profiledefault.png" height="40" alt="" />
            </div> -->
            <div class="float-end smallTxt">
                New request
            </div>
            <div class="mb-2">
                <div class="h6 fw-bold mb-0"><?= $row['firstName'] . " " . $row['lastName'] ?></div>
                <div class="smallTxt mb-0"><?= $date ?></div>
            </div>
            <div class="d-flex justify-content-end">
                <div>
                    <button class="btn btn-sm btn-danger py-1 shadow-sm px-3 round-1 smallTxt fw-bold me-2" onclick="rejectstate(3, <?= $row['consultationID'] . ', ' . $row['userAccountID'] . ', ' . $row['code'] ?>)"><i class="fas fa-times"></i></button>
                </div>
                <div>
                    <button class="btn btn-sm btn-primary py-1 shadow-sm px-3 round-1 smallTxt fw-bold" onclick="acceptstate(1, <?= $row['consultationID'] . ', ' . $row['userAccountID'] . ', ' . $row['code'] ?>)">Accept</button>
                </div>
            </div>
        </div>

<?php
    }
}
?>