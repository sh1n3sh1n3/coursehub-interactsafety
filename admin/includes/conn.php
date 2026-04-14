<?php error_reporting(E_ERROR | E_PARSE);

$config = require __DIR__ . '/../../config/config.php';
$db = $config['database'];

date_default_timezone_set('Australia/Melbourne');
	$conn = new mysqli($db['host'], $db['user'], $db['password'], $db['name']);
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}
	$con = new mysqli($db['host'], $db['user'], $db['password'], $db['name']);
	if ($con->connect_error) {
	    die("Connection failed: " . $con->connect_error);
	}

	require_once dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'include' . DIRECTORY_SEPARATOR . 'location_display.php';
	require_once dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'include' . DIRECTORY_SEPARATOR . 'course_dates_display.php';
	require_once dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'include' . DIRECTORY_SEPARATOR . 'seat_availability.php';
	require_once dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'include' . DIRECTORY_SEPARATOR . 'booking_cutoff.php';
?>
