<?php 
include('session.php');
if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
    header("Location: contact.php?error=invalid");
    exit;
}
$id = (int) $_GET['id'];
$delete = $conn->query("DELETE FROM contact WHERE id=".$id);
if($delete){
	echo '<script>alert("Data Deleted Successfully");window.location="contact.php"</script>';
} else {
	echo '<script>alert("Unable to delete data");window.location="contact.php"</script>';
}
$conn->close();
exit;
?>