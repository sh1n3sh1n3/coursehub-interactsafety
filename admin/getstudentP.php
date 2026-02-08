<?php include('session.php');
$fetch = $conn->query("SELECT * FROM registration WHERE id='".$_POST['student']."'")->fetch_assoc();
$fetchsale = $conn->query("SELECT * FROM sale WHERE user='".$fetch['id']."'")->fetch_assoc();
$fetchcourse = $conn->query("SELECT * FROM courses WHERE id='".$fetchsale['courseid']."'")->fetch_assoc(); 
$fetchslot = $conn->query("SELECT * FROM course_slots WHERE id='".$fetchsale['slotid']."'")->fetch_assoc();
$course_dates = $conn->query("SELECT * FROM course_dates WHERE slot_id='".$fetchslot['id']."' ORDER by date ASC LIMIT 1")->fetch_assoc();
$fetchindus = $conn->query("SELECT * FROM industry_type WHERE id='".$fetchsale['industry_type']."'")->fetch_assoc();
if($fetchsale['generateCertificate'] == '1') {
    $gendate = date('d/m/Y', strtotime($fetchsale['generateCertificatedate']));
} else {
    $gendate = '-';
}
if($fetch['hsr_or_not'] == '1') {
    $hsr_or_not = 'HSR';
} else if($fetch['hsr_or_not'] == '2') {
    $hsr_or_not = 'DHSR';
} else if($fetch['hsr_or_not'] == '3') {
    $hsr_or_not = 'Man or Sup';
} else if($fetch['hsr_or_not'] == '4') {
    $hsr_or_not = 'Comm member';
} else if($fetch['hsr_or_not'] == '5') {
    $hsr_or_not = 'Other';
}
$attan = strtoupper(substr($fetch['fname'], 0, 1).''.substr($fetch['lname'], 0, 1));
?>
<table class="table table-striped table-bordered table-hover dataTables-example1" >
<thead>
<tr>
	<th style="vertical-align:middle; text-align:center;">&nbsp;</th>
	<th style="vertical-align:middle; text-align:center;">&nbsp;</th>
	<th style="vertical-align:middle; text-align:center;">&nbsp;</th>
	<th style="vertical-align:middle; text-align:center;">Student Name & Contact Details</th>
	<th style="vertical-align:middle; text-align:center;">&nbsp;</th>
	<th style="vertical-align:middle; text-align:center;">&nbsp;</th>
	<th style="vertical-align:middle; text-align:center;">&nbsp;</th>
	<th style="vertical-align:middle; text-align:center;">&nbsp;</th>
	<th style="vertical-align:middle; text-align:center;">Emergency Contact Deatils</th>
	<th style="vertical-align:middle; text-align:center;">&nbsp;</th>
	<th style="vertical-align:middle; text-align:center;">Special Needs </th>
</tr>
<tr>
	<th style="vertical-align:middle; text-align:center;">Student Number</th>
	<th style="vertical-align:middle; text-align:center;">Name</th>
	<th style="vertical-align:middle; text-align:center;">Surname </th>
	<th style="vertical-align:middle; text-align:center;">Email </th>
	<th style="vertical-align:middle; text-align:center;">Position </th>
	<th style="vertical-align:middle; text-align:center;">Company </th>
	<th style="vertical-align:middle; text-align:center;">Postal Address </th>
	<th style="vertical-align:middle; text-align:center;">Emergency Contact </th>
	<th style="vertical-align:middle; text-align:center;">Emergency Contact Number </th>
	<th style="vertical-align:middle; text-align:center;">Dietry Requirements</th>
	<th style="vertical-align:middle; text-align:center;">Specify Adjustments</th>
</tr>
</thead>
<tbody id="tablebody">
<tr>
	<td style="vertical-align:middle; text-align:center;"><?php echo strtoupper($fetch['generated_code']); ?></td>
	<td style="vertical-align:middle; text-align:center;"><?php echo $fetch['title'].' '.ucfirst($fetch['fname']); ?></td>
	<td style="vertical-align:middle; text-align:center;"><?php echo ucfirst($fetch['lname']); ?></td>
	<td style="vertical-align:middle; text-align:center;"><?php echo $fetch['email']; ?></td>
	<td style="vertical-align:middle; text-align:center;"><?php echo $fetch['position']; ?></td>
	<td style="vertical-align:middle; text-align:center;"><?php echo $fetch['company']; ?></td>
	<td style="vertical-align:middle; text-align:center;"><?php echo $fetch['postal_address']; ?></td>
	<td style="vertical-align:middle; text-align:center;"><?php echo $fetch['emergency_contact']; ?></td>
	<td style="vertical-align:middle; text-align:center;"><?php echo $fetch['emergency_phone']; ?></td>
	<td style="vertical-align:middle; text-align:center;"><?php echo $fetch['food_requirements']; ?></td>
	<td style="vertical-align:middle; text-align:center;"><?php echo $fetch['special_requirements']; ?></td>
</tr>
<tr>
	<th style="vertical-align:middle; text-align:center;">&nbsp;</th>
	<th style="vertical-align:middle; text-align:center;">&nbsp;</th>
	<th style="vertical-align:middle; text-align:center;">Course Verification  of attandance</th>
	<th style="vertical-align:middle; text-align:center;">&nbsp;</th>
	<th style="vertical-align:middle; text-align:center;">&nbsp;</th>
	<th style="vertical-align:middle; text-align:center;">&nbsp;</th>
	<th style="vertical-align:middle; text-align:center;">ATAR Information</th>
	<th style="vertical-align:middle; text-align:center;">&nbsp;</th>
	<th style="vertical-align:middle; text-align:center;">FEEDBACK </th>
	<th style="vertical-align:middle; text-align:center;">&nbsp;</th>
	<th style="vertical-align:middle; text-align:center;">Trainer Feedback </th>
</tr>
<tr>
	<th style="vertical-align:middle; text-align:center;">Course Attendant</th>
	<th style="vertical-align:middle; text-align:center;">Student ID</th>
	<th style="vertical-align:middle; text-align:center;">Date of Registration </th>
	<th style="vertical-align:middle; text-align:center;">6 month cut off date </th>
	<th style="vertical-align:middle; text-align:center;">Certificate issue Date </th>
	<th style="vertical-align:middle; text-align:center;">HSR / DHSR / Man or Sup / Comm member / Other </th>
	<th style="vertical-align:middle; text-align:center;">Industry </th>
	<th style="vertical-align:middle; text-align:center;">Course Feedback </th>
	<th style="vertical-align:middle; text-align:center;">Issues Raised </th>
	<th style="vertical-align:middle; text-align:center;">Include comments regarding absenses and communications </th>
	<th style="vertical-align:middle; text-align:center;">&nbsp;</th>
</tr>
<tr>
	<td style="vertical-align:middle; text-align:center;"><?php echo $fetchcourse['title']; ?></td>
	<td style="vertical-align:middle; text-align:center;"><?php echo date('ymd', strtotime($course_dates['date'])).'.'.sprintf('%02d', $fetchslot['id']).'.'.$attan; ?></td>
	<td style="vertical-align:middle; text-align:center;"><?php echo date('d/m/Y', strtotime($fetchsale['date'])); ?></td>
	<td style="vertical-align:middle; text-align:center;"><?php echo date("d/m/Y", strtotime("+6 months", strtotime($fetchsale['date']))); ?></td>
	<td style="vertical-align:middle; text-align:center;"><?php echo $gendate; ?></td>
	<td style="vertical-align:middle; text-align:center;"><?php echo $hsr_or_not; ?></td>
	<td style="vertical-align:middle; text-align:center;"><?php echo $fetchindus['title']; ?></td>
	<td style="vertical-align:middle; text-align:center;"></td>
	<td style="vertical-align:middle; text-align:center;"></td>
	<td style="vertical-align:middle; text-align:center;"></td>
	<td style="vertical-align:middle; text-align:center;"></td>
</tr>
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
                    filename: 'Student Profile of <?php echo $fetch['title'].' '.ucfirst($fetch['fname']); ?>',
				},
			]

		});

	});
</script>