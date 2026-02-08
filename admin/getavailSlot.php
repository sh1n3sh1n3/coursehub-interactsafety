<option value="">Select</option>
<?php  include('includes/conn.php'); 
$course = $_POST['course'];$dates='';
$slotsget = $conn->query("SELECT * FROM course_slots WHERE courseid='".$course."'");
while($fetchetach = $slotsget->fetch_assoc()) {$dates='';
$course_dates = $conn->query("SELECT * FROM course_dates WHERE course_id='".$course."' AND slot_id='".$fetchetach['id']."'");
while($fetchdates = $course_dates->fetch_assoc()) {
    $dates .= date('d-M-Y', strtotime($fetchdates['date'])).', ';
}
$dates = rtrim($dates, ", ");
?>
<option value="<?php echo $fetchetach['id']; ?>"><?php echo $dates; ?></option>
<?php } ?>