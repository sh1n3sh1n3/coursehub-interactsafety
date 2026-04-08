<?php error_reporting(E_ERROR | E_PARSE);

date_default_timezone_set('Australia/Melbourne');
	$conn = new mysqli('localhost', 'interac8_coursehub', 'AcZ&xNCzJii,8]g', 'interac8_coursehub');
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}
	$con = new mysqli('localhost', 'interac8_coursehub', 'AcZ&xNCzJii,8]g', 'interac8_coursehub');
	if ($con->connect_error) {
	    die("Connection failed: " . $con->connect_error);
	}

	require_once dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'include' . DIRECTORY_SEPARATOR . 'location_display.php';
	require_once dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'include' . DIRECTORY_SEPARATOR . 'course_dates_display.php';
	require_once dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'include' . DIRECTORY_SEPARATOR . 'seat_availability.php';
	require_once dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'include' . DIRECTORY_SEPARATOR . 'booking_cutoff.php';
?>
