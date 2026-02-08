<?php include('session.php'); 
$id = $_POST['id'];
$type = $_POST['type'];
$remarks = mysqli_real_escape_string($conn, $_POST['remarks']);
if($type == 'accept') {
    $conn->query("UPDATE course_teachers SET accepted = '1', remarks = '".$remarks."' WHERE id=".$id);
} else {
    $conn->query("UPDATE course_teachers SET accepted = '2', remarks = '".$remarks."' WHERE id=".$id);
}
?>