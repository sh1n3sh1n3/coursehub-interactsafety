<?php include('session.php'); ?>
<table class="table table-striped table-bordered table-hover dataTables-example1" >
<thead>
<tr>
	<th style="vertical-align:middle; text-align:center;">Student ID</th>
	<th style="vertical-align:middle; text-align:center;">Name</th>
	<th style="vertical-align:middle; text-align:center;">Surname</th>
	<th style="vertical-align:middle; text-align:center;">Email</th>
	<th style="vertical-align:middle; text-align:center;">Workplace Email</th>
	<th style="vertical-align:middle; text-align:center;">Missed Days</th>
	<th style="vertical-align:middle; text-align:center;">Action</th>
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
	$attan = strtoupper(substr($userdata['fname'], 0, 1).''.substr($userdata['lname'], 0, 1));
	$course_datesd = $conn->query("SELECT * FROM course_dates WHERE slot_id='".$fetchstu['slotid']."' AND date <= '".date('Y-m-d')."'");
	$ccn = 0; $abs = 0; $missed = '';
    while($dattessd = $course_datesd->fetch_assoc()) {
        if($dattessd['date'] == date('Y-m-d')) {
            if($dattessd['starttime'] <= date('H:i:s')) {
            $attandance = $conn->query("SELECT * FROM tbl_attendance WHERE courseid='".$fetchstu['courseid']."' AND slotid='".$fetchstu['slotid']."' AND tbl_student_id='".$fetchstu['user']."' AND submitdate='".$dattessd['date']."' AND isDeleted='0'");
            if($attandance->num_rows > 0) { $ccn++; } else { $ccn++; $abs++; $missed.='Day '.$ccn.' on '.date("d-M-Y",strtotime($dattessd['date'])).'<hr style="margin-top: 0.2rem;margin-bottom: 0.2rem;">'; }} 
        } else {
            $attandance = $conn->query("SELECT * FROM tbl_attendance WHERE courseid='".$fetchstu['courseid']."' AND slotid='".$fetchstu['slotid']."' AND tbl_student_id='".$fetchstu['user']."' AND submitdate='".$dattessd['date']."' AND isDeleted='0'");
            if($attandance->num_rows > 0) { $ccn++; } else { $ccn++; $abs++; $missed.='Day '.$ccn.' on '.date("d-M-Y",strtotime($dattessd['date'])).'<hr style="margin-top: 0.2rem;margin-bottom: 0.2rem;">'; } 
        }
    }
    $missed = rtrim($missed,'<hr style="margin-top: 0.2rem;margin-bottom: 0.2rem;">');
    if($abs > 0) {
    ?>
<tr>
	<td><?php echo date('ymd', strtotime($coursefirstdate['date'])).'.'.sprintf('%02d', $slotdata['id']).'.'.$attan; ?> </td>
	<td><?php echo ucfirst($fetchstu['fname']); ?></td>
	<td><?php echo ucfirst($fetchstu['lname']); ?></td>
	<td><?php echo $fetchstu['email']; ?></td>
	<td><?php echo $fetchstu['workplace_email']; ?></td>
	<td><?php echo $missed; ?></td>
	<td><a class="btn btn-primary submitbtnntest" id="myloader<?php echo $fetchstu['id']; ?>" href="javascript:" onclick="sendEmail(<?php echo $fetchstu['id']; ?>)">Sent Email</a></td>
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
                    filename: 'Student Complete Register',
				},
			]

		});

	});
	function sendEmail(id) {
        $.ajax({
          type: 'POST',
          url: "sendEmail.php",
          data: {id:id},
            beforeSend: function(){
            $("#myloader"+id).css("border-color","#FFF");
            $("#myloader"+id).css("background","url(../images/preloaders/5.gif) center / 55px 55px no-repeat");
            $(".submitbtnntest").prop("disabled", true);
          },
          success: function(resultData) {  console.log(resultData);
            $("#myloader"+id).css("background","#D9251C");
            $("#myloader"+id).css("border-color","#D9251C");
            $(".submitbtnntest").prop("disabled", false);
            alert("Email Send Successfully!!");
          }
        });
    }
</script>