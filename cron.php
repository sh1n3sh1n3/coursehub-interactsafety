<?php 
session_start();
include 'include/conn.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
$emailaccount = $conn->query("SELECT * FROM emails WHERE type='support'")->fetch_assoc();
$impacttitle = $emailaccount['title1'];
$emailto = $emailaccount['emailto'];
$nameto = $emailaccount['nameto'];
$impactem = $emailaccount['email1'];
if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')   
         $url = "https://";   
    else  
         $url = "http://";   
    // Append the host(domain name, ip) to the URL.   
    $url.= $_SERVER['HTTP_HOST'];   
    $url .= '/extension_form.php';
$sale = $conn->query("SELECT * FROM sale WHERE generateCertificate='0'");
while($fetch = $sale->fetch_assoc()) {
    $user = $fetch['user'];
    $courseid = $fetch['courseid'];
    $slotid = $fetch['slotid'];
    $regis = $conn->query("SELECT * FROM registration WHERE id='".$user."'")->fetch_assoc();
    $email = $regis['email'];
    $fname  = $regis['title'].' '.$regis['fname'].' '.$regis['lname'];
    $tbl_attendance = $conn->query("SELECT * FROM tbl_attendance WHERE tbl_student_id='".$user."' AND courseid='".$courseid."' AND slotid='".$slotid."'");
    if($tbl_attendance->num_rows < 5 && $tbl_attendance->num_rows >= 1) {
        $attandance = $conn->query("SELECT * FROM tbl_attendance WHERE tbl_student_id='".$user."' AND courseid='".$courseid."' AND slotid='".$slotid."' ORDER BY tbl_attendance_id  ASC LIMIT 1")->fetch_assoc();
        $timein = date('Y-m-d', strtotime($attandance['time_in']));
        $curdate = date('Y-m-d');
        $sixmonthdate = date("Y-m-d", strtotime("+6 months", strtotime($timein)));
        if($sixmonthdate == $curdate) {
        $txt1 = "Dear ".$fname.",<br><br>";
		$txt1 .= "Please click on below link to request for the extension for your course.<br>";
		$txt1 .= "".$url."<br><br>";
		$txt1 .= "<br>Regards<br>Company";
	    $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->SMTPDebug  = 0;
            $mail->Host       = $emailaccount['host'];
            $mail->Port       = $emailaccount['port'];
            $mail->SMTPSecure = 'tls'; // port 587 uses STARTTLS
            $mail->SMTPAuth   = true;
            $mail->IsHTML(true);
            $mail->Username   = $emailaccount['email']; // SMTP account username
            $mail->Password   = $emailaccount['password'];       // SMTP account password
            $mail->addAddress($email, $fname);  //Add a recipient
            $mail->setFrom($impactem, $impacttitle);
            $mail->addReplyTo($impactem, $impacttitle);
            $mail->Subject = "Link to Request for Extension!!";
            $mail->Body    = $txt1;
            if($mail->Send()) {
                // $msg = 'Data Added Successfully.';
            }
        } catch (phpmailerException $e) {
          $err = $e->errorMessage(); 
        } catch (Exception $e) {
          $err = $e->getMessage(); //Boring error messages from anything else!
        }
        }
    }
}

?>