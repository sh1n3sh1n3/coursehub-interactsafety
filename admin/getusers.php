<?php include('session.php');
$contact = $conn->query("SELECT * FROM registration WHERE status='1' order by id desc");
while ($fetch = $contact->fetch_assoc()) {
	$count++;
	$id = $fetch['id'];
	$sale = $conn->query("SELECT * FROM sale WHERE user=" . $id)->num_rows;
	$order = $conn->query("SELECT * FROM sale WHERE user='" . $id . "' ORDER BY id DESC")->fetch_assoc();
	$sqlcourses = $conn->query("SELECT * FROM courses WHERE id='" . $order['courseid'] . "'")->fetch_assoc();
	if ($order['generateCertificate'] == '1') {
		$gencert = 'Yes';
	} else {
		$gencert = 'No';
	}
	$msg = "'Are you sure?'";
	$deleteMsg = "'Are you sure you want to delete this student?'";
?>
	<tr>
		<td><?php echo $count; ?>. </td>
		<td><?php echo strtoupper($fetch['generated_code']); ?></td>
		<td><?php echo $fetch['title'] . ' ' . $fetch['fname'] . ' ' . $fetch['lname']; ?></td>
		<td><?php echo $fetch['email']; ?></td>
		<td><?php echo $fetch['position']; ?></td>
		<td><?php echo $fetch['company']; ?></td>
		<td><?php echo $sqlcourses['title']; ?></td>
		<td><?php echo $gencert; ?></td>
		<td><?php if ($fetch['status'] == '1') {
				echo '<span class="label label-primary" style="padding: 5px 10px;">Active</span>';
			} else {
				echo '<span class="label label-default" style="padding: 5px 10px;">Inactive</span>';
			} ?></td>
		<td>
			<a title="Click to view user details" href="user-details.php?id=<?php echo $fetch['id']; ?>" class="btn btn-info btn-sm" style="height: 30px;">View Details</a>
			<?php if ($fetch['status'] == '1') {
				echo '<a onclick="return confirm(' . $msg . ');" href="deleteUser.php?id=' . $id . '" class="btn btn-white btn-sm" style="height: 30px;"><i class="fa fa-cross"></i> Deactivate </a>';
			} else {
				echo '<a onclick="return confirm(' . $msg . ');" href="deleteUser.php?id=' . $id . '" class="btn btn-white btn-sm" style="height: 30px;"><i class="fa fa-check"></i> Activate </a>';
			} ?>
			<a onclick="return confirm(<?php echo $deleteMsg; ?>);" href="deleteUserPermanent.php?id=<?php echo $id; ?>" class="btn btn-danger btn-sm" style="height: 30px;"><i class="fa fa-trash"></i> Delete</a>
		</td>
	</tr>
<?php } ?>