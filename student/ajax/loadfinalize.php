<?php
session_start();
include('../../php/db_config.php');
$id = $_POST['id'];


$sql = "SELECT * FROM  finalized  WHERE consultationID = $id";
// echo $sql;
$result = mysqli_query($conn, $sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    $original_date = $row['date_final'];

    // Creating timestamp from given date
    $timestamp = strtotime($original_date);

    // Creating new date format from that timestamp
    $date = date("F d, h:sa", $timestamp);
?>
    <a class="btn btn-primary float-end " href="print.php?id=<?= $id ?>"><i class="fas fa-print"></i> Print</a>
    <div class="h6"><?= $date ?></div>

    <div class="smallTxt fw-bold">Symptoms</div>
    <div class="h6 bg-light p-2 px-3 round-2" style="min-height: 100px"><?= $row['symptoms'] ?></div>
    <div class="smallTxt fw-bold">Diagnosis</div>
    <div class="h6  bg-light p-2 px-3 round-2" style="min-height: 100px"><?= $row['diagnosis'] ?></div>
    <div class="smallTxt fw-bold">Recommendation</div>
    <div class="h6  bg-light p-2 px-3 round-2" style="min-height: 150px"><?= $row['recommendation'] ?></div>
<?php



} else {
    echo "Wating for report.";
}
