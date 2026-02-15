<?php @session_start(); include 'include/conn.php'; 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
$emailaccount = $conn->query("SELECT * FROM emails WHERE type='support'")->fetch_assoc();
$impacttitle = $emailaccount['title1'];
$impactph = $emailaccount['phone'];
$impactem = $emailaccount['email1']; 
$reservation_username = mysqli_real_escape_string($conn, $_POST['reservation_username']);
$select = $conn->query("SELECT * FROM registration WHERE email LIKE '".$reservation_username."'");
if($select->num_rows > 0) {
    $fetch = $select->fetch_assoc();
    if($fetch['status'] == '1') {
        if($emailaccount['status'] == '1') {
		    $userdataname = $fetch['title'].' '.$fetch['fname'].' '.$fetch['lname'];
		    $txt1 = "Hi ".$fetch['fname'].",<br><br>";
			$txt1 .= "Your password is : ".$fetch['password']."<br>";
			$txt1 .= "Regards<br>Company";
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
                $mail->addAddress($reservation_username, $userdataname);  //Add a recipient
                $mail->setFrom($impactem, $impacttitle);
                $mail->addReplyTo($impactem, $impacttitle);
                $mail->Subject = "Password recovery email!!";
                $mail->Body    = $txt1;
                if($mail->Send()) {
                    // $msg = 'Data Added Successfully.';
                    echo 'success';
                }
            } catch (phpmailerException $e) {
              $err = $e->errorMessage(); 
            } catch (Exception $e) {
              $err = $e->getMessage(); //Boring error messages from anything else!
            }
            echo $err;
	    }
    } else {
        echo 'Account not active!!';
    }
} else {
    echo 'Please check your credentials. No record found!!';
}
?>