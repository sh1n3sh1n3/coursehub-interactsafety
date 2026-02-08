<?php 
include('session.php');
$id = $_GET['id'];
$testimonial = $conn->query("SELECT * FROM course_slots WHERE id=".$id)->fetch_assoc();
if($testimonial['isPublished'] == '1') {
$delete = $conn->query("UPDATE course_slots SET isPublished='0' WHERE id=".$id);
$msg = 'Course Schedule Removed Successfully';
} else {
$delete = $conn->query("UPDATE course_slots SET isPublished='1' WHERE id=".$id);
$msg = 'Course Schedule Published Successfully';
}
if($delete){
	echo '<script>alert("'.$msg.'");window.location="courseslots.php"</script>';
} else {
	echo '<script>alert('.$conn->error.');window.location="courseslots.php"</script>';
}
?>