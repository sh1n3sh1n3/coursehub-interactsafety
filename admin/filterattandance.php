<?php include('session.php'); ?>
<table class="table table-striped table-bordered table-hover dataTables-example1" >
<thead>
<tr>
	<th style="vertical-align:middle; text-align:center;">Student ID</th>
	<th style="vertical-align:middle; text-align:center;">Name</th>
	<?php 
$query1 = "SELECT * FROM course_slots WHERE id <> 0";
if(isset($_POST['course']) && !empty($_POST['course'])) {
    $query1 .= " AND courseid='".$_POST['course']."'";
}
if(isset($_POST['dates']) && !empty($_POST['dates'])) {
    $query1 .= " AND id='".$_POST['dates']."'";
}
$contact1 = $conn->query($query1);
$fetch1 = $contact1->fetch_assoc();
$course_dates = $conn->query("SELECT * FROM course_dates WHERE slot_id='".$fetch1['id']."'");
$ccnntt=0;
while($dattess = $course_dates->fetch_assoc()) {$ccnntt++;
?>
	<th style="vertical-align:middle; text-align:center;">Day <?php echo $ccnntt; ?> <hr style="margin-top: 10px;margin-bottom: 10px;"> <?php echo date('d-m-Y', strtotime($dattess['date'])); ?> </th>
<?php } ?>
<th style="vertical-align:middle; text-align:center;">Attended <?php echo $ccnntt; ?> Days</th>
</tr>
</thead>
<tbody id="tablebody">
<?php $count=0; $attan=$markatt='';
$students = $conn->query("SELECT * FROM sale WHERE courseid='".$_POST['course']."' AND slotid='".$_POST['dates']."'");
while($fetchstu = $students->fetch_assoc()) {
	$count++;$id = $fetch['id'];
	$userdata = $conn->query("SELECT * FROM registration WHERE id='".$fetchstu['user']."'")->fetch_assoc();
	$sqlcourses = $conn->query("SELECT * FROM courses WHERE id='".$fetchstu['courseid']."'")->fetch_assoc();
	$slotdata = $conn->query("SELECT * FROM course_slots WHERE id='".$fetchstu['slotid']."'")->fetch_assoc();
    $coursefirstdate = $conn->query("SELECT * FROM course_dates WHERE slot_id='".$slotdata['id']."' ORDER by date ASC LIMIT 1")->fetch_assoc();
	$attan = strtoupper(substr($userdata['fname'], 0, 1).''.substr($userdata['lname'], 0, 1));
	?>
<tr>
	<td><?php echo date('ymd', strtotime($coursefirstdate['date'])).'.'.sprintf('%02d', $slotdata['id']).'.'.$attan; ?> </td>
	<td><?php echo ucfirst($userdata['title'].' '.$userdata['fname'].' '.$userdata['lname']); ?></td>
	<?php $ccn=0;
	$course_datesd = $conn->query("SELECT * FROM course_dates WHERE slot_id='".$fetchstu['slotid']."'");
    while($dattessd = $course_datesd->fetch_assoc()) { 
    $attandance = $conn->query("SELECT * FROM tbl_attendance WHERE courseid='".$fetchstu['courseid']."' AND slotid='".$fetchstu['slotid']."' AND tbl_student_id='".$fetchstu['user']."' AND isVerified='1' AND submitdate='".$dattessd['date']."' AND isDeleted='0'");
    if($attandance->num_rows > 0) { $ccn++;
        $markatt = $attan;
    } else {
        $markatt = '<i class="fa fa-close" style="color:red"></i>';
    } ?>
	<td><?php echo $markatt; ?></td> 
	<?php } ?>
	<td>Attended <?php echo $ccn; ?> Days</td> 
</tr>
<?php } 
$makeupClassesCount = $conn->query("SELECT * FROM makeup_classes WHERE courseid='".$_POST['course']."' AND slotid='".$_POST['dates']."'")->num_rows;
if($makeupClassesCount > 0) { ?>
<tr>
	<th>Make Up Day Attendees</th> 
	<th>&nbsp;</th> 
<?php 
$query1 = "SELECT * FROM course_slots WHERE id <> 0";
if(isset($_POST['course']) && !empty($_POST['course'])) {
    $query1 .= " AND courseid='".$_POST['course']."'";
}
if(isset($_POST['dates']) && !empty($_POST['dates'])) {
    $query1 .= " AND id='".$_POST['dates']."'";
}
$contact1 = $conn->query($query1);
$fetch1 = $contact1->fetch_assoc();
$course_dates = $conn->query("SELECT * FROM course_dates WHERE slot_id='".$fetch1['id']."'");
$ccnntt=0;
while($dattess = $course_dates->fetch_assoc()) {$ccnntt++;
?>
	<th>&nbsp;</th>
<?php } ?>
	<th>&nbsp;</th> 
</tr>
<?php $count=0; $attan=$markatt='';
$students = $conn->query("SELECT * FROM makeup_classes WHERE courseid='".$_POST['course']."' AND slotid='".$_POST['dates']."'");
while($fetchstu = $students->fetch_assoc()) {
	$count++;$id = $fetch['id'];
	$userdata = $conn->query("SELECT * FROM registration WHERE id='".$fetchstu['studentid']."'")->fetch_assoc();
	$sqlcourses = $conn->query("SELECT * FROM courses WHERE id='".$fetchstu['courseid']."'")->fetch_assoc();
	$slotdata = $conn->query("SELECT * FROM course_slots WHERE id='".$fetchstu['slotid']."'")->fetch_assoc();
    $coursefirstdate = $conn->query("SELECT * FROM course_dates WHERE slot_id='".$slotdata['id']."' ORDER by date ASC LIMIT 1")->fetch_assoc();
	$attan = strtoupper(substr($userdata['fname'], 0, 1).''.substr($userdata['lname'], 0, 1));
	?>
<tr>
	<td><?php echo date('ymd', strtotime($coursefirstdate['date'])).'.'.sprintf('%02d', $slotdata['id']).'.'.$attan; ?> </td>
	<td><?php echo ucfirst($userdata['title'].' '.$userdata['fname'].' '.$userdata['lname']); ?></td>
	<?php $ccn=0;
	$course_datesd = $conn->query("SELECT * FROM course_dates WHERE slot_id='".$fetchstu['slotid']."'");
    while($dattessd = $course_datesd->fetch_assoc()) { 
    $attandance = $conn->query("SELECT * FROM tbl_attendance WHERE courseid='".$fetchstu['courseid']."' AND slotid='".$fetchstu['slotid']."' AND tbl_student_id='".$fetchstu['studentid']."' AND isVerified='1' AND submitdate='".$dattessd['date']."' AND isDeleted='0'");
    if($attandance->num_rows > 0) { $ccn++;
        $markatt = $attan;
    } else {
        $markatt = '<i class="fa fa-close" style="color:red"></i>';
    } ?>
	<td><?php echo $markatt; ?></td> 
	<?php } ?>
	<td>Attended <?php echo $ccn; ?> Days</td> 
</tr>
<?php }} ?>
</tbody>
</table>
<script>
    $(document).ready(function(){
		$('.dataTables-example1').DataTable({
			pageLength: 25,
			responsive: true,
			"ordering": false,
			dom: '<"html5buttons"B>lTfgitp',
			buttons: [
				{
				    extend: 'csv',
				    text:   'Export',
                    filename: 'Student Register',
				},
			]

		});

	});
</script>