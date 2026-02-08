<option value="">Select</option>
<?php include('includes/conn.php'); 
$contact = $conn->query("SELECT DISTINCT teacherid FROM course_teachers WHERE course_id='".$_POST['val']."' AND accepted='1'");
while($fetch = $contact->fetch_assoc()) {
	$sale = $conn->query("SELECT * FROM teachers WHERE id=".$fetch['teacherid'])->fetch_assoc();
?>
<option value="<?php echo $sale['id']; ?>"><?php echo $sale['title']; ?></option>
<?php } ?>