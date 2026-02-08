<?php 
include('session.php');
if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
    header("Location: services.php?error=invalid");
    exit;
}
$id = (int) $_GET['id'];
$delete = $conn->query("DELETE FROM services WHERE id=".$id);
if($delete){
	echo '<script>alert("Data Deleted Successfully");window.location="services.php"</script>';
} else {
	echo '<script>alert("Unable to delete data");window.location="services.php"</script>';
}
$conn->close();
exit;
?>