<?php 
include('session.php');
if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
    header("Location: news.php?error=invalid");
    exit;
}
$id = (int) $_GET['id'];
$delete = $conn->query("DELETE FROM news WHERE id=".$id);
if($delete){
	echo '<script>alert("Data Deleted Successfully");window.location="news.php"</script>';
} else {
	echo '<script>alert("Unable to delete data");window.location="news.php"</script>';
}
$conn->close();
exit;
?>