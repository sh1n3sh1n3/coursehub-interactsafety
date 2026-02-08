<option value="">Select</option>
<?php include('includes/conn.php'); 
$course = $_POST['course']; 
$attandance = $conn->query("SELECT count(*) as count,tbl_student_id FROM tbl_attendance WHERE slotid='".$course."' GROUP by tbl_student_id");
while($fetch = $attandance->fetch_assoc()) {
    if($fetch['count'] >= '1') { 
        $sale = $conn->query("SELECT * FROM sale WHERE slotid='".$course."' AND user='".$fetch['tbl_student_id']."'");
        if($sale->num_rows > 0) {
        $fetchers = $conn->query("SELECT * FROM registration WHERE id=".$fetch['tbl_student_id'])->fetch_assoc();?>
        <option value="<?php echo $fetchers['id']; ?>"><?php echo $fetchers['title'].' '.$fetchers['fname'].' '.$fetchers['lname']; ?></option>
    <?php }}} ?>