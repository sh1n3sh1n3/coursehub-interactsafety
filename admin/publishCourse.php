<?php 
include('session.php');
$id = $_GET['id'];
$testimonial = $conn->query("SELECT * FROM courses WHERE id=".$id)->fetch_assoc();
if($testimonial['isPublished'] == '1') {
$delete = $conn->query("UPDATE courses SET isPublished='0' WHERE id=".$id);
$msg = 'Course Removed Successfully';
} else {
$delete = $conn->query("UPDATE courses SET isPublished='1' WHERE id=".$id);
$msg = 'Course Published Successfully';
}
if($delete){
	echo '<script>alert("'.$msg.'");window.location="courses.php"</script>';
} else {
	echo '<script>alert('.$conn->error.');window.location="courses.php"</script>';
}
?>