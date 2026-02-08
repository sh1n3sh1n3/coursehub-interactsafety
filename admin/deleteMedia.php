<?php 
include('session.php');
if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
    header("Location: media.php?error=invalid");
    exit;
}
$id = (int) $_GET['id'];
$contact = $conn->query("SELECT * FROM media WHERE id=".$id)->fetch_assoc();
unlink("../assets/images/media/" .$contact['image']);
$delete = $conn->query("DELETE FROM media WHERE id=".$id);
if($delete){
	echo '<script>alert("Data Deleted Successfully");window.location="media.php"</script>';
} else {
	echo '<script>alert("Unable to delete data");window.location="media.php"</script>';
}
$conn->close();
exit;
?>