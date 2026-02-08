<?php include('session.php');
$userdata = $conn->query("SELECT * FROM registration WHERE id=".$_POST['user'])->fetch_assoc();
?>
<div class="modal-header"> 
<h4 class="modal-title"><center><?php echo $userdata['title'].' '.$userdata['fname'].' '.$userdata['lname']; ?> Attandance</center></h4>
</div>
<div class="modal-body">
<div class="table-responsive">
	<table class="table table-striped table-bordered table-hover dataTables-example" >
	<thead>
	<tr>
		<th>Sr. No.</th>
		<th>Date</th>
		<th>Course</th>
		<th>Slot</th>
		<th>Type</th>
		<th>Sign</th>
	</tr>
	</thead>
	<tbody>
	<?php $count=0;$dates='';
	$contact = $conn->query("SELECT * FROM tbl_attendance WHERE courseid = '".$_POST['course']."' AND tbl_student_id='".$_POST['user']."' AND slotid='".$_POST['slot']."' order by tbl_attendance_id asc");
	if($contact->num_rows > 0) {
	while($data = $contact->fetch_assoc()) {$dates='';
		$count++;$id = $data['id'];
		$fetch = $conn->query("SELECT * FROM registration WHERE id=".$data['tbl_student_id'])->fetch_assoc();
        $sqlcourses = $conn->query("SELECT * FROM courses WHERE id='".$data['courseid']."'")->fetch_assoc();
        $sqlcourseslot = $conn->query("SELECT * FROM course_slots WHERE courseid='".$data['courseid']."' AND id='".$data['slotid']."'")->fetch_assoc();
        $cpurse_dates = $conn->query("SELECT * FROM course_dates WHERE slot_id='".$data['slotid']."' ORDER BY date ASC");
        $ccnntt=0; 
        $date = date('Y-m-d', strtotime($data['time_in']));
        while($fetchdates = $cpurse_dates->fetch_assoc()) {$ccnntt++;
            $startdate = $fetchdates['date'];
            if($date == $startdate) {
                $dates = 'Day '.$ccnntt;
            } 
        }
		?>
	<tr>
		<td><?php echo $count; ?>. </td>
        <td><?php echo date('d-M-Y h:i A', strtotime($data['time_in'])); ?></td>
        <td><?php echo $sqlcourses['title']; ?></td>
        <td><?php echo $dates; ?></td>
        <td><?php echo ucfirst($data['type']); ?> Class</td>
        <td><img src="<?php echo '../'.$data['esignature']; ?>" width="100px"/></td>
	</tr>
	<?php }} else { echo '<tr><td colspan="6"><center>No records found!</center></td></tr>';} ?>
	</tbody>
	</table>
</div>
</div>