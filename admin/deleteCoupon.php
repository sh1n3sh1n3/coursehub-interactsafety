<?php 
include('session.php');
if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
    header("Location: coupons.php?error=invalid");
    exit;
}
$id = (int) $_GET['id'];
$testimonial = $conn->query("SELECT * FROM coupons WHERE id=".$id)->fetch_assoc();
if($testimonial['status'] == '1') {
$delete = $conn->query("UPDATE coupons SET status='0' WHERE id=".$id);
} else {
$delete = $conn->query("UPDATE coupons SET status='1' WHERE id=".$id);
}
if($delete){
	echo '<script>alert("Data Deleted Successfully");window.location="coupons.php"</script>';
} else {
	echo '<script>alert("Unable to delete data");window.location="coupons.php"</script>';
}
$conn->close();
exit;
?>