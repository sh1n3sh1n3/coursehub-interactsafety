<?php
	session_start();
	$_SESSION['admin'] = '';
	if(!isset($_SESSION['admin']) || trim($_SESSION['admin']) == '' || empty($_SESSION['admin'])){
		header('location: login.php');
	}
	
?>