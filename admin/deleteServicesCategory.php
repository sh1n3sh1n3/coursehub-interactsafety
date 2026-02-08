<?php 
include('session.php');
if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
    header("Location: servicescategory.php?error=invalid");
    exit;
}
$id = (int) $_GET['id'];
$testimonial = $conn->query("SELECT * FROM services_category WHERE id=".$id)->fetch_assoc();
$course = $testimonial['course'];
if($testimonial['status'] == '1') {
$delete = $conn->query("UPDATE services_category SET status='0' WHERE id=".$id);
} else {
$delete = $conn->query("UPDATE services_category SET status='1' WHERE id=".$id);
}
if($delete){
	echo '<script>alert("Data Update Successfully");window.location="servicescategory.php?id='.$course.'"</script>';
} else {
	echo '<script>alert("Unable to update data");window.location="servicescategory.php?id='.$course.'"</script>';
}
$conn->close();
exit;
?>