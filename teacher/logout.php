<?php
	session_start();
	$_SESSION['teacher'] = '';
	if(!isset($_SESSION['teacher']) || trim($_SESSION['teacher']) == '' || empty($_SESSION['teacher'])){
		header('location: index.php');
	}
	
?>