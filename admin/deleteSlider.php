<?php 
include('session.php');
if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
    header("Location: slider.php?error=invalid");
    exit;
}
$id = (int) $_GET['id'];
$testimonial = $conn->query("SELECT * FROM slider WHERE id=".$id)->fetch_assoc();
if($testimonial['status'] == '1') {
$delete = $conn->query("UPDATE slider SET status='0' WHERE id=".$id);
} else {
$delete = $conn->query("UPDATE slider SET status='1' WHERE id=".$id);
}
if($delete){
	echo '<script>alert("Data Deleted Successfully");window.location="slider.php"</script>';
} else {
	echo '<script>alert("Unable to delete data");window.location="slider.php"</script>';
}
$conn->close();
exit;
?>