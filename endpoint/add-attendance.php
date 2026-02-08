<?php
session_start();
include('../include/conn.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['qr_code'])) {
        $qrCode = $_POST['qr_code'];
        $selectStmt = $conn->query("SELECT id FROM registration WHERE generated_code = '".$qrCode."'");

        if ($selectStmt->num_rows) {
            $result = $selectStmt->fetch_assoc();
            
            if ($result !== false) {
                $studentID = $result["id"];
                $timeIn =  date("Y-m-d H:i:s");
                $stmt = $conn->query("INSERT INTO tbl_attendance (tbl_student_id, time_in) VALUES ('".$studentID."', '".$timeIn."')");
            } else {
                echo "No student found in QR Code";
            }
        } else {
            echo "Failed to execute the statement.";
        }

    } else {
        echo "
            <script>
                alert('Please fill in all fields!');
                window.location.href = '../index.php';
            </script>
        ";
    }
}
?>
