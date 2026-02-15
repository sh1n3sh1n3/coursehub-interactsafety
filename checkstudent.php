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
$type = $_POST['type'];
$otp = rand(111111,999999);
$check = $conn->query("SELECT * FROM registration WHERE ".$type."='".$val."' AND verifyEmail = '1'")->num_rows;
if($check > 0) {
    $fetchddtt = $conn->query("SELECT * FROM registration WHERE ".$type."='".$val."'")->fetch_assoc();
    if($_POST['password'] == $fetchddtt['password']) {
        $_SESSION['pin_user'] = $fetchddtt['id'];
    	echo '1';
    } else {
        echo '2';
    }
} else {
    $err = '';
    $txt1 = "Dear Student,<br>";
    $txt1 .= "Your OTP is ".$otp.",<br>";
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->SMTPDebug  = 0; // debugging: 1 = errors and messages, 2 = messages only
        $mail->SMTPAuth   = true; // authentication enabled
        $mail->SMTPSecure = 'tls'; // port 587 uses STARTTLS
        $mail->Host       = $emailaccount['host']; // SMTP server
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
            echo '5';
            exit;
        }
    } catch (\PHPMailer\PHPMailer\Exception $e) {
        $err = $e->getMessage();
    } catch (Exception $e) {
        $err = $e->getMessage(); //Boring error messages from anything else!
    }
    if ($err !== '') {
        echo $err;
    }
}
?>