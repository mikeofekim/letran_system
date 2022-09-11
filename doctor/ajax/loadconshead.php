<?php
session_start();
include('../../php/db_config.php');
$doc = $_POST['doc'];
$id = $_POST['id'];

$sql = "SELECT * FROM useraccount b INNER JOIN usertbl a ON  b.linkedAccount = a.userID  WHERE b.userAccountID = $doc";
// echo $sql;
$aa = mysqli_query($conn, $sql);

$sql = "SELECT * FROM  consultations  WHERE consultationID = $id";

$cons = mysqli_query($conn, $sql)->fetch_assoc();



if ($aa->num_rows > 0) {
    $doc = $aa->fetch_assoc();

?>

    <div class="d-flex align-items-center py-2">
        <div class="me-3">
            <img src="../assets/images/profiledefault.png" class="round-2 shadow bg-light" height="40" alt="" />
        </div>
        <div>
            <div class="h6 fw-bold mb-0"><?= $doc['firstName'] . " " . $doc['lastName'] ?></div>
            <!-- <div class="smallTxt mb-0"><?= $doc['position'] ?></div> -->
        </div>

        <?php

        if ($cons['status'] == 1) {
        ?>
            <div class="ms-auto me-3">
                <i class="fas fa-video pointer text-primary" onclick="initiate_video('<?= 'Consultation#' . $cons['code'] ?>')"></i>
            </div>
            <div class=align-self-start">
                <button class="btn btn-sm btn-light py-1 border shadow-sm px-3 round-1 smallTxt fw-bold" onclick="endstate(2)">End Consultation</button>

            </div>
        <?php
        }

        ?>


    </div>

<?php
}
?>