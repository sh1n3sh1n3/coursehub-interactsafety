<?php include('session.php'); 
$id = (int) $_POST['id'];
$slot=$_POST['slot'];
$conn->query("UPDATE course_teachers SET is_deleted='1' WHERE id=".$id);
?>
<?php $teachers_query = "SELECT * FROM course_teachers WHERE slot_id='".$slot."' AND status='1' AND is_deleted='0'";
$course_teachers = $conn->query($teachers_query);
while($fetchteachers = $course_teachers->fetch_assoc()) {
    $Efetchteachers = $conn->query("SELECT * FROM teachers WHERE id='".$fetchteachers['teacherid']."'")->fetch_assoc();
    if($fetchteachers['accepted'] == '1') {
        $statusrequest = 'Accepted';
    } else if($fetchteachers['accepted'] == '2') {
        $statusrequest = 'Decline';
    } else {
        $statusrequest = 'Pending';
    }
    ?>
<tr id="Teacherdiv_<?php echo $fetchteachers['id']; ?>">
    <td><?php echo $Efetchteachers['title']; ?></td>
    <td><?php echo $statusrequest; ?></td>
    <td><?php echo date('d/M/Y h:i A', strtotime($fetchteachers['updated'])); ?></td>
    <td><a href="javascript:" class="btn btn-danger" onclick="deleteTeacher(<?php echo $fetchteachers['id']; ?>)">Delete</a></td>
</tr>
<?php } 
$conn->close();
exit; ?>