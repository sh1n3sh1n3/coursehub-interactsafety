<?php include('session.php'); ?>
<table class="table table-striped table-bordered table-hover dataTables-example" >
<thead>
<tr>
    <th>Status</th>
    <th>Course</th>
    <th>Course Type</th>
    <th>Location</th>
    <th>Min Capacity</th>
    <th>Max Capacity</th>
    <th>Makeup Class Capacity</th>
    <th>Date & Time</th>
    <th>Teacher (Request Status)</th>
    <th>Action</th>
</tr>
</thead>
<tbody>
<?php $count=0; 

$isPublished = $_POST['isPublished'];
$catid = $_POST['catid'];
$teacherid = $_POST['teacherid'];
$delivery_types = $_POST['delivery_types'];
$dates='';
$query = "SELECT course_slots.id as id,courses.status,courseid,locid,cityid,course_slots.isPublished as published,course_slots.type as course_slots_type,course_slots.teacherid as teacherid,mincapacity,maxcapacity,makecapacity,remarks,createdate,courses.title as coursetitle,location FROM course_slots inner join courses on courseid=courses.id INNER join locations on locid=locations.id WHERE courses.id <> 0 ";
if(!empty($isPublished) && $isPublished != '') {
    if($isPublished == '2') {
        $query .= " AND course_slots.isPublished='0'";
    } else {
        $query .= " AND course_slots.isPublished='".$isPublished."'";
    }
}
if(!empty($catid) && $catid != '') {
    $query .= " AND courses.catid='".$catid."'";
}
if(!empty($delivery_types) && $delivery_types != '') {
    $query .= " AND courses.delivery_types='".$delivery_types."'";
}
if(!empty($teacherid) && $teacherid != '') {
    $query .= " AND course_slots.teacherid='".$teacherid."'";
}
$query .= " order by id, courseid, locid,cityid";
$contact = $conn->query($query);
while($fetch = $contact->fetch_assoc()) {$dates='';$dates=$invitees='';
$count++; 
$fetchcourses = $conn->query("SELECT *,replace(slug,' ','-') as slug FROM courses WHERE id='".$fetch['courseid']."'")->fetch_assoc();
$course_dates = $conn->query("SELECT * FROM course_dates WHERE slot_id='".$fetch['id']."'");
while($fetchdates = $course_dates->fetch_assoc()) {
    $dates .= date('d-M-Y', strtotime($fetchdates['date'])).' ('.date('h:i A', strtotime($fetchdates['starttime'])).' - '.date('h:i A', strtotime($fetchdates['endtime'])).')'.'<hr>';
}$coursecode='';
if($fetch['course_slots_type'] == 'private') {
    $fetchprivate = $conn->query("SELECT * FROM private_course WHERE slot_id=".$fetch['id'])->fetch_assoc();
    $coursecode = ' ('.$fetchprivate['course_code'].')';
}
$course_teachers = $conn->query("SELECT * FROM course_teachers WHERE slot_id='".$fetch['id']."' AND status='1' AND is_deleted='0' ORDER BY id ASC");
    while($fetchteacherss = $course_teachers->fetch_assoc()) {
        $fetchteach = $conn->query("SELECT * FROM teachers WHERE id=".$fetchteacherss['teacherid'])->fetch_assoc();
        if($fetchteacherss['accepted'] == '1') {
            $checkst = '<i class="fa fa-check-circle text-success" title="Accepted"></i>';
        } else if($fetchteacherss['accepted'] == '2') {
            $checkst = '<i class="fa fa-times-circle text-danger" title="Decline"></i>';
        } else {
            $checkst = '<i class="fa fa-minus-circle text-info" title="Pending"></i>';
        }
        $invitees .= $checkst.' '.$fetchteach['title'].'<hr>';
    }
?>
<tr>
	<td><?php if($fetch['status']=='1') {echo '<span class="mb-1 label label-primary">Active</span>';}else {echo '<span class="mb-1 label label-default">Not Active</span>';} ?><br>
	<?php if($fetch['published']=='1') {echo '<span class="mb-1 label label-success">Published</span>';}else {echo '<span class="mb-1 label label-info">Not Published</span>';} ?></td>
    <td><?php echo $fetch['coursetitle'].$coursecode; ?></td>
    <td><?php echo $fetch['course_slots_type']; ?></td>
    <td><?php echo $fetch['location']; ?></td>
    <td><?php echo $fetch['mincapacity']; ?></td>
    <td><?php echo $fetch['maxcapacity']; ?></td>
    <td><?php echo $fetch['makecapacity']; ?></td>
    <td><?php echo $dates; ?></td>
    <td><?php echo $invitees;?></td>
	<td>
		<a href="editCourseSlots.php?id=<?php echo $fetch['id']; ?>" class="mb-1 btn btn-white btn-sm"><i class="fa fa-pencil"></i> Edit </a><br>
		<?php if($fetch['published'] == '1') { ?>
		<a href="publishSlots.php?id=<?php echo $fetch['id']; ?>" class="mb-1 btn btn-danger btn-sm"><i class="fa fa-times-circle-o"></i> Hide </a><br>
		<?php } else { ?>
		<a href="publishSlots.php?id=<?php echo $fetch['id']; ?>" class="mb-1 btn btn-warning btn-sm"><i class="fa fa-bullhorn"></i> Publish </a><br>
		<?php } ?>
		<a target="_blank" href="../courses-preview/<?php echo $fetchcourses['id']; ?>/<?php echo $fetchcourses['slug']; ?>" class="btn btn-info btn-sm"><i class="fa fa-eye"></i> Preview </a>
		<!--<a href="deleteCourseSlots.php?id=<?php echo $fetch['id']; ?>" class="btn btn-white btn-sm"><i class="fa fa-close"></i> Delete </a>-->
	</td>
</tr>
<?php } ?>
</tbody>
</table>
<script src="js/plugins/dataTables/datatables.min.js"></script>
<script src="js/plugins/dataTables/dataTables.bootstrap4.min.js"></script>
<script>
    $(document).ready(function(){
	    $('select.select').select2();
		$('.dataTables-example').DataTable({
			pageLength: 25,
			responsive: true,
			"ordering": false,
			dom: '<"html5buttons"B>lTfgitp',
			buttons: [
				{extend: 'csv'},
			]

		});

	});
</script>