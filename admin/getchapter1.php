<?php include('session.php');
?>
<option value="">Select</option>
<?php
$contact = $conn->query("SELECT * FROM chapters WHERE status='1' AND course='".$_POST['id']."' order by name ASC");
while($fetch = $contact->fetch_assoc()) {$count++; ?>
<option value="pages.php?id=<?php echo $fetch['id']; ?>"><?php echo $fetch['title']; ?></option>
<?php } ?>