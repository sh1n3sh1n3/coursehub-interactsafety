<?php @session_start(); include 'include/conn.php'; 
function genRandomString() {
    $length = 5;
    $characters = '023456789abcdefghijkmnopqrstuvwxyz';
    $string = '';    

    for ($p = 0; $p < $length; $p++) {
        $string .= $characters[mt_rand(0, strlen($characters))];
    }
    return $string;
}
$account_fname = mysqli_real_escape_string($conn, $_POST['account_fname']);
$account_lname = mysqli_real_escape_string($conn, $_POST['account_lname']);
$account_username = mysqli_real_escape_string($conn, $_POST['account_username']);
$account_password = mysqli_real_escape_string($conn, $_POST['account_password']);
$generated_code = genRandomString();
$check_random_string_row = $conn->query('SELECT generated_code FROM registration WHERE (generated_code="'.$generated_code.'")')->fetch_assoc();
if($generated_code == $check_random_string_row['generated_code']){
    $generated_code = genRandomString();
}
$select = $conn->query("SELECT * FROM registration WHERE email LIKE '".$account_username."' AND verifyEmail = '1'");
if($select->num_rows > 0) {
    echo 'Email address already exist!! Please login to continue.';
} else {
    $selectff = $conn->query("SELECT * FROM registration WHERE email LIKE '".$account_username."'");
    if($selectff->num_rows > 0) {
        $sqlup="UPDATE registration SET fname = '".$account_fname."',lname='".$account_lname."',password='".$account_password."',generated_code='".$generated_code."' WHERE email='".$account_username."'";
		$update = $conn->query($sqlup);
		if($update) {
            echo 'success';
		} else {
		    echo 'Something wrong!!';
		}
    } else {
        $sql="INSERT INTO registration (fname,lname,email,password,generated_code) VALUES ('".$account_fname."','".$account_lname."','".$account_username."','".$account_password."','".$generated_code."')";
		$insert = $conn->query($sql);
		if($insert) {
            echo 'success';
		} else {
		    echo 'Something wrong!!';
		}
    }
}
?>