<?php include('session.php'); ?>
<!DOCTYPE html>
<html>
<head>
<?php include('includes/head.php'); ?>
</head>

<body>

    <div id="wrapper">
    <?php include('includes/sidebar.php'); ?>
        <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
        <?php include('includes/header.php'); ?>
        </div>
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Questions </h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="index.php">Home</a>
                        </li>
                        <li class="breadcrumb-item">
							<a href="#">Questions</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>Add Questions</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox ">
                        <div class="ibox-title">
                            <h5>Add Questions</h5>
                        </div>
						<?php 
							$err = $msg = '';
							if(isset($_POST['submit'])) {						
								$vid = $qimage = $qaudio = ''; $description = ''; $ques_type = '';	
								$testid = $_POST['testid'];
								$qques = $_POST['question'];
								$qques = str_replace(PHP_EOL,"<br>",$qques); 	
								$qques = stripslashes($qques);
								$qques = mysqli_real_escape_string($con,$qques);											
								$option1 = $_POST['option1'];	
								$option1 = stripslashes($option1);
								$option1 = mysqli_real_escape_string($con,$option1);								
								$option2 = $_POST['option2'];	
								$option2 = stripslashes($option2);
								$option2 = mysqli_real_escape_string($con,$option2);								
								$option3 = $_POST['option3'];	
								$option3 = stripslashes($option3);
								$option3 = mysqli_real_escape_string($con,$option3);								
								$option4 = $_POST['option4'];	
								$option4 = stripslashes($option4);
								$option4 = mysqli_real_escape_string($con,$option4);
								$chapter = $_POST['chapter'];								
								$atext = $_POST['answer'];
								$qoption = $option1.'<br />'.$option2.'<br />'.$option3.'<br />'.$option4;
								
								$query1 = mysqli_query($conn,"select * from mques where testid='$testid' and qques='$qques' and qoption='$qoption' and atext='$atext'");
								if(mysqli_num_rows($query1)>0){
									echo 'Record already exist!';
								} else {
									$query = mysqli_query($con,"insert into mques(testid,qques,ques_type,sub_ans,qoption,atext,datetime,qimage,qaudio,qvideo, description, chapter_id) values('$testid','$qques','','','$qoption','$atext','".date('Y-m-d H:i:s')."','$qimage','','$vid','$description', '$chapter')");
									if($query){
										$msg = 'Data Added Successfully.';
									} else {
										$err = $conn->error;
									}
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
							$test = $conn->query("SELECT * FROM mocktest WHERE id=".$_GET['id'])->fetch_assoc();
						?>
						
                        <div class="ibox-content">
                            <form method="post" enctype="multipart/form-data">
								<input type="hidden" class="form-control" required name="testid" value="<?php echo $_GET['id']?>">
								<div class="form-group  row">
									<label class="col-sm-2 col-form-label">Select Chapter</label>
									<div class="col-sm-10">
										<select class="form-control" required name="chapter">
											<option value="">Select</option>
											<?php $count=0;
											$contact = $conn->query("SELECT * FROM chapters WHERE status='1' AND course='".$test['subject_id']."' order by name ASC");
											while($fetch = $contact->fetch_assoc()) {$count++; ?>
											<option value="<?php echo $fetch['id']; ?>"><?php echo $fetch['title']; ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
                                <div class="hr-line-dashed"></div>    
                                <div class="form-group  row"><label class="col-sm-2 col-form-label">Question</label>
                                    <div class="col-sm-10"><textarea class="form-control" required name="question"></textarea></div>
                                </div> 
                                <div class="hr-line-dashed"></div>           
                                <div class="form-group  row"><label class="col-sm-2 col-form-label">Option 1</label>
                                    <div class="col-sm-10"><input type="text" class="form-control" required name="option1" value=""></div>
                                </div>
                                <div class="hr-line-dashed"></div> 
                                <div class="form-group  row"><label class="col-sm-2 col-form-label">Option 2</label>
                                    <div class="col-sm-10"><input type="text" class="form-control" required name="option2" value=""></div>
                                </div> 
                                <div class="hr-line-dashed"></div> 
                                <div class="form-group  row"><label class="col-sm-2 col-form-label">Option 3</label>
                                    <div class="col-sm-10"><input type="text" class="form-control" required name="option3" value=""></div>
                                </div> 
                                <div class="hr-line-dashed"></div> 
                                <div class="form-group  row"><label class="col-sm-2 col-form-label">Option 4</label>
                                    <div class="col-sm-10"><input type="text" class="form-control" required name="option4" value=""></div>
                                </div> 
                                <div class="hr-line-dashed"></div>    
								<div class="form-group  row">
									<label class="col-sm-2 col-form-label">Select Right Answer</label>
									<div class="col-sm-10">
										<select class="form-control" required name="answer">
											<option value="">Select</option>
											<option value="1">1</option>
											<option value="2">2</option>
											<option value="3">3</option>
											<option value="4">4</option>
										</select>
									</div>
								</div>
                                <div class="hr-line-dashed"></div>  
                                <div class="form-group row">
                                    <div class="col-sm-4 col-sm-offset-2">
                                        <button class="btn btn-primary btn-sm" type="submit" name="submit">Save changes</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include('includes/footer.php'); ?>

        </div>
        </div>
<?php include('includes/foot.php'); ?>
</body>
</html>