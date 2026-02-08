<?php session_start(); 
include 'include/conn.php'; 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
$emailaccount = $conn->query("SELECT * FROM emails WHERE type='support'")->fetch_assoc();
$impacttitle = $emailaccount['title1'];
$impactph = $emailaccount['phone'];
$impactem = $emailaccount['email1'];
$val = mysqli_real_escape_string($conn, $_POST['val']);
$otp = rand(111111,999999);
    $txt1 = "Dear Student,<br>";
    $txt1 .= "Your OTP is ".$otp.",<br>";
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
        $mail->addAddress($val, $val);  //Add a recipient
        $mail->setFrom($impactem, $impacttitle);
        $mail->addReplyTo($impactem, $impacttitle);
        $mail->Subject = "Welcome to Company!!";
        $mail->Body    = $txt1;
        if($mail->Send()) {
            $_SESSION['ver_OTP'] = $otp;
            echo '1';
        }
    } catch (phpmailerException $e) {
      $err = $e->errorMessage(); 
    } catch (Exception $e) {
      $err = $e->getMessage(); //Boring error messages from anything else!
    }
    echo $err;
?>