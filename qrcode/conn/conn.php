<?php
$servername = "localhost";
$username = "nrbellezza_pinnacle_user";
$password = "Company@123#";
$dbname = "nrbellezza_nrbellez_qr_attendance_db";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
