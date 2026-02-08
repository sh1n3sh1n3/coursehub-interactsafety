<?php session_start();
include("includes/conn.php");?>
<?php $err='';
	if(isset($_POST['login'])) {
	$username = $_POST['username'];
	$password = md5($_POST['password']);
	$select = $conn->query("SELECT * FROM teachers WHERE (mobile='".$username."' OR email='".$username."')");
	if($select->num_rows > 0){
		$fetch = $select->fetch_assoc();
		$teacherstatus = $fetch['status'];
		if($teacherstatus == '1'){
			$teacherpassword = $fetch['password'];
			if($password == $teacherpassword){
				echo '<script>window.location="dashboard.php"</script>';
				$_SESSION['teacher'] = $fetch['id'];
			} else {
				$err = '<p style="color: #ff6666;text-align: center;">Wrong Password !!</p>';
			}
		} else {
			$err = '<p style="color: #ff6666;text-align: center;">Your account is not active !!</p>';
		}
	} else {
		$err = '<p style="color: #ff6666;text-align: center;">Wrong Username !!</p>';
	}
}?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher || Company Name </title>
	<link rel="shortcut icon" type="image/x-icon" href="../assets/images/favicon.ico">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
	<style>
	body{
        position: relative;
        background-color: #000 !important;
    }
    body::before{
        content: ' ';
        display: block;
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        z-index: 0;
        opacity: 0.5;
        background: url(../images/bg/bg3.jpg) no-repeat center center;
        background-size: cover;
    }
	</style>
</head>
<body class="gray-bg">
    <div class="passwordBox animated fadeInDown">
        <div>
		<div><center><img src="../images/logo-white.png" style="width:100%" class="logo-name text-center"/></center></div>
            <div class="text-white text-center mb-5 font-weight-600 brandname" style="">
				<span class="t1">Welcome<sup>&#174;</sup> Teacher</span><br />
			</div>
			<?php echo $err; ?>
                    <form class="m-t" role="form" method="POST">
                        <div class="form-group">
                            <input type="text" name="username" class="form-control" placeholder="Mobile OR Email" required="">
                        </div>
                        <div class="form-group">
                            <input type="password" name="password" class="form-control" placeholder="Password" required="">
                        </div>
                        <button type="submit" name="login" class="btn btn-primary block full-width m-b">Login</button>

                    </form>
                <p class="m-t text-center text-white"> <small>Copyright @ &copy; 2024  Company </small> </p>
        </div>
    </div>
<script src="js/jquery-3.1.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.js"></script>
</body>

</html>
