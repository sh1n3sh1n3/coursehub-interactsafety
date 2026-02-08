<?php 
include('session.php');
if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
    header("Location: questions.php?error=invalid");
    exit;
}
$id = (int) $_GET['id'];
$testimonial = $conn->query("SELECT * FROM mques WHERE id=".$id)->fetch_assoc();
$test = $testimonial['testid'];
$chapter = $testimonial['chapter_id'];
$delete = $conn->query("DELETE FROM mques WHERE id=".$id);
if($delete){
	echo '<script>alert("Data Deleted Successfully");window.location="questions.php?id='.$test.'&chapid='.$chapter.'"</script>';
} else {
	echo '<script>alert("Unable to delete data");window.location="questions.php?id='.$test.'&chapid='.$chapter.'"</script>';
}
$conn->close();
exit;
?>