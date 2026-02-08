<?php include('session.php'); ?>
<table class="table table-striped table-bordered table-hover dataTables-example1" >
<thead>
<tr>
	<th colspan="3" style="vertical-align:middle; text-align:center;">Participant details</th>
	<th colspan="2" style="vertical-align:middle; text-align:center;">Special needs</th>
	<th colspan="5" style="vertical-align:middle; text-align:center;">Scheduled days</th>
	<th colspan="4" style="vertical-align:middle; text-align:center;">Makeup days</th>
	<th style="vertical-align:middle; text-align:center;">WorkSafe extension training</th>
	<th style="vertical-align:middle; text-align:center;">Trainer verification of attandance</th>
	<th colspan="3" style="vertical-align:middle; text-align:center;">Feedback completed</th>
	<th style="vertical-align:middle; text-align:center;">Trainer comment</th>
</tr>
<tr>
	<th style="vertical-align:middle; text-align:center;">Student ID</th>
	<th style="vertical-align:middle; text-align:center;">Name</th>
	<th style="vertical-align:middle; text-align:center;">Surname</th>
	<th style="vertical-align:middle; text-align:center;">Special Adjustments</th>
	<th style="vertical-align:middle; text-align:center;">Dietry Requirements</th>
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
	<th style="vertical-align:middle; text-align:center;">Day 2</th>
	<th style="vertical-align:middle; text-align:center;">Day 3</th>
	<th style="vertical-align:middle; text-align:center;">Day 4</th>
	<th style="vertical-align:middle; text-align:center;">Day 5</th>
	<th style="vertical-align:middle; text-align:center;">WorkSafe Training</th>
	<th style="vertical-align:middle; text-align:center;">Issue date</th>
	<th style="vertical-align:middle; text-align:center;">Worksafe feedback</th>
	<th style="vertical-align:middle; text-align:center;">ATAR report</th>
	<th style="vertical-align:middle; text-align:center;">Complaints raised</th>
	<th style="vertical-align:middle; text-align:center;">Comments</th>
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
	<td><?php echo ucfirst($userdata['special_requirements']); ?></td>
	<td><?php echo ucfirst($userdata['food_requirements']); ?></td>
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
	<?php
	$datearray = array(2,3,4,5);
    foreach($datearray as $dattesarr) {
    $makeup_classes = $conn->query("SELECT * FROM makeup_classes WHERE courseid='".$fetchstu['courseid']."' AND studentid='".$fetchstu['user']."' AND makeupday='".$dattesarr."'");  
    if($makeup_classes->num_rows > 0) {
        $fetchmakeup = $makeup_classes->fetch_assoc();
    $attandance = $conn->query("SELECT * FROM tbl_attendance WHERE courseid='".$fetchstu['courseid']."' AND tbl_student_id='".$fetchstu['user']."' AND type='makeup' AND isVerified='1' AND submitdate='".$fetchmakeup['date']."' AND isDeleted='0'");
    if($attandance->num_rows > 0) { 
        $makeupatt = 'Yes'; $makeupdate = date('d/m/Y', strtotime($fetchmakeup['date']));
    } else {
        $makeupatt = '';$makeupdate='';
    }  } else {
	    $makeupatt = '';$makeupdate='';
	} ?>
	<!--<td><?php echo $makeupatt; ?></td> -->
	<td><?php echo $makeupdate; ?></td> 
	<?php } ?>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
</tr>
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