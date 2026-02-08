<?php include('session.php'); ?>
<table class="table table-striped table-bordered table-hover dataTables-example1" >
<thead>
<tr>
	<th colspan="3" style="vertical-align:middle; text-align:center;">Student details</th>
	<th colspan="2" style="vertical-align:middle; text-align:center;">Additional Info</th>
</tr>
<tr>
	<th style="vertical-align:middle; text-align:center;">Student ID</th>
	<th style="vertical-align:middle; text-align:center;">Name</th>
	<th style="vertical-align:middle; text-align:center;">Surname</th>
	<th style="vertical-align:middle; text-align:center;">Learning Adjustments</th>
	<th style="vertical-align:middle; text-align:center;">Dietry Requirements</th>
</tr>
</thead>
<tbody id="tablebody">
<?php $count=0;$attan=$markatt='';
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
	<td><?php echo ucfirst($userdata['title'].' '.$userdata['fname']); ?></td>
	<td><?php echo ucfirst($userdata['lname']); ?></td>
	<td><?php if(!empty($userdata['special_requirements'])) { echo ucfirst($userdata['special_requirements']); } else { echo 'N'; } ?></td>
	<td><?php if(!empty($userdata['food_requirements'])) { echo ucfirst($userdata['food_requirements']);  } else { echo 'N'; } ?></td>
</tr>
<?php } 
$makeupClassesCount = $conn->query("SELECT * FROM makeup_classes WHERE courseid='".$_POST['course']."' AND slotid='".$_POST['dates']."'")->num_rows;
if($makeupClassesCount > 0) {
?>
<tr>
	<th>Makeup Attendees</th>
	<th> &nbsp; </th>
	<th> &nbsp; </th>
	<th> &nbsp; </th>
	<th> &nbsp; </th>
</tr><?php $count=0;$attan=$markatt='';
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
	<td><?php echo ucfirst($userdata['title'].' '.$userdata['fname']); ?></td>
	<td><?php echo ucfirst($userdata['lname']); ?></td>
	<td><?php if(!empty($userdata['special_requirements'])) { echo ucfirst($userdata['special_requirements']); } else { echo 'N'; } ?></td>
	<td><?php if(!empty($userdata['food_requirements'])) { echo ucfirst($userdata['food_requirements']);  } else { echo 'N'; } ?></td>
</tr>
<?php } ?>
<?php } ?>
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
                    filename: 'Student Complete Register',
				},
			]

		});

	});
</script>