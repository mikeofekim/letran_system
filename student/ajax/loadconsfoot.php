<?php
session_start();
include('../../php/db_config.php');
$id = $_POST['id'];

$html2 = '';
$sql = "SELECT * FROM  consultations  WHERE consultationID = $id";
// echo $sql;
$aa = mysqli_query($conn, $sql);
if ($aa->num_rows > 0) {
    $cons = $aa->fetch_assoc();

    if ($cons['status'] == 1) {
        $html2 .= ' <form action="" method="post" id="sendform">
        <div class="d-flex align-items-center">
        <div class="me-3"><a style="cursor: pointer"  data-bs-toggle="modal" id="attachbtn" data-bs-target="#attach"><i class="fas fa-paperclip"></i></a></div>
            <div class="me-3"><i class="fas fa-image" style="cursor:pointer" onclick="imgattach()"></i></div>
            <div style="width:100%">
                <!-- <input type="text" /> -->

                <textarea name="" class="form-control round-2" id="mymessage" placeholder="Send message" id="" cols="30" rows="1" style="white-space: pre-line;"></textarea>
            </div>
            <div>
                <button class=" btn text-primary" type="submit"><i class="fas fa-paper-plane"></i></button>

    </form>';
    }
    if ($cons['status'] == 0) {

        $html2 .= '   <div>
        Waiting for doctor\'s response.
        <a class="float-end text-decoration-none btn btn-danger btn-sm " style="cursor: pointer" onclick="cancelreq()">Cancel request</a>
    </div>
';
    }
    if ($cons['status'] == 2) {

        $html2 .= '  <div class="d-flex justify-content-between">
        <div class="h6">
            This consultation is closed.
        </div>
        <div class="">
            <button class="btn border bg-white shadow-sm btn-sm " style="cursor:pointer" onclick="openFinalize()">View Result</button>
        </div>
    </div>';
    }
?>



<?php
}
?>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $("#sendform").submit(function(event) {
        event.preventDefault();



        $.post("ajax/sendmessage.php", {
            conid: selected,
            doc: doc,
            message: $("#mymessage").val()
        }, function(data) {
            loadconvo();
            if (data == 2) {
                Swal.fire(
                    'Sorry!',
                    'This consultation session ended.',
                    'info'
                )
            }
        });

        $("#mymessage").val("");
        scrollToBottom();
    });

    function cancelreq() {
        Swal.fire({
            title: 'Are you sure?',
            text: "This request will be cancelled & remove.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {

                $.post('ajax/cancelrequest.php', {
                    id: selected
                }, function(data) {
                    if (data == 1) {
                        selected = 0;
                        doc = 0;
                        code = '';
                        $("#conshead").load("ajax/loadconshead.php", {
                            doc: doc
                        });
                        $("#consfoot").load("ajax/loadconsfoot.php", {
                            id: selected
                        });
                        Swal.fire(
                            'Cancelled!',
                            'Your request has been cancelled & deleted.',
                            'success'
                        )
                    }
                });


            }
        })
    }
</script>