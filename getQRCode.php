<?php session_start();
include('include/conn.php');
$PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;
$PNG_WEB_DIR = 'temp/';
include "phpqrcode/qrlib.php";        
if (!file_exists($PNG_TEMP_DIR))
mkdir($PNG_TEMP_DIR);
$filename = $PNG_TEMP_DIR.'test.png';
$errorCorrectionLevel = 'H';   
$matrixPointSize = 6;  
if(isset($_SERVER['HTTPS'])){
    $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
} else {
    $protocol = 'http';
}
$domian = $protocol . "://" . $_SERVER['HTTP_HOST'];
$generated_code = $domian.'/submitAttandance/'.$_POST["course"].'/'.$_POST["locid"].'/'.$_POST["slot"].'/'.$_POST["user"];
$qrdata = $generated_code;
QRcode::png($qrdata, $filename, $errorCorrectionLevel, $matrixPointSize, 2);
$img = file_get_contents($PNG_WEB_DIR.basename($filename));
$data = base64_encode($img); 
echo '<center><img src="data:image/png;base64,'.$data.'" /></center>';
?>
