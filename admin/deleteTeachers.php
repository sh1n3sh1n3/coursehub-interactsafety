<?php 
include('session.php');
if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
    header("Location: teachers.php?error=invalid");
    exit;
}
$id = (int) $_GET['id'];
$delete = $conn->query("DELETE FROM teachers WHERE id=".$id);
if($delete){
	echo '<script>alert("Data Deleted Successfully");window.location="teachers.php"</script>';
} else {
	echo '<script>alert("Unable to delete data");window.location="teachers.php"</script>';
}
$conn->close();
exit;
?>