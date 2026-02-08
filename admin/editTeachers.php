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
                    <h2>Teacher </h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="index.php">Home</a>
                        </li>
                        <li class="breadcrumb-item">
							<a href="teacher.php">Teacher</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>Edit Teacher</strong>
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
                            <h5>Edit Teacher</h5>
                        </div>
						<?php function checkimg($pic){
								if (file_exists("../assets/images/teachers/" . $pic)) {
									return false;
								} else {
									return true;
								}
							}
							$err = $msg = '';
							if(isset($_POST['submit'])) {
								$title = mysqli_real_escape_string($conn, $_POST['title']);
								$slug = mysqli_real_escape_string($conn, $_POST['title']);
								$email = mysqli_real_escape_string($conn, $_POST['email']);
								$mobile = mysqli_real_escape_string($conn, $_POST['mobile']);
								$password = mysqli_real_escape_string($conn, md5($_POST['password']));
								$pass1 = mysqli_real_escape_string($conn, $_POST['password']);
								$qualification = mysqli_real_escape_string($conn, $_POST['qualification']);
								$description = mysqli_real_escape_string($conn, $_POST['description']);
								$id = mysqli_real_escape_string($conn, $_POST['id']);
								$image='';
                    			if(isset($_FILES["image"]['name']) && !empty($_FILES["image"]['name'])){ 
                    				if ($_FILES["image"]['name']!=''){
                    					$validextensions = array("jpeg", "jpg", "png", "JPEG", "JPG", "PNG");
                    					$temporary = explode(".", $_FILES["image"]["name"]);
                    					$file_extension = end($temporary);
                    					 if (in_array($file_extension, $validextensions)) {
                    						 if ($_FILES["image"]["error"] > 0){
                    							echo $_FILES["image"]["error"];
                    							$up=0;
                    						 }else{     
                    							  $picname='IMG_'.date('dmY',time())."_".date('His',time());
                    							  $image= $picname.".". $file_extension;
                    							  $i=0;
                    							  while(checkimg($image)!=true){
                    								  $i++;
                    								  $image=$picname."_(".$i.").".$file_extension;
                    							  } 
                    							  $sourcePath = $_FILES['image']['tmp_name']; // Storing source path of the file in a variable
                    							  $targetPath = "../assets/images/teachers/".$image; // Target path where file is to be stored
                    							  if(move_uploaded_file($sourcePath,$targetPath)){}else{
                    								 echo  'Error while uploading your image try again later!';
                    								 $up=0;
                    							  }
                    						 }  
                    					}else{
                    						 echo 'Only jpg, jpeg and png file allowed!';
                    					}
                    				}
                    			}else{
                    				$image = mysqli_real_escape_string($conn, $_POST['oldimg']);
                    			}
							$insert = $conn->query("UPDATE teachers SET qualification= '".$qualification."',title= '".$title."',email= '".$email."',mobile= '".$mobile."',password= '".$password."',pass1= '".$pass1."',slug= '".$slug."',description= '".$description."', image= '".$image."' , updated='".date('Y-m-d')."' WHERE id=".$id);
							if($insert){
								$msg = 'Data Updated Successfully.';
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
						$testimonial = $conn->query("SELECT * FROM teachers WHERE id=".$_GET['id'])->fetch_assoc();
						?>
						
                        <div class="ibox-content">
                            <form method="post" enctype="multipart/form-data">
							<input type="hidden" name="id" value="<?php echo $testimonial['id']; ?>"/>
								<div class="form-group  row"><label class="col-sm-2 col-form-label">Name</label>
                                    <div class="col-sm-10"><input type="text" class="form-control" required name="title" value="<?php echo $testimonial['title']; ?>"></div>
                                </div>
                                <div class="hr-line-dashed"></div>                       
								<div class="form-group  row"><label class="col-sm-2 col-form-label">Email</label>
                                    <div class="col-sm-10"><input type="text" class="form-control" required name="email" value="<?php echo $testimonial['email']; ?>"></div>
                                </div>
                                <div class="hr-line-dashed"></div>                       
								<div class="form-group  row"><label class="col-sm-2 col-form-label">Mobile</label>
                                    <div class="col-sm-10"><input type="text" class="form-control" required name="mobile" value="<?php echo $testimonial['mobile']; ?>"></div>
                                </div>
                                <div class="hr-line-dashed"></div>                       
								<div class="form-group  row"><label class="col-sm-2 col-form-label">Password</label>
                                    <div class="col-sm-10"><input type="text" class="form-control" required name="password" value="<?php echo $testimonial['pass1']; ?>"></div>
                                </div>
                                <div class="hr-line-dashed"></div>  
                                <div class="form-group  row"><label class="col-sm-2 col-form-label">Qualification</label>
                                    <div class="col-sm-10"><input type="text" class="form-control" required name="qualification" value="<?php echo $testimonial['qualification']; ?>"></div>
                                </div>
                                <div class="hr-line-dashed"></div>                       
                                <div class="form-group  row"><label class="col-sm-2 col-form-label">Image</label>
                                    <div class="col-sm-1"><img src="../assets/images/teachers/<?php echo $testimonial['image']; ?>" style="width:75px;height:75px;"/></div>
									<input type="hidden" name="oldimg" value="<?php echo $testimonial['image']; ?>"/>
									<div class="col-sm-9">
										<div class="custom-file">
											<input id="logo" type="file" name="image" class="custom-file-input">
											<label for="logo" class="custom-file-label">Choose file...</label>
										</div>
									</div>
                                </div>
								<div class="hr-line-dashed"></div>
                                <div class="form-group  row"><label class="col-sm-2 col-form-label">Description</label>
                                    <div class="col-sm-10"><textarea class="form-control ckeditor" name="description"><?php echo $testimonial['description']; ?></textarea></div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group row">
                                    <div class="col-sm-4 col-sm-offset-2">
                                        <button class="btn btn-white btn-sm" type="reset">Cancel</button>
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