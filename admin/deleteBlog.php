<?php 
include('session.php');
if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
    header("Location: blogs.php?error=invalid");
    exit;
}
$id = (int) $_GET['id'];
$delete = $conn->query("DELETE FROM blogs WHERE id=".$id);
if($delete){
	echo '<script>alert("Data Deleted Successfully");window.location="blogs.php"</script>';
} else {
	echo '<script>alert("Unable to delete data");window.location="blogs.php"</script>';
}
$conn->close();
exit;
?>