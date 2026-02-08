<?php

header('Content-Type: application/json');

error_reporting(0);
include("session.php");

$sql = "SELECT * FROM course_slots WHERE isPublished='1' AND teacherid = '".$_SESSION['teacher']."' AND UNIX_TIMESTAMP(`startdate`) >=".strtotime($conn->real_escape_string($_GET['start']))." AND UNIX_TIMESTAMP(`startdate`)<=".strtotime($conn->real_escape_string($_GET['end']));
$arr = array();
if ($result = $conn->query($sql)) {
    $counter = 0;
    while ($fetchcourses = $result->fetch_assoc()) {
        $startdate = date('Y-m-d', strtotime($fetchcourses['startdate']));
        $enddate = date('Y-m-d', strtotime($fetchcourses['enddate']));
        $starttimeh = date('H:i:s', strtotime($fetchcourses['starttime']));
        $endtimeh = date('H:i:s', strtotime($fetchcourses['endtime']));
        $startdate1 = date('d-M-Y', strtotime($fetchcourses['startdate']));
        $enddate1 = date('d-M-Y', strtotime($fetchcourses['enddate']));
        $starttimeh1 = date('h:i:s A', strtotime($fetchcourses['starttime']));
        $endtimeh1 = date('h:i:s A', strtotime($fetchcourses['endtime']));
		$cities = $conn->query("SELECT * FROM cities WHERE id=".$fetchcourses['cityid'])->fetch_assoc();
        $locs = $conn->query("SELECT * FROM locations WHERE id=".$fetchcourses['locid'])->fetch_assoc();
        $courses = $conn->query("SELECT * FROM courses WHERE id=".$fetchcourses['courseid'])->fetch_assoc();
        $coursetitl = $cities['name'].' - '.$locs['location'].' ('.$locs['title'].')';
        $description = "<b>Course</b> : ".$courses['title']." <br> ";
        $description .= "<b>Location</b> : ".$coursetitl." <br> ";
        $description .= "Start Date : ".$startdate1." ".$starttimeh1." <br> ";
        $description .= "End Date : ".$enddate1." ".$endtimeh1;
        $row = array("title" => $coursetitl, "start" => $startdate.' '.$starttimeh, "description" => strip_tags($description));
        $arr[$counter]=$row;
        $counter++;
    }

	echo json_encode($arr);
} else {
    printf("Error: %s\n", $conn->sqlstate);
    exit;
}
?>