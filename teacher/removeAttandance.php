<?php include('session.php');
$comments = mysqli_real_escape_string($conn, $_POST['comments']);
$userdata = $conn->query("UPDATE tbl_attendance SET isVerified='2', comments='".$comments."' WHERE tbl_attendance_id=".$_POST['id']);
if($userdata) {
echo '1';
} else {
    echo '0';
}
?>