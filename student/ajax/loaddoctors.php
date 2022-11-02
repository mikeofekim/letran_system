<?php
session_start();
include('../../php/db_config.php');

$category = $_POST['category'];

switch ($category) {
    case 0:
        $cat = "";
        break;
    case 1:
        $cat = "AND specialization = 'General Practice'";
        break;
    case 2:
        $cat = "AND specialization = 'Dermatologist'";
        break;
    case 3:
        $cat = "AND specialization = 'Opthalmologist'";
        break;
}


$keyword = $_POST['search'];
$sql = "SELECT * FROM  useraccount a Inner JOIN doctortbl b ON a.linkedAccount = b.doctorID WHERE a.usertype = 2 AND (b.firstName like '%$keyword%' OR b.lastName like '%$keyword%') $cat";


$result = mysqli_query($conn, $sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {

?>
        <div class="d-flex p-3 border round-1 align-items-center  mb-2 ">
            <div class="me-3">
                <img src="../assets/images/<?= $row['imagefile'] ?>" class="round shadow-sm" height="50" width="50" alt="">
            </div>
            <div class="">

                <div class="h6 fw-bold mb-0"><a onclick="viewdoc(<?= $row['doctorID'] ?>)" style="cursor: pointer" class="text-primary text-decoration-none">Dr. <?= $row['firstName'] . " " . $row['lastName'] ?></a> </div>
                <div class="smallTxt mb-0"><?= $row['specialization'] ?></div>
            </div>
            <div class="ms-auto align-self-start"><a class="text-primary" style="cursor: pointer" onclick="sendRequest(<?= $row['userAccountID'] ?>)"><i class="far fa-paper-plane"></i></a></div>

        </div>
<?php
    }
}
?>