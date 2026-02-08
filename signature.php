 <?php session_start();
include('include/conn.php');
include('include/enc_dec.php');
$courseid = decryptStringArray($_GET['courseid']);
$locid = decryptStringArray($_GET['locid']);
$slotid = decryptStringArray($_GET['slotid']);
$teacherid = decryptStringArray($_GET['teacherid']); 
$userid = decryptStringArray($_GET['userid']); 
$type = decryptStringArray($_GET['type']); 
if(isset($_SERVER['HTTPS'])){
    $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
} else {
    $protocol = 'http';
}
$domian = $protocol . "://" . $_SERVER['HTTP_HOST'];
$date = date('Y-m-d');
$tbl_courses = $conn->query("SELECT * FROM courses WHERE id='".$courseid."'")->fetch_assoc();
$tbl_courseslot = $conn->query("SELECT * FROM course_slots WHERE id='".$slotid."'")->fetch_assoc();
$tbl_courseslotdate = $conn->query("SELECT * FROM course_dates WHERE slot_id='".$slotid."' ORDER BY date ASC LIMIT 1")->fetch_assoc();
$ccnntt=0;  $dates= '';
$cpurse_dates = $conn->query("SELECT * FROM course_dates WHERE slot_id='".$slotid."' ORDER BY date ASC");
while($fetchdates = $cpurse_dates->fetch_assoc()) {$ccnntt++;
    $startdate = $fetchdates['date'];
    if($date == $startdate) {
        $dates = 'Day '.$ccnntt;
    } 
}
$fetch = $conn->query("SELECT * FROM registration WHERE id = '".$userid."'")->fetch_assoc();
$coursecode = date('ymd', strtotime($tbl_courseslotdate['date'])).$courseid.'.'.sprintf("%02d", $tbl_courses['duration']); 
?><!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Signature</title>
  <meta name="description"
    content="Signature Pad - HTML5 canvas based smooth signature drawing using variable width spline interpolation.">

  <meta name="viewport"
    content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">

  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black">
  <link rel="stylesheet" href="<?php echo $domian; ?>/signature-lib/signature_pad-master/docs/css/signature-pad.css">
  </head>

<body onselectstart="return false">
  <div id="signature-pad" class="signature-pad">
      <p style="font-size:13px;color:#D8701A;margin-bottom:0">
        <b><?php echo $tbl_courses['title']; ?></b>
        <b style="float:right"><?php echo $dates; ?></b>
    </p>
    <p style="font-size:13px;color:#D8701A;margin-bottom:0;text-align:center"><?php echo date('d-M-Y');?></p>
    <div id="canvas-wrapper" class="signature-pad--body">
      <canvas width="831" style="touch-action: none; user-select: none;" height="247">
    </div>
    <div class="signature-pad--footer">
      <div>
        <span style="color:#000;font-weight:bold"><?php echo $coursecode;?></span> &nbsp;
        <span style="color:#000;font-weight:bold"><?php echo $fetch['fname'].' '.$fetch['lname'];?></span>
      </div>
      <div class="signature-pad--actions">
        <div class="column">
          <button type="button" class="button clear" data-action="clear">Clear</button>
          <button style="display:none" type="button" class="button" data-action="undo" title="Ctrl-Z">Undo</button>
          <button style="display:none" type="button" class="button" data-action="redo" title="Ctrl-Y">Redo</button>
          <br/>
          <button style="display:none" type="button" class="button" data-action="change-color">Change color</button>
          <button style="display:none" type="button" class="button" data-action="change-width">Change width</button> 
          <button style="display:none" type="button" class="button" data-action="change-background-color">Change background color</button>
        </div>
        <div class="column">
          <button type="button" class="button save btn btn-primary btn-xs" data-action="save-png" id="Sabeuplabtn" style="color: #fff;background-color: #17a2b8;border-color: #17a2b8;">Submit</button>
          <button style="display:none" type="button" class="button save" data-action="save-jpg">Save as JPG</button>
          <button style="display:none" type="button" class="button save" data-action="save-svg">Save as SVG</button>
          <button style="display:none" type="button" class="button save" data-action="save-svg-with-background">Save as SVG with
            background</button>
        </div>
      </div>
      <div>
        <button style="display:none" type="button" class="button" data-action="open-in-window">Open in Window</button>
      </div>
    </div>
  </div>
  <div style="display:none" id="myloader"></div>
      <input type="hidden" id="courseid" value="<?php echo $courseid; ?>"/>
      <input type="hidden" id="locid" value="<?php echo $locid; ?>"/>
      <input type="hidden" id="slotid" value="<?php echo $slotid; ?>"/>
      <input type="hidden" id="teacherid" value="<?php echo $teacherid; ?>"/>
      <input type="hidden" id="userid" value="<?php echo $userid; ?>"/>
      <input type="hidden" id="type" value="<?php echo $type; ?>"/>
      <input type="hidden" id="url" value="<?php echo $domian; ?>/"/>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

  <script src="<?php echo $domian; ?>/signature-lib/signature_pad-master/docs/js/signature_pad.umd.min.js"></script>
  <script src="<?php echo $domian; ?>/signature-lib/signature_pad-master/docs/js/app.js"></script>
</body>

</html>
