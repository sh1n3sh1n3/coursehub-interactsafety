<?php include('includes/conn.php'); 
$cpurse_dates = $conn->query("SELECT * FROM course_dates WHERE slot_id='".$_POST['slotid']."' AND date='".$_POST['date']."'");
if($cpurse_dates->num_rows > 0) {
    echo '1';
} else {
    echo '0';
}
?>