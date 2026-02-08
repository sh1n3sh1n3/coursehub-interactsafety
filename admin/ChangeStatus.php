<?php 
include('session.php');
$id = $_GET['id'];
$testimonial = $conn->query("SELECT * FROM jobs WHERE id=".$id)->fetch_assoc();
if($testimonial['status'] == '1') {
$delete = $conn->query("UPDATE jobs SET status='0' WHERE id=".$id);
} else {
$delete = $conn->query("UPDATE jobs SET status='1' WHERE id=".$id);
}
if($delete){
	echo '<script>alert("Data Updated Successfully");window.location="jobs.php"</script>';
} else {
	echo '<script>alert('.$conn->error.');window.location="jobs.php"</script>';
}
?>