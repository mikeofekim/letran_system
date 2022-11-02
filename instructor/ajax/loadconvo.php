<?php
session_start();
include('../../php/db_config.php');
$myid = $_SESSION['userdata']['userAccountID'];

if ($_POST['id'] != '0') {
    $id = $_POST['id'];
    $doc = $_POST['doc'];
    $code = $_POST['code'];
    $sql = "SELECT * FROM messages WHERE ((outgoing_msg = $myid AND incoming_msg = $doc) OR (outgoing_msg = $doc AND incoming_msg = $myid)) AND consultationID=$id ORDER BY msgID ";
    // echo $sql;

    $result = mysqli_query($conn, $sql);


    $sql = "SELECT * FROM useraccount a INNER JOIN usertbl b ON a.linkedAccount = b.userID WHERE a.userAccountID = " . $doc;

    $doc = mysqli_query($conn, $sql)->fetch_assoc();

    echo '<div class="text-center text-muted mb-4">Consultation #' . $code . '</div>';
    if ($result->num_rows > 0) {


        while ($row = $result->fetch_assoc()) {



            // Creating new date format from that timestamp
            $original_date = $row['date'];

            // Creating timestamp from given date
            $timestamp = strtotime($original_date);

            // Creating new date format from that timestamp
            $date = date("F d, h:sa", $timestamp);

            if ($row['outgoing_msg'] == $myid) { //sender

                if ($row['type'] == 0) {
                    echo "<div class='d-flex justify-content-end mb-2'><div class='shadow bg-primary sender p-2 text-white ' style='max-width: 300px'>" . $row['message'] . "<div class='smallTxt'>" . $date . "</div></div></div>";
                } else {
                    echo "<div class='d-flex justify-content-end mb-2'><div class='shadow bg-primary sender p-2 text-white ' style='max-width: 300px'><a href='../assets/uploads/" . $row['message'] . "' target='_blank'><img class='round-2' src='../assets/uploads/" . $row['message'] . "' height='150'></a><div class='smallTxt'>" . $date . "</div></div></div>";
                }
            } else { //receiver


                if ($row['type'] == 0) {
                    echo "<div class='d-flex align-items-end mb-2'>
                   <div class='me-1'>
                   <img src='../assets/images/" . $doc['imagefile'] . "' height='35' width='35' class='bg-light round shadow'/>
                      </div>
                   <div class='shadow bg-info receiver p-2 text-white' style='max-width: 300px'>" . $row['message'] . "</span><div class='smallTxt'>" . $date . "</div></div>
                  </div>";
                } else {
                    echo "<div class='d-flex align-items-end mb-2'>
                    <div class='me-1'>
                    <img src='../assets/images/" . $doc['imagefile'] . "' height='35' width='35' class='bg-light round shadow'/>
                       </div>
                    <div class='shadow bg-info receiver p-2 text-white' style='max-width: 300px'><a href='../assets/uploads/" . $row['message'] . "' target='_blank'><img class='round-2' src='../assets/uploads/" . $row['message'] . "' height='150'></a><div class='smallTxt'>" . $date  . "</div></div>
                   </div>";
                }
            }
        }
    }
}
