<?php $err = $msg = '';
if(isset($_POST['submit'])) {
    $type = mysqli_real_escape_string($conn, $_POST['type']);
    $courseid = mysqli_real_escape_string($conn, $_POST['courseid']);
	$locid = mysqli_real_escape_string($conn, $_POST['locid']);
	$city = mysqli_real_escape_string($conn, $_POST['city']);
	$remarks = mysqli_real_escape_string($conn, $_POST['remarks']);
    $maxcapacity = mysqli_real_escape_string($conn, $_POST['maxcapacity']);
    $mincapacity = mysqli_real_escape_string($conn, $_POST['mincapacity']);
    $makecapacity= mysqli_real_escape_string($conn, $_POST['makecapacity']);
    $map_location= mysqli_real_escape_string($conn, $_POST['map_location']);
    $map_location_url= mysqli_real_escape_string($conn, $_POST['map_location_url']);
    $dates_array = $_POST['date'];
    $teacher_array = $_POST['teacherid'];
	$id = mysqli_real_escape_string($conn, $_POST['id']);
	$insert = $conn->query("UPDATE course_slots SET map_location= '".$map_location."',map_location_url= '".$map_location_url."',courseid= '".$courseid."',locid= '".$locid."', cityid= '".$city."',maxcapacity='".$maxcapacity."',makecapacity='".$makecapacity."',mincapacity='".$mincapacity."',remarks= '".$remarks."' WHERE id=".$id);
	if($insert){
	    foreach($dates_array as $dkey => $dates) {
	        $date = $dates;
	        $starttime = $_POST['starttime'][$dkey];
	        $endtime = $_POST['endtime'][$dkey];
	        $dateid = $_POST['dateid'][$dkey];
	        if($dateid != '0') {
	            $conn->query("UPDATE course_dates SET date='".$date."', starttime='".$starttime."', endtime='".$endtime."' WHERE id=".$dateid);
	        } else {
	            $conn->query("INSERT INTO course_dates (course_id, slot_id, date, starttime, endtime) VALUES ('".$courseid."','".$id."', '".$date."','".$starttime."','".$endtime."')");
	        }
	    }
	    foreach($teacher_array as $tkey => $teachers) {
	        $teacherid = $teachers;
	        $conn->query("INSERT INTO course_teachers (course_id, slot_id, teacherid) VALUES ('".$courseid."','".$id."','".$teacherid."')");
	    }
	    $conn->query("UPDATE remain_places SET courseid = '".$courseid."', total = '".$maxcapacity."', makecapacity='".$makecapacity."' WHERE slotid='".$id."'");
	    if($type == 'private') {
	        $conn->query("UPDATE private_course SET course_id = '".$courseid."' WHERE slot_id = '".$id."'");
	    }
		$msg = 'Data Added Successfully.';
	} else {
		$msg = $conn->error;
	}
}
echo $msg;
?>