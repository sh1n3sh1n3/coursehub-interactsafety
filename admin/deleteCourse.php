<?php 
include('session.php');
if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
    header("Location: courses.php?error=invalid");
    exit;
}
$id = (int) $_GET['id'];
$testimonial = $conn->query("SELECT * FROM courses WHERE id=".$id)->fetch_assoc();
if($testimonial['status'] == '1') {
$delete = $conn->query("UPDATE courses SET status='0' WHERE id=".$id);
} else {
$delete = $conn->query("UPDATE courses SET status='1' WHERE id=".$id);
}
if($delete){
	echo '<script>alert("Data Updated Successfully");window.location="courses.php"</script>';
} else {
	echo '<script>alert("Unable to update data");window.location="courses.php"</script>';
}
$conn->close();
exit;
?>