<?php 
include('session.php');
$id = $_GET['id'];
$st = $_GET['st'];
$delete = $conn->query("UPDATE courses SET comingsoon='".$st."' WHERE id=".$id);
if($delete){
	echo '<script>alert("Data Updated Successfully");window.location="courses.php"</script>';
} else {
	echo '<script>alert('.$conn->error.');window.location="courses.php"</script>';
}
?>