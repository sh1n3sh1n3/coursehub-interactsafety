<?php @session_start(); include 'include/conn.php'; 
$reservation_username = mysqli_real_escape_string($conn, $_POST['reservation_username']);
$reservation_password = mysqli_real_escape_string($conn, $_POST['reservation_password']);
$select = $conn->query("SELECT * FROM registration WHERE email LIKE '".$reservation_username."' AND verifyEmail = '1'");
if($select->num_rows > 0) {
    $fetch = $select->fetch_assoc();
    if($fetch['status'] == '1') {
        if($fetch['password'] == $reservation_password) {
            $_SESSION['pin_user'] = $fetch['id'];
            echo 'success';
        } else {
            echo 'Wrong password entered!! Please try again.';
        }
    } else {
        echo 'Account not active!!';
    }
} else {
    echo 'Please check your credentials. No record found!!';
}
?>