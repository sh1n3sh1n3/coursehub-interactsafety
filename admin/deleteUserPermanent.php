<?php
include('session.php');

if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
    header("Location: users.php?error=invalid");
    exit;
}

$id = (int) $_GET['id'];
$user = $conn->query("SELECT * FROM registration WHERE id=" . $id)->fetch_assoc();

if (!$user) {
    echo '<script>alert("Student not found.");window.location="users.php"</script>';
    exit;
}

$orderCount = $conn->query("SELECT COUNT(*) AS count FROM sale WHERE user=" . $id)->fetch_assoc();
if ($orderCount && (int) $orderCount['count'] > 0) {
    echo '<script>alert("This student has orders, so the record cannot be deleted. Please deactivate instead.");window.location="users.php"</script>';
    exit;
}

$conn->query("DELETE FROM cart WHERE user=" . $id);
$delete = $conn->query("DELETE FROM registration WHERE id=" . $id);

if ($delete) {
    echo '<script>alert("Student deleted successfully.");window.location="users.php"</script>';
} else {
    echo '<script>alert("Unable to delete student.");window.location="users.php"</script>';
}

$conn->close();
exit;
?>
