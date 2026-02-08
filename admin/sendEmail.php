<?php include('session.php'); 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';
$emailaccount = $conn->query("SELECT * FROM emails WHERE type='support'")->fetch_assoc();
$impacttitle = $emailaccount['title1'];
$impactem = $emailaccount['email1']; 
$impactphone= $emailaccount['phone']; 
if(isset($_SERVER['HTTPS'])){
    $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
}
else{
    $protocol = 'http';
}
$url = $protocol . "://" . $_SERVER['HTTP_HOST'];
$id = encryptStringArray($_POST['id']);
$fetchstu = $conn->query("SELECT * FROM sale WHERE id='".$_POST['id']."'")->fetch_assoc();
$userdata = $conn->query("SELECT * FROM registration WHERE id='".$fetchstu['user']."'")->fetch_assoc();
$sqlcourses = $conn->query("SELECT * FROM courses WHERE id='".$fetchstu['courseid']."'")->fetch_assoc();
$slotdata = $conn->query("SELECT * FROM course_slots WHERE id='".$fetchstu['slotid']."'")->fetch_assoc();
$attan = strtoupper(substr($userdata['fname'], 0, 1).''.substr($userdata['lname'], 0, 1));
$fname = $fetchstu['fname'];
$lname = $fetchstu['lname'];
$email = $fetchstu['email'];
$ccemail = $fetchstu['workplace_email'];
if(!empty($fetchstu['workplace_contact'])) {
$ccname = $fetchstu['workplace_contact'];
    $userdataname = '<b>'.$fname.' '.$lname.'</b>';
} else {
   $ccname =  $fname.' '.$lname;
    $userdataname = "you";
}
$course_datesd = $conn->query("SELECT * FROM course_dates WHERE slot_id='".$fetchstu['slotid']."' AND date <= '".date('Y-m-d')."'");
$ccn = 0; $abs = 0; $missed = '';
while($dattessd = $course_datesd->fetch_assoc()) {
        if($dattessd['date'] == date('Y-m-d')) {
            if($dattessd['starttime'] <= date('H:i:s')) {
                $attandance = $conn->query("SELECT * FROM tbl_attendance WHERE courseid='".$fetchstu['courseid']."' AND slotid='".$fetchstu['slotid']."' AND tbl_student_id='".$fetchstu['user']."' AND submitdate='".$dattessd['date']."' AND isDeleted='0'");
                if($attandance->num_rows > 0) { $ccn++; } else { $ccn++; $abs++; $missed.='Day '.$ccn.' on '.date("d-M-Y",strtotime($dattessd['date'])).', '; } }
        } else {
            $attandance = $conn->query("SELECT * FROM tbl_attendance WHERE courseid='".$fetchstu['courseid']."' AND slotid='".$fetchstu['slotid']."' AND tbl_student_id='".$fetchstu['user']."' AND submitdate='".$dattessd['date']."' AND isDeleted='0'");
            if($attandance->num_rows > 0) { $ccn++; } else { $ccn++; $abs++; $missed.='Day '.$ccn.' on '.date("d-M-Y",strtotime($dattessd['date'])).', '; }
        }   
}
$missed = rtrim($missed,', ');
if($emailaccount['status'] == '1') {
    $txt1 = "Dear <b>".$ccname."</b>,<br><br>";
	$txt1 .= "This email is to inform you that $userdataname was marked absent from:<br><br>";
	$txt1 .= "<b>".$sqlcourses['title']." - ".$missed."</b><br><br>";
	$txt1 .= "To complete the course and obtain the certificate of attendance, please select from one of the following available make-up class dates:<br><br>";
	$txt1 .= "<table>";
	$course = $fetchstu['courseid'];$cnt=0;$dates='';
    $course_slots = $conn->query("SELECT * FROM course_slots WHERE courseid='".$course."' AND makecapacity > 0");
    while($fetchcouslot = $course_slots->fetch_assoc()) { $cnt++;$dates='';
        $location = $conn->query("SELECT * FROM locations WHERE id=".$fetchcouslot['locid'])->fetch_assoc();
        $cities = $conn->query("SELECT * FROM cities WHERE id=".$fetchcouslot['cityid'])->fetch_assoc();
        $states = $conn->query("SELECT * FROM states WHERE id=".$cities['state_id'])->fetch_assoc();
        $opurse_startdates = $conn->query("SELECT * FROM course_dates WHERE slot_id='".$fetchcouslot['id']."' ORDER BY date ASC LIMIT 1")->fetch_assoc();
        $opurse_enddates = $conn->query("SELECT * FROM course_dates WHERE slot_id='".$fetchcouslot['id']."' ORDER BY date DESC LIMIT 1")->fetch_assoc();
        $cpurse_dates = $conn->query("SELECT * FROM course_dates WHERE slot_id='".$fetchcouslot['id']."' AND date > '".date('Y-m-d')."' ORDER BY date ASC");
        $ccnntt=0; 
        while($fetchdates = $cpurse_dates->fetch_assoc()) {$ccnntt++;
            $courid = encryptStringArray($fetchdates['id']);
            $startdate = date('d/M/Y', strtotime($fetchdates['date']));
            $starttimeh = date('h:i A', strtotime($fetchdates['starttime']));
            $endtimeh = date('h:i A', strtotime($fetchdates['endtime']));
            $dates .= "<a href='$url/request/$id/$courid'><b>".$startdate." (".$starttimeh."-".$endtimeh.") - ".$location['title']." ".$location['location']." ".$cities['name']." ".$states['name']."</b></a><br>";
        }
        $slotid = $fetchcouslot['id'];
        $course_dates = $conn->query("SELECT * FROM course_dates WHERE slot_id='".$fetchcouslot['id']."' ORDER BY date DESC LIMIT 1")->fetch_assoc();
        if($course_dates['date'] >= date('Y-m-d')) {
            $txt1 .= "<tr>".
                "<td>".$dates."</td>".
            "</tr>";
        }
    } 
	$txt1 .= "</table><br><br>";
	$txt1 .= "To book the make-up class, simple click the date of the preferred date of attendance and follow the prompts.<br><br>";
	$txt1 .= "If you experience any issues booking a sesison, please contact $impacttitle at $impactphone or $impactem <br><br>";
	$txt1 .= "Kind Regards, <br><br>";
	$txt1 .= "<b>".$emailaccount['title1']."</b><br>";
	$txt1 .= "<b>".$emailaccount['email1']."</b><br>";
	$txt1 .= "<b>".$emailaccount['phone']."</b><br>";
    $mail = new PHPMailer(true);
    try {
        $mail->SMTPDebug  = 0; // debugging: 1 = errors and messages, 2 = messages only
        $mail->SMTPAuth   = true; // authentication enabled
        $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
        $mail->Host       = $emailaccount['host'];; // SMTP server
        $mail->Port       = $emailaccount['port'];                    // set the SMTP port for the GMAIL server
        $mail->IsHTML(true);
        $mail->Username   = $emailaccount['email']; // SMTP account username
        $mail->Password   = $emailaccount['password'];       // SMTP account password
        $mail->addAddress($email, $userdataname);  //Add a recipient
        if(!empty($ccemail) && $ccemail != '') {
            $mail->AddCC($ccemail, $ccname);
        }
        $mail->setFrom($impactem, $impacttitle);
        $mail->addReplyTo($impactem, $impacttitle);
        $mail->Subject = "Welcome to Company!!";
        $mail->Body    = $txt1;
        if($mail->Send()) {
            echo 'success';
        }
    } catch (phpmailerException $e) {
      $err = $e->errorMessage(); 
    } catch (Exception $e) {
      $err = $e->getMessage(); //Boring error messages from anything else!
    }
}
?>