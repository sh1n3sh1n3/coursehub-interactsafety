<?php include('session.php');
$userdata = $conn->query("SELECT * FROM registration WHERE id=".$_POST['user'])->fetch_assoc();
?>
<div class="modal-header">
<h4 class="modal-title"><center><?php echo $userdata['title'].' '.$userdata['fname'].' '.$userdata['lname']; ?> Attandance</center></h4>
</div>
<div class="modal-body">
    <div class='alert alert-dismissible alert-success sucmsg' style="display:none;">
	  <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
	  <p id="sucmsg"></p>
	</div>
    <div class='alert alert-dismissible alert-danger errmsg' style="display:none;">
	  <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
	  <p id="errmsg"></p>
	</div>
<div class="table-responsive">
	<table class="table table-striped table-bordered table-hover dataTables-example" >
	<thead>
	<tr>
		<th>Sr. No.</th>
		<th>Date</th>
		<th>Course</th>
		<th>Slot</th>
		<th>Sign</th>
		<th>Type</th>
		<th>Verify</th>
		<th>Remove</th>
		<th>Comment</th> 
	</tr>
	</thead>
	<tbody>
	<?php $count=0;$dates='';
		//$contact = $conn->query("SELECT * FROM tbl_attendance WHERE courseid = '".$_POST['course']."' AND slotid='".$_POST['slot']."' AND tbl_student_id='".$_POST['user']."' order by tbl_attendance_id asc");
	$contact = $conn->query("SELECT * FROM tbl_attendance WHERE courseid = '".$_POST['course']."' AND tbl_student_id='".$_POST['user']."' AND slotid='".$_POST['slot']."' AND teacherid='".$_POST['teacher']."' order by tbl_attendance_id asc");
	if($contact->num_rows > 0) {$dates='';
	while($data = $contact->fetch_assoc()) {
		$count++;$id = $data['tbl_attendance_id'];
		$fetch = $conn->query("SELECT * FROM registration WHERE id=".$data['tbl_student_id'])->fetch_assoc();
        $sqlcourses = $conn->query("SELECT * FROM courses WHERE id='".$data['courseid']."'")->fetch_assoc();
        $sqlcourseslot = $conn->query("SELECT * FROM course_slots WHERE courseid='".$data['courseid']."' AND id='".$data['slotid']."'")->fetch_assoc();
        $ccnntt=0; 
        $cpurse_dates = $conn->query("SELECT * FROM course_dates WHERE slot_id='".$data['slotid']."' ORDER BY date ASC");
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
        <td><img src="<?php echo '../'.$data['esignature']; ?>" width="100px"/></td>
        <td><?php echo ucfirst($data['type']); ?> Class</td>
        <?php if($data['isVerified'] == '1') { ?>
        <td><input type="checkbox" id="verr<?php echo $id; ?>" checked onclick="return false"/></td>
        <?php } else { ?>
        <td><input type="checkbox" id="verr<?php echo $id; ?>" onclick="verify(<?php echo $id; ?>)"/></td>
        <?php } ?>
        <?php if($data['isVerified'] == '2') { ?>
        <td><input type="checkbox" checked id="rem<?php echo $id; ?>" onclick="return false"/></td>
        <?php } else { ?>
        <td><input type="checkbox" id="rem<?php echo $id; ?>" onclick="remove(<?php echo $id; ?>)"/></td>
        <?php } ?>
        <td><input type="text" id="comments<?php echo $id; ?>" class="form-control" value="<?php echo $data['comments']; ?>"/></td>
	</tr>
	<?php }} else { echo '<tr><td colspan="9"><center>No records found!</center></td></tr>';} ?>
	</tbody>
	</table>
</div>
</div>