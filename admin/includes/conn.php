<?php error_reporting(E_ERROR | E_PARSE);

date_default_timezone_set('Asia/Kolkata');
	$conn = new mysqli('localhost', 'interac8_coursehub', 'AcZ&xNCzJii,8]g', 'interac8_coursehub');
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}
	$con = new mysqli('localhost', 'interac8_coursehub', 'AcZ&xNCzJii,8]g', 'interac8_coursehub');
	if ($con->connect_error) {
	    die("Connection failed: " . $con->connect_error);
	}
?>