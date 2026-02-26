<?php session_start();
include('include/conn.php');
include('include/enc_dec.php');
$courseid = decryptStringArray($_GET['courseid']);
$locid = decryptStringArray($_GET['locid']);
$slotid = decryptStringArray($_GET['slotid']);
$teacherid = decryptStringArray($_GET['teacherid']); 
if(isset($_SERVER['HTTPS'])){
    $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
} else {
    $protocol = 'http';
}
$domian = $protocol . "://" . $_SERVER['HTTP_HOST'];
$generated_code = $domian.'/studentLogin/'.encryptStringArray($courseid).'/'.encryptStringArray($locid).'/'.encryptStringArray($slotid).'/'.encryptStringArray($teacherid);
echo '<script>window.location.href="'.$generated_code.'";</script>'; exit;
/*
$date = date('Y-m-d');
$tbl_sale = $conn->query("SELECT * FROM sale WHERE user='".$_GET['userid']."' AND courseid='".$_GET['courseid']."' AND slotid='".$_GET['slotid']."'");
$tbl_makeup_classes = $conn->query("SELECT * FROM makeup_classes WHERE studentid='".$_GET['userid']."' AND courseid='".$_GET['courseid']."' AND slotid='".$_GET['slotid']."' AND date='".$date."'");
if($tbl_sale->num_rows > 0) {
    $tbl_attendance = $conn->query("SELECT * FROM tbl_attendance WHERE tbl_student_id='".$_GET['userid']."' AND courseid='".$_GET['courseid']."' AND slotid='".$_GET['slotid']."' AND submitdate = '".date('Y-m-d')."'");
    if($tbl_attendance->num_rows > 0) {
        $msg = 'Attadnace already submitted!';
        $st = 'SUCCESS';
    } else {
        $insert = $conn->query("INSERT INTO tbl_attendance(tbl_student_id, time_in, courseid, slotid, locid, submitdate) VALUES ('".$_GET['userid']."', '".date('Y-m-d H:i:s')."', '".$_GET['courseid']."', '".$_GET['slotid']."', '".$_GET['locid']."', '".date('Y-m-d')."')");
        $msg = 'Attadnace submit successfully.';
        $st = 'SUCCESS';
    }
} else if($tbl_makeup_classes->num_rows > 0) {
    $tbl_attendance = $conn->query("SELECT * FROM tbl_attendance WHERE tbl_student_id='".$_GET['userid']."' AND courseid='".$_GET['courseid']."' AND slotid='".$_GET['slotid']."' AND submitdate = '".date('Y-m-d')."'");
    if($tbl_attendance->num_rows > 0) {
        $msg = 'Attadnace already submitted!';
        $st = 'SUCCESS';
    } else {
        $insert = $conn->query("INSERT INTO tbl_attendance(tbl_student_id, time_in, courseid, slotid, locid, submitdate, type) VALUES ('".$_GET['userid']."', '".date('Y-m-d H:i:s')."', '".$_GET['courseid']."', '".$_GET['slotid']."', '".$_GET['locid']."', '".date('Y-m-d')."', 'makeup')");
        $msg = 'Attadnace submit successfully.';
        $st = 'SUCCESS';
    }
} else {
    $msg = 'Something wrong!! It seems like you are not authorized for this course. Please contact administration.';
    $st = 'FAIL';
} */
?>
<html dir="ltr" lang="en">
<head>
    <meta name="viewport" content="width=device-width,initial-scale=1.0" />
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <meta name="description" content=" " />
    <meta name="keywords" content=" " />
    <meta name="author" content="Interact Safety" />
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <title>Attandance | Interact Safety</title>
    <?php include("include/head_script.php"); ?>
    <style>
    html {
  scroll-behavior: smooth;
}
    </style>
</head>
   <body class>
      <div id="wrapper" class="clearfix">
         <div class="main-content">
            <section id="home" class="bg-lightest pt-50">
               <div class="text-center">
                  <div class="">
                     <div class="container pt-0 pb-0">
                        <div class="row">
                           <div class="col-md-7">
                              <h1 class="line-height-1em mt-0 mb-0 text-theme-colored"><?php echo $st; ?></h1>
                              <h3 class="mt-0"><?php echo $msg; ?></h3>
                              <p>Thank You.</p>
                              <a class="btn btn-border btn-gray btn-transparent btn-circled" href="index.php">Return Home</a>
                           </div>
                           <div class="col-md-4">
                              <h3>Some Useful Links</h3>
                              <div class="widget">
                                 <ul class="list-border">
                                    <li><a href="index.php">Home</a></li>
                                    <li><a href="about.php">About us</a></li>
                                    <li><a href="index.php">Courses</a></li>
                                    <li><a href="index.php">Student Login</a></li>
                                    <li><a href="contact.php">Contact</a></li>
                                 </ul>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </section>
         </div>
         <footer id="footer" class="footer bg-black-111">
            <div class="container p-20">
               <div class="row">
                  <div class="col-md-12 text-center">
                     <p class="mb-0">Copyright &copy;2024 Interact Safety. All Rights Reserved</p>
                  </div>
               </div>
            </div>
         </footer>
         <a class="scrollToTop" href="#"><i class="fa fa-angle-up"></i></a>
      </div>
      <?php include("include/footer_script.php"); ?>
   </body>
</html>