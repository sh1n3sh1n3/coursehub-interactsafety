<?php include('session.php'); 
$title = trim($_POST['title']);
$users = $conn->query("SELECT * FROM coupons WHERE title LIKE '".$title."'");
if($users->num_rows > 0) {
	echo '1';
} else {
	echo '0';
}
?>