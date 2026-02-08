<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
$mail = new PHPMailer(true);

try {
    // Server settings
    $mail->isSMTP();
    $mail->Host       = 'mail.interactsafety.com.au';   // Outlook 365 SMTP
    $mail->SMTPAuth   = true;
    $mail->Username   = 'info@interactsafety.com.au'; // full O365 email address
    $mail->Password   = 'NsQ9RW=tjCi='; // use app password if MFA enabled
    $mail->SMTPSecure = 'tls'; // TLS is required for Office365
    $mail->Port       = 465;
	$mail->SMTPDebug = 2;
    // Recipients
    $mail->setFrom('support@advancedhq.com', 'AP');
    $mail->addAddress('developer1@dioztechsystems.com', 'Dev');

    // Content
    $mail->isHTML(true);
    $mail->Subject = 'Test Email via Office 365 SMTP';
    $mail->Body    = '<p>This is a <b>test</b> email sent using PHPMailer with Outlook 365 SMTP.</p>';

    $mail->send();
    echo "Message has been sent successfully!";
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>