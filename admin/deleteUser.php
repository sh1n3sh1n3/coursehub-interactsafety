<?php 
include('session.php');
if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
    header("Location: users.php?error=invalid");
    exit;
}
$id = (int) $_GET['id'];
$users = $conn->query("SELECT * FROM registration WHERE id=".$id)->fetch_assoc();
if($users['status'] == '1') {
	$status = '0';$msg = 'Student Deactivated Successfully!!';
} else {
	$status = '1';$msg = 'Student Activated Successfully!!';
}
$delete = $conn->query("UPDATE registration SET status='".$status."' WHERE id=".$id);
if($delete){
    $conn->query("DELETE FROM cart WHERE user=".$id);
	echo '<script>alert("'.$msg.'");window.location="users.php"</script>';
} else {
	echo '<script>alert("Unable to update data");window.location="users.php"</script>';
}
$conn->close();
exit;
?>