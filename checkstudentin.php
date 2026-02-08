<?php include 'include/conn.php'; 
$val = mysqli_real_escape_string($conn, $_POST['val']);
$id = mysqli_real_escape_string($conn, $_POST['id']);
$type = $_POST['type'];
$check = $conn->query("SELECT * FROM registration WHERE ".$type."='".$val."' AND id != '".$id."'");
if($check->num_rows > 0) {
    $fetch = $conn->query("SELECT * FROM registration WHERE id = '".$id."'")->fetch_assoc();
    if($type == 'email') {
		echo '1_'.$fetch['email'];
	} else if($type == 'mobile') {
		echo '2_'.$fetch['mobile'];
	} else {
		echo '3_'.$fetch['phone'];
	}
}
?>