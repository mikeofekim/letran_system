<?php
session_start();
include('../../php/db_config.php');
$id = $_POST['id'];


$sql = "SELECT * FROM  consultations  WHERE consultationID = $id";
// echo $sql;
$aa = mysqli_query($conn, $sql);
if ($aa->num_rows > 0) {
    $cons = $aa->fetch_assoc();

    if ($cons['status'] == 1) {
        echo ' <form action="" method="post" id="sendform">
        <div class="d-flex align-items-center">
            <div class="me-3"><i class="fas fa-image" style="cursor:pointer" onclick="imgattach()"></i></div>
            <div style="width:100%">
                <!-- <input type="text" /> -->

                <textarea name="" class="form-control round-2" id="mymessage" placeholder="Send message" id="" cols="30" rows="1" style="white-space: pre-wrap;"></textarea>
            </div>
            <div>
                <button class=" btn text-primary" type="submit"><i class="fas fa-paper-plane"></i></button>

    </form>';
    }
    if ($cons['status'] == 0) {

        echo 'This consultation is pending.';
    }
    if ($cons['status'] == 2) {

        echo '  <div class="d-flex justify-content-between">
        <div class="h6">
            This consultation is closed.
        </div>
        <div class="">
            <button class="btn btn-success btn-sm " data-bs-toggle="modal" data-bs-target="#exampleModal">Finalize</button>
        </div>
    </div>';
    }
?>



<?php
}
?>

<script>
    $("#sendform").submit(function(event) {
        event.preventDefault();



        $.post("ajax/sendmessage.php", {
            conid: selected,
            doc: doc,
            message: $("#mymessage").val()
        }, function(data) {

        });
        loadconvo();
        scrollToBottom();
        $("#mymessage").val("");

    });
</script>