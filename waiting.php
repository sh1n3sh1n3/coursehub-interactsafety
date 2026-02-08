<?php include 'include/conn.php'; ?>
<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>

    <meta name="viewport" content="width=device-width,initial-scale=1.0" />
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <meta name="description" content="Learnpro - Education University School Kindergarten Learning HTML Template" />
    <meta name="keywords" content="education,school,university,educational,learn,learning,teaching,workshop" />
    <meta name="author" content="ThemeMascot" />
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">

    <title>Company Name</title>
    <?php
    include("include/head_script.php");
    ?>
    <style>
        html {
            scroll-behavior: smooth;
        }
    </style>
</head>
<body class>
    <div id="wrapper" class="clearfix">

        <div class="main-content">

            <section class="inner-header divider layer-overlay overlay-theme-colored-7" data-bg-img="images/bg/bg1.jpg">
                <div class="container pt-20 pb-20" id="book">

                    <div class="section-content">
                        <div class="row">

                            <div class="col-md-12">
                                <h2 class="text-theme-colored2 font-36">Company Name Safety and Training: Waitlist</h2>
                                <ol class="breadcrumb text-left mt-10 white">
                                    <li><a href="index.php">Home</a></li>
                                    <li class="active">Waitlist</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="divider">
                <div class="container pt-50 pb-70">
                    <div class="row pt-10">

                        <div class="col-md-12">
                            <h4 class="mt-0 mb-30 line-bottom-theme-colored-2">ENTER YOUR DETAILS BELOW:?</h4>
                            <?php 
							$err = $msg = '';
							if(isset($_POST['submit'])) {
							    $name = mysqli_real_escape_string($conn, $_POST['name']);
								$email = mysqli_real_escape_string($conn, $_POST['email']);
								$phone = mysqli_real_escape_string($conn, $_POST['phone']);
								$positions_need = mysqli_real_escape_string($conn, $_POST['positions_need']);
								$comments = mysqli_real_escape_string($conn, $_POST['comments']);
								$courseid = $_GET['courseid'];
								$locid = $_GET['locid'];
								$slotid = $_GET['slotid'];
								$cityid = $_GET['cityid'];
								$sql="INSERT INTO waiting_list (courseid, slotid, locid, cityid, name, email, phone, positions_need, comments) VALUES('".$courseid."', '".$slotid."', '".$locid."', '".$cityid."', '".$name."', '".$email."', '".$phone."', '".$positions_need."', '".$comments."')";
    							$insert = $conn->query($sql);
    							$last_id = mysqli_insert_id($conn);
    							if($insert){
    								$msg = 'Data Added Successfully.';
    							} else {
    								$err = $conn->error;
    							}
    						}
    						if(!empty($err)){
    						  echo "
    							<div class='alert alert-danger alert-dismissible'>
    							  <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
    							  <h4><i class='fa fa-warning'></i> Error!</h4>
    							  ".$err."
    							</div>
    						  ";
    						}
    						if(!empty($msg)){
    						    echo "
    							<div class='alert alert-success alert-dismissible'>
    							  <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
    							  <h4><i class='fa fa-check'></i> Success!</h4>
    							  ".$msg."
    							</div>
    						  ";
    						}
							$coursesdata = $conn->query("SELECT * FROM courses WHERE id=".$_GET['courseid'])->fetch_assoc();
							$course_slotsdata = $conn->query("SELECT * FROM course_slots WHERE id=".$_GET['slotid'])->fetch_assoc();
                            $fetchdates = $conn->query("SELECT * FROM course_dates WHERE slot_id='".$course_slotsdata['id']."' ORDER BY date ASC LIMIT 1")->fetch_assoc();
							$locationsdata = $conn->query("SELECT * FROM locations WHERE id=".$_GET['locid'])->fetch_assoc();
							$citiesdata = $conn->query("SELECT * FROM cities WHERE id=".$_GET['cityid'])->fetch_assoc();
							?>
                             <form method="post" enctype="multipart/form-data">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <p>
                                        <a href="https://emojipedia.org/warning/" target="_blank">⚠️</a>&nbsp;
                                        <b>Please note:</b> this course is currently <b>SOLD OUT&nbsp;</b>
                                        <a href="https://emojipedia.org/warning/" target="_blank">⚠️</a><br>
                                        Leave us your details below and you will be notified as soon as a course position become available.
                                    </p>
                                </div>
                                <div class="panel-body">
                                <div class="form-group row">
                                    <label class="control-label col-sm-3" for="name"><span class="mandatory">*</span>Course:</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" readonly value="<?php echo $coursesdata['title'];?>" style="border: none;background: transparent;">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label col-sm-3" for="name"><span class="mandatory">*</span>Location:</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" readonly value="<?php echo $citiesdata['name'].' - '.$locationsdata['location'].' ('.$locationsdata['title'].')'; ?>" style="border: none;background: transparent;">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label col-sm-3" for="name"><span class="mandatory">*</span>Start DateTime:</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" readonly value="<?php echo date('M d, Y', strtotime($fetchdates['date'])); ?> (<?php echo date('H:i:s', strtotime($fetchdates['starttime'])); ?>)" style="border: none;background: transparent;">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label col-sm-3" for="name"><span class="mandatory">*</span>Full Name:</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="name" id="name" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label col-sm-3" for="email"><span class="mandatory">*</span>Email:</label>
                                    <div class="col-sm-9">
                                        <input type="email" class="form-control" name="email" id="email" required oninput="checkuniq(this.value, 'email')">
                                        <p id="emailerr" style="display:none; color:#e83e8c"></p>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label col-sm-3" for="phone"><span class="mandatory">*</span>Phone:</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="phone" name="phone" required oninput="checkuniq(this.value, 'mobile')">
                                        <p id="mobileerr" style="display:none; color:#e83e8c"></p>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label col-sm-3" for="positions_need"><span class="mandatory">*</span>No. Course Positions Needed:</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="positions_need" id="positions_need" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label col-sm-3" for="comments">Any Additional Comments:</label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control" id="comments" name="comments"></textarea>
                                    </div>
                                </div>
                                <button class="btn btn-primary btn-sm" type="submit" name="submit">Submit</button>
                             </form>
                        </div>
                    </div>
                    
                </div>
            </section>
        </div>
    </div>
    <?php include("include/footer_script.php"); ?>
    <script>
        function checkuniq(val, type) {
            if(type=='email') {
        		var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        		if(regex.test(val) == true) {
        			$("#emailerr").text('');
        		    $("#emailerr").css('display', 'none');
        		} else {
        		    $("#emailerr").css('display', 'block');
        			$("#emailerr").text('Not a valid email address!!'); return false;
        		}
        	} 
        	if(type=='mobile') {
        		var filter = /^\d*(?:\.\d{1,2})?$/;
                  if (filter.test(val)) {
                    if(val.length==10){
        				$("#mobileerr").text('');
        		        $("#mobileerr").css('display', 'none');
        			} else {
        		        $("#mobileerr").css('display', 'block');
                        $("#mobileerr").text('Please put 10  digit phone number');return false;
        			}
        		  } else {
        		        $("#mobileerr").css('display', 'block');
                      $("#mobileerr").text('Not a valid number');return false;
        		  }
        	} 
        }
    </script>
</body>
</html>