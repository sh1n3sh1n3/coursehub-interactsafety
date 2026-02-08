<?php include('session.php');
$userdata = $conn->query("UPDATE tbl_attendance SET isVerified='1' WHERE tbl_attendance_id=".$_POST['id']);
if($userdata) {
echo '1';
} else {
    echo '0';
}
?>