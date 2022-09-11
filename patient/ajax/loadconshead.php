<?php
session_start();
include('../../php/db_config.php');
$doc = $_POST['doc'];





$sql = "SELECT * FROM useraccount b INNER JOIN doctortbl a ON  b.linkedAccount = a.doctorID  WHERE b.userAccountID = $doc";
// echo $sql;
$aa = mysqli_query($conn, $sql);
if ($aa->num_rows > 0) {
    $doc = $aa->fetch_assoc();

?>

    <div class="d-flex align-items-center py-2">
        <div class="me-3">
            <img src="../assets/images/<?= $doc['imagefile'] ?>" class="bg-light shadow round-2" height="40" alt="" />
        </div>
        <div>
            <div class="h6 fw-bold mb-0">Dr. <?= $doc['firstName'] . " " . $doc['lastName'] ?> <a onclick="viewdoc(<?= $doc['doctorID'] ?>)" style="cursor: pointer"><i class="fas fa-external-link-alt"></i></a></div>
            <div class="smallTxt mb-0"><?= $doc['specialization'] ?></div>
        </div>
        <!-- <div class="ms-auto align-self-start"><i class="fas fa-ellipsis-v"></i></div> -->
    </div>

<?php
}
?>