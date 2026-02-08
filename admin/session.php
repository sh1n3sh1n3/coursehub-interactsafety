<?php
	session_start();
	include 'includes/conn.php';
	include 'includes/enc_dec.php';
	if(!isset($_SESSION['admin']) || trim($_SESSION['admin']) == '' || empty($_SESSION['admin'])){
		echo '<script>window.location.href="login.php"</script>'; exit;
	}
	$sql = "SELECT * FROM admin WHERE id = '".$_SESSION['admin']."'";
	$query = $conn->query($sql);
	$admin = $query->fetch_assoc();
	
?>