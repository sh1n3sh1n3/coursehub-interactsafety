<?php 
use Dompdf\Dompdf;
session_start(); include('include/conn.php'); 
@require_once 'dompdf/autoload.inc.php';
$fetch = $conn->query("SELECT * FROM sale WHERE id='".$_GET['id']."'")->fetch_assoc();
$sqlcourses = $conn->query("SELECT * FROM courses WHERE id='".$fetch['courseid']."'")->fetch_assoc();
$sqlcourseslot = $conn->query("SELECT * FROM course_slots WHERE id='".$fetch['slotid']."'")->fetch_assoc();
$sqllocation = $conn->query("SELECT * FROM locations WHERE id='".$sqlcourseslot['locid']."'")->fetch_assoc();
$cities = $conn->query("SELECT * FROM cities WHERE id=".$sqlcourseslot['cityid'])->fetch_assoc();
$fetchuser = $conn->query("SELECT * FROM registration WHERE id='".$fetch['user']."'")->fetch_assoc();
$stname = $fetchuser['title'].' '.$fetchuser['fname'].' '.$fetchuser['lname'];
$coursestitle = $sqlcourses['title'];
$days = $sqlcourses['duration'];
$coursedatetime = date('d-M-Y h:i A', strtotime($sqlcourseslot['startdate'].''.$sqlcourseslot['starttime']));
$tbl_attendancedata = $conn->query("SELECT * FROM tbl_attendance WHERE tbl_student_id='".$fetch['user']."' AND courseid='".$fetch['courseid']."'");
while($fetchattendancedata = $tbl_attendancedata->fetch_assoc()) {
    $dates .= date('d/m/Y', strtotime($fetchattendancedata['time_in'])).'&nbsp;&nbsp;&nbsp;';
}
$dates = rtrim($dates,", ");
$dt = date('d-M-Y',strtotime("+$days day", strtotime($coursedatetime)));
$loc = $cities['name'].' - '.$sqllocation['location'].' ('.$sqllocation['title'].')';
$html = '
<div style="width:100%; height:675px; padding:10px;font-family: Arial, Helvetica, sans-serif; ">
<div style="width:100%; height:475px; text-align:center;">
        <p style="width:100%;float:left">
       <img style="" src="images/provider_logo.png">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
       <img style="" src="images/certificate_logo.png">
       </p><br>
       <p style="font-size:35px; font-weight:bold">Certificate of Attendance</p>
       <p style="font-size:20px"><i>This is to certify that</i></p>
       <p style="font-size: 30px;color: #016EBF;"><b>'.$stname.'</b></p>
       <p style="font-size:20px"><i>has attended a</i></p> 
       <p style="font-size: 30px;font-weight: bold;">'.$coursestitle.'</p>
       <p style="font-size:20px"><i>on</i></p> 
      <p style="font-size:15px;color: #016EBF;font-weight:bold;">'.$dates.'</p>
</div>
<div style="width:100%; height:200px; padding:10px; ">
       <span style="font-size:20px;padding-top:5px;border-top:1px solid #000;text-align:left;font-weight:bold;">Darren Kishander</span>
       <br>
       <span style="font-size:20px">Director</span>
       <br><br>
       <span style="font-size:20px;padding-top:5px;text-align:left;">Interact Network Pty Ltd</span>
       <br>
       <span style="font-size:20px">ABN 55 624 325 775</span>
       <br><br>
       <span style="font-size:20px;padding-top:5px;text-align:left">Certificate No:</span>
       <br>
       <span style="font-size:20px">Date of Issue: </span>
       <br><br>
       <div style="text-align:center">
    <span style="font-size:12px;text-align:center"><i>The course is approved by WorkSafe Victoria under s67 of the Victorian OHS Act 2004. </i></span><br>
    <span style="font-size:12px;text-align:center"><i>Interact Safety is approved by WorkSafe Victoria underto deliver this course. </i></span></div>
</div>
</div>';
// echo $html; die;
$dompdf = new Dompdf();
$dompdf->loadHtml($html); 
// $dompdf->setPaper('A4', 'portrait'); 
$customPaper = array(0,0,775,675);$dompdf->setPaper($customPaper); 
$dompdf->render(); 
if($dompdf->stream(".$stname.".rand(10,1000).".pdf", array("Attachment" => false))){
    $_SESSION['success'] = 'Successfully Generated.';
}