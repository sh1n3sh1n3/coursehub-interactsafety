<?php @session_start(); include 'include/conn.php'; 
include('include/enc_dec.php');
$reservation_username = mysqli_real_escape_string($conn, $_POST['reservation_username']);
$reservation_password = mysqli_real_escape_string($conn, $_POST['reservation_password']);
$date = date('Y-m-d');
$courseid = $_POST['courseid'];
$locid = $_POST['locid'];
$slotid = $_POST['slotid'];
$teacherid = $_POST['teacherid'];
$tbl_courses = $conn->query("SELECT * FROM courses WHERE id='".$courseid."'")->fetch_assoc();
$tbl_courseslot = $conn->query("SELECT * FROM course_slots WHERE id='".$slotid."'")->fetch_assoc();
$tbl_courseslotdate = $conn->query("SELECT * FROM course_dates WHERE slot_id='".$slotid."' ORDER BY date ASC LIMIT 1")->fetch_assoc();
$ccnntt=0;  $dates= '';
$courseDates = $conn->query("SELECT * FROM course_dates WHERE slot_id='".$slotid."' AND date='".$date."' ORDER BY date ASC");
if($courseDates->num_rows > 0) { } else {
    echo '6'; exit;
}
$cpurse_dates = $conn->query("SELECT * FROM course_dates WHERE slot_id='".$slotid."' ORDER BY date ASC");
while($fetchdates = $cpurse_dates->fetch_assoc()) {$ccnntt++;
    $startdate = $fetchdates['date'];
    if($date == $startdate) {
        $dates = 'Day '.$ccnntt;
    } 
}
$coursecode = date('ymd', strtotime($tbl_courseslotdate['date'])).$courseid.'.'.sprintf("%02d", $tbl_courses['duration']); 
$select = $conn->query("SELECT * FROM registration WHERE email LIKE '".$reservation_username."' AND verifyEmail = '1'");
if($select->num_rows > 0) {
    $fetch = $select->fetch_assoc();
    if($fetch['status'] == '1') {
        if($fetch['password'] == $reservation_password) {
            $userid = $fetch['id'];
            $tbl_sale = $conn->query("SELECT * FROM sale WHERE user='".$userid."' AND courseid='".$courseid."' AND slotid='".$slotid."'");
            $tbl_makeup_classes = $conn->query("SELECT * FROM makeup_classes WHERE studentid='".$userid."' AND courseid='".$courseid."' AND slotid='".$slotid."' AND date='".$date."'");
            if($tbl_sale->num_rows > 0) {
                $tbl_attendance = $conn->query("SELECT * FROM tbl_attendance WHERE tbl_student_id='".$userid."' AND courseid='".$courseid."' AND slotid='".$slotid."' AND submitdate = '".date('Y-m-d')."'");
                if($tbl_attendance->num_rows > 0) {
                    echo '5';
                } else {
                    $enccourseid = encryptStringArray($courseid);
                    $enclocid = encryptStringArray($locid);
                    $encslotid = encryptStringArray($slotid);
                    $encteacherid = encryptStringArray($teacherid); 
                    $encuserid = encryptStringArray($userid); 
                    $enctype = encryptStringArray('regular'); 
                    echo 'signature/'.$enccourseid.'/'.$enclocid.'/'.$encslotid.'/'.$encteacherid.'/'.$encuserid.'/'.$enctype;
                }
            } else if($tbl_makeup_classes->num_rows > 0) {
                $tbl_attendance = $conn->query("SELECT * FROM tbl_attendance WHERE tbl_student_id='".$userid."' AND courseid='".$courseid."' AND slotid='".$slotid."' AND submitdate = '".date('Y-m-d')."'");
                if($tbl_attendance->num_rows > 0) {
                    echo '5';
                } else {
             //       $insert = $conn->query("INSERT INTO tbl_attendance(tbl_student_id, time_in, courseid, slotid, locid, submitdate, type) VALUES ('".$userid."', '".date('Y-m-d H:i:s')."', '".$courseid."', '".$slotid."', '".$locid."', '".date('Y-m-d')."', 'makeup')");
                    $enccourseid = encryptStringArray($courseid);
                    $enclocid = encryptStringArray($locid);
                    $encslotid = encryptStringArray($slotid);
                    $encteacherid = encryptStringArray($teacherid); 
                    $encuserid = encryptStringArray($userid); 
                    $enctype = encryptStringArray('makeup'); 
                    echo 'signature/'.$enccourseid.'/'.$enclocid.'/'.$encslotid.'/'.$encteacherid.'/'.$encuserid.'/'.$enctype;
                }
            } else {
                echo '4';
            }
        } else {
            echo '1';
        }
    } else {
        echo '2';
    }
} else {
    echo '3';
}
?>