<?php session_start(); 
include 'include/conn.php'; 
$ourOTP = $_SESSION['ver_OTP'];
$subOTP = $_POST['reservation_otp'];
$Resendemail = $_POST['Resendemail'];
if($ourOTP == $subOTP) {
    $selectff = $conn->query("SELECT * FROM registration WHERE email LIKE '".$Resendemail."'");
    if($selectff->num_rows > 0) {
        $sqlup="UPDATE registration SET verifyEmail = '1' WHERE email='".$Resendemail."'";
        $update = $conn->query($sqlup);
    }
    echo 'Yes';
} else {
    echo 'No';
}
?>