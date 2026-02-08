<?php 
include('session.php');
if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
    header("Location: category.php?error=invalid");
    exit;
}
$id = (int) $_GET['id'];
$testimonial = $conn->query("SELECT * FROM category WHERE id=".$id)->fetch_assoc();
$course = $testimonial['course'];
if($testimonial['status'] == '1') {
$delete = $conn->query("UPDATE category SET status='0' WHERE id=".$id);
} else {
$delete = $conn->query("UPDATE category SET status='1' WHERE id=".$id);
}
if($delete){
	echo '<script>alert("Data Updated Successfully");window.location="category.php?id='.$course.'"</script>';
} else {
	echo '<script>alert("Unable to update data");window.location="category.php?id='.$course.'"</script>';
}
$conn->close();
exit;
?>