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
                            <strong>Edit Questions</strong>
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
                            <h5>Edit Questions</h5>
                        </div>
						<?php 
							$err = $msg = '';
							if(isset($_POST['submit'])) {	
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
								$atext = $_POST['answer'];
								$qoption = $option1.'<br />'.$option2.'<br />'.$option3.'<br />'.$option4;
								$query = mysqli_query($con,"UPDATE mques SET qques = '".$qques."', qoption = '".$qoption."' , atext = '".$atext."' WHERE id=".$_POST['id']);
								if($query){
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
							$questions = $conn->query("SELECT * FROM mques WHERE id=".$_GET['id'])->fetch_assoc();
						?>
						
                        <div class="ibox-content">
                            <form method="post" enctype="multipart/form-data">
								<input type="hidden" class="form-control" required name="id" value="<?php echo $questions['id']?>">
                                <div class="form-group  row"><label class="col-sm-2 col-form-label">Question</label>
                                    <div class="col-sm-10"><textarea class="form-control" required name="question"><?php echo $questions['qques']?></textarea></div>
                                </div> 
								<?php 
									$qoptions1 = $questions['qoption']; 
									$qoptions = explode('<br />', $qoptions1);
									$count = 0;
									foreach($qoptions as $qoption){
										$count++;
								?>
                                <div class="hr-line-dashed"></div>           
                                <div class="form-group  row"><label class="col-sm-2 col-form-label">Option <?php echo $count; ?></label>
                                    <div class="col-sm-10"><input type="text" class="form-control" required name="option<?php echo $count; ?>" value="<?=str_replace("<br />", "\r\n", $qoption)?>"></div>
                                </div>
									<?php } ?>
                                <div class="hr-line-dashed"></div>    
								<div class="form-group  row">
									<label class="col-sm-2 col-form-label">Select Right Answer</label>
									<div class="col-sm-10">
										<select class="form-control" required name="answer">
											<option value="">Select</option>
											<option value="1" <?php if($questions['atext'] == '1') {echo 'selected';}?>>1</option>
											<option value="2" <?php if($questions['atext'] == '2') {echo 'selected';}?>>2</option>
											<option value="3" <?php if($questions['atext'] == '3') {echo 'selected';}?>>3</option>
											<option value="4" <?php if($questions['atext'] == '4') {echo 'selected';}?>>4</option>
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