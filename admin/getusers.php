<?php include('session.php'); 
$contact = $conn->query("SELECT * FROM registration order by id desc");
while($fetch = $contact->fetch_assoc()) {
	$count++;$id = $fetch['id'];
	$sale = $conn->query("SELECT * FROM sale WHERE user=".$id)->num_rows;
	$order = $conn->query("SELECT * FROM sale WHERE user='".$id."' ORDER BY id DESC")->fetch_assoc();
	$sqlcourses = $conn->query("SELECT * FROM courses WHERE id='".$order['courseid']."'")->fetch_assoc();
	if($order['generateCertificate'] == '1') {
	    $gencert = 'Yes';
	} else {
	    $gencert = 'No';
	}
	?>
<tr>
	<td><?php echo $count; ?>. </td>
	<td><?php if($fetch['status']=='1') {echo '<a href="deleteUser.php?id='.$id.'" class="btn btn-white btn-sm"><i class="fa fa-cross"></i> Deactivate </a>';}else {echo '<a href="deleteUser.php?id='.$id.'" class="btn btn-white btn-sm"><i class="fa fa-check"></i> Activate </a>';} ?></td>
	<td><a title="Click to view orders" href="orders.php?id=<?php echo $fetch['id']; ?>" class="btn btn-info btn-sm"> View <?php echo $sale; ?> order </a></td>
	<td><?php if($fetch['status']=='1') {echo '<span class="label label-primary">Active</span>';}else {echo '<span class="label label-default">Not Active</span>';} ?></td>
	<td><?php echo strtoupper($fetch['generated_code']); ?></td>
	<td><?php echo $fetch['title'].' '.$fetch['fname'].' '.$fetch['lname']; ?></td>
	<td><?php echo $fetch['email']; ?></td>
	<td><?php echo $fetch['position']; ?></td>
	<td><?php echo $fetch['company']; ?></td>
	<td><?php echo $sqlcourses['title']; ?></td>
	<td><?php echo $gencert; ?></td>
</tr>
<?php } ?>