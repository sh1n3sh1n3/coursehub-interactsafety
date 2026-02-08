<?php include('session.php'); 
require_once('../phpmailer/class.phpmailer.php');
$emailaccount = $conn->query("SELECT * FROM emails WHERE type='support'")->fetch_assoc();
$refitcertifiedph = $emailaccount['phone'];
$refitcertifiedem = $emailaccount['email1'];
$userdata = $conn->query("SELECT * FROM users WHERE id = '".$_GET['id']."'")->fetch_assoc();
$userdataname = $userdata['name'];
$userdataemail = $userdata['email'];
$userdatapassword = $userdata['password'];
$txt25 = ' <div style="margin:20px;box-sizing:border-box;font-family:Arial;color:#333;"><div style="width:600px;border:5px solid #3488bf;background-color:white;overflow:auto;margin:auto;padding:10px;box-sizing:border-box">            <div style="width:100%;float:left;padding:10px;box-sizing:border-box;background-color:#F1F1F1;height:100px">                <center><img src="https://www.refitcertified.com/assets/images/cs-logo.png" style="width:200px;height:80px"></center></div><div style="width:100%;float:left;padding:10px;text-align:center;box-sizing:border-box;background-color:white;height:100px">                <h4>RE-FIT<sup>&#174;</sup> Certified<br /><small>100% online training. Study at your own place.<br /> Email: '.$refitcertifiedem.'</small></h4></div><div style="width:100%;float:left;padding:10px;box-sizing:border-box;"><br /><strong>Hey Admin,</strong>  <br /><p style="text-align:justify;">New User is Registred to RE-FIT<sup>&#174;</sup> Certified.</p><p style="text-align:justify;">RE-FIT<sup>&#174;</sup> is a fitness academy that provides a range of customized global standard training courses to help you secure your place in the fitness industry. RE-FIT® has been working in the fitness industry for over a decade, with the goal of catering to the global health and fitness market. We train our students to achieve their potential to the maximum and grab promising positions in the evolving fitness industry.</p><p style="text-align:justify;">Login Credentials : <br> <b>Name : </b> '.$userdataname.' <br> <b>Email : </b> '.$userdataemail.' <br> <b>Password : </b> '.$userdatapassword.'</p><p style="text-align:justify;">We are happy to serve you.</p> <center><h1>Stay Safe, Stay Happy</h1><br><a href="https://refitcertified.com" target="_blank" style="padding:10px;box-sizing:border-box;border-radius:5px;background-color:#337AB7;color:white;text-decoration:none">Click Here to login</a></center></div><hr /><div style="width:100%;float:left;padding:10px;box-sizing:border-box;background-color:#3488bf;color:white;margin-top:50px;">                <center><h5>RE-FIT<sup>&#174;</sup> Certified<br /><small style="color:white">100% online training. Study at your own place.<br /> Email: <span style="color:#fff"><a style="color:#fff" href="mailto:'.$refitcertifiedem.'">'.$refitcertifiedem.'</a></span></small></h5></center></div></div></div>';
    $mail = new PHPMailer(true);
    $mail->IsSMTP(); // telling the class to use SMTP
    
    try {
      $mail->Host       = $emailaccount['host'];; // SMTP server
      $mail->SMTPDebug  = 0;                     // enables SMTP debug information (for testing)
      $mail->SMTPAuth   = true;                  // enable SMTP authentication
      $mail->Port       = $emailaccount['port'];                    // set the SMTP port for the GMAIL server
      $mail->Username   = $emailaccount['email']; // SMTP account username
      $mail->Password   = $emailaccount['password'];       // SMTP account password
	  $mail->AddAddress("refitcertified@gmail.com", "REFIT Certified");     //Add a recipient
      $mail->SetFrom('no-reply@refitcertified.com', 'RE-FIT Certified');
      $mail->AddReplyTo('no-reply@refitcertified.com', 'RE-FIT Certified');
	  $mail->Subject = "New User Registred on RE-FIT Certified with name ". $userdataname;
	  $mail->isHTML(true);  
      $mail->Body    = $txt25;
      $mail->Send();
      $msg =  "Message Sent OK</p>\n";
    } catch (phpmailerException $e) {
      $err = $e->errorMessage(); 
    } catch (Exception $e) {
      $err = $e->getMessage(); //Boring error messages from anything else!
    }
    echo '<script>alert("Email Send Successfully!!");window.location.href="users.php"</script>'
?>