<?php 
 @session_start(); include 'include/conn.php'; 
$date = date('Ymdhis');
$courseid = $_POST['courseid'];
$locid = $_POST['locid'];
$slotid = $_POST['slotid'];
$teacherid = $_POST['teacherid'];
$userid = $_POST['userid'];
$type = $_POST['type'];
$select = $conn->query("SELECT * FROM registration WHERE id = '".$userid."'")->fetch_assoc();
$name = $select['fname'].'_'.$select['lname'];
$folderPath = "signatures/";
    $image_parts = explode(";base64,", $_POST['sign']);
    $image_type_aux = explode("image/", $image_parts[0]);

    $image_type = $image_type_aux[1];

    $image_base64 = base64_decode($image_parts[1]);

    $file = $folderPath . $name . "_" . $date ."_" . uniqid() . '.' . $image_type;
    $filename = $name . "_" . $date ."_" . uniqid() . '.' . $image_type;
    file_put_contents($file, $image_base64);
    
$insert = $conn->query("INSERT INTO tbl_attendance(tbl_student_id, time_in, courseid, slotid, locid, teacherid, submitdate, type, esignature) VALUES ('".$userid."', '".date('Y-m-d H:i:s')."', '".$courseid."', '".$slotid."', '".$locid."', '".$teacherid."', '".date('Y-m-d')."', '".$type."', '".$file."')"); 
if($insert) {
    $_SESSION['pin_user'] = $select['id'];
    echo '1';
} else {
    echo '0';
}
?>