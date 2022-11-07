<?php
session_start(); 
if (!isset($_SESSION['alogin']) || (trim($_SESSION['alogin']) == '')) { ?>
<script>
window.location = "../index.php";
</script>

<?php
}
$session_id=$_SESSION['alogin'];
$session_depart = $_SESSION['arole'];

?>