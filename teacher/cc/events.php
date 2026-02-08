<?php

header('Content-Type: application/json');

error_reporting(0);
include("config.php");

$sql = "SELECT * FROM ".$SETTINGS["data_table"]." WHERE UNIX_TIMESTAMP(`start`) >=".strtotime($mysqli->real_escape_string($_GET['start']))." AND UNIX_TIMESTAMP(`start`)<=".strtotime($mysqli->real_escape_string($_GET['end']));
$arr = array();
if ($result = $mysqli->query($sql)) {
    $counter = 0;
    while ($row = $result->fetch_assoc()) {
        $arr[$counter]=$row;
        $counter++;
    }

	echo json_encode($arr);
} else {
    printf("Error: %s\n", $mysqli->sqlstate);
    exit;
}
?>