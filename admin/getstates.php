<?php include('session.php'); ?>
<option value="">Select</option>
<?php 
if($_POST['type'] == 'state') {
$statesfetch = $conn->query("SELECT * FROM states WHERE status='1' AND country_id='".$_POST['country']."' order by name ASC");
while($fetchstates = $statesfetch->fetch_assoc()) { ?>
<option value="<?php echo $fetchstates['id']; ?>"><?php echo $fetchstates['name']; ?></option>
<?php } } else if($_POST['type'] == 'city') { 
$statesfetch = $conn->query("SELECT * FROM cities WHERE status='1' AND state_id='".$_POST['country']."' order by name ASC");
while($fetchstates = $statesfetch->fetch_assoc()) { ?>
<option value="<?php echo $fetchstates['id']; ?>"><?php echo $fetchstates['name']; ?></option>
<?php }} ?>