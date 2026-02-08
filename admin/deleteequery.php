<?php 
include('session.php');
if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
    header("Location: enquiry.php?error=invalid");
    exit;
}
$id = (int) $_GET['id'];
$delete = $conn->query("DELETE FROM enquiry_form WHERE id=".$id);
if($delete){
	echo '<script>alert("Data Deleted Successfully");window.location="enquiry.php"</script>';
} else {
	echo '<script>alert("Unable to delete data);window.location="enquiry.php"</script>';
}
$conn->close();
exit;
?>