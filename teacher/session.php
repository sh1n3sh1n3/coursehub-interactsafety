<?php
	session_start();
	include 'includes/conn.php';
	if(!isset($_SESSION['teacher']) || trim($_SESSION['teacher']) == '' || empty($_SESSION['teacher'])){
		echo '<script>window.location.href="index.php"</script>';
	}
	$sql = "SELECT * FROM teachers WHERE id = '".$_SESSION['teacher']."'";
	$query = $conn->query($sql);
	$teacher = $query->fetch_assoc();
	
?>