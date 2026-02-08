<?php 
include('session.php');
$id = $_GET['id'];
$pid = $_GET['pid'];
$testimonial = $conn->query("SELECT * FROM sale WHERE id=".$id)->fetch_assoc();
if($testimonial['generateCertificate'] == '1') {
$delete = $conn->query("UPDATE sale SET generateCertificate='0' WHERE id=".$id);
} else {
$delete = $conn->query("UPDATE sale SET generateCertificate='1', generateCertificatedate = '".date('Y-m-d')."' WHERE id=".$id);
}
if($delete){
	echo '<script>alert("Updated Successfully");window.location="users.php?id='.$pid.'"</script>';
} else {
	echo '<script>alert('.$conn->error.');window.location="users.php?id='.$pid.'"</script>'; 
}
?>