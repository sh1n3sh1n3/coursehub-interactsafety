<option value="">Select</option>
<?php include('includes/conn.php'); 
$course = $_POST['course'];
$student = $_POST['student'];
$slot = $_POST['slot'];
$attandance = $conn->query("SELECT * FROM sale WHERE courseid='".$course."' AND slotid='".$slot."' AND user='".$student."'");
    if($attandance->num_rows > 0) {
while($fetch = $attandance->fetch_assoc()) {
        $slotid = $fetch['slotid'];
        $cnt =0;$course_dates = $conn->query("SELECT * FROM course_dates WHERE course_id='".$course."' AND slot_id='".$slotid."' ORDER by date ASC");
        while($fetchdates = $course_dates->fetch_assoc()) { $cnt++;
            $fetchers = $conn->query("SELECT * FROM tbl_attendance WHERE courseid='".$course."' AND slotid='".$slotid."' AND tbl_student_id='".$student."' AND date(time_in) = '".$fetchdates['date']."'");
            if($fetchers->num_rows > 0) {} else {
            ?>
            <option value="<?php echo $cnt; ?>"><?php echo $cnt; ?></option>
    <?php }}}} ?>