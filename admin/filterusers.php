<?php include('session.php'); //echo '<pre>'; print_r($_POST); echo '</pre>';
$pids = array();
$query = "SELECT * FROM sale WHERE id <> 0";
if(isset($_POST['fromdate']) && !empty($_POST['fromdate']) && isset($_POST['todate']) && !empty($_POST['todate'])) {
    $query .= " AND date(date) BETWEEN '".$_POST['fromdate']."' AND '".$_POST['todate']."'";
}
if(isset($_POST['course']) && !empty($_POST['course'])) {
    $query .= " AND courseid='".$_POST['course']."'";
}
$query .= " order by id desc";
// echo $query;
$contact = $conn->query($query);
while($salearray = $contact->fetch_assoc()) {
    $arr[] = $salearray; 
}
// echo '<pre>'; print_r($arr); echo '</pre>';
foreach ($arr as $h) {
    $pids[] = $h['user'];
}
$uniquePids = array_unique($pids);
foreach($uniquePids as $userid) {
	$count++;
	$fetch = $conn->query("SELECT * FROM registration WHERE id=".$userid)->fetch_assoc();$id = $fetch['id'];
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