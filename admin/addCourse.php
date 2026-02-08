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
                    <h2>Courses </h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="index.php">Home</a>
                        </li>
                        <li class="breadcrumb-item">
							<a href="courses.php">Courses</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>Add Courses</strong>
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
                            <h5>Add Courses</h5>
                        </div>
						<?php function checkimg($pic){
								if (file_exists("../assets/images/course/" . $pic)) {
									return false;
								} else {
									return true;
								}
							}
							$err = $msg = '';
							if(isset($_POST['submit'])) {
							    $category = mysqli_real_escape_string($conn, $_POST['category']);
							    $course_type = mysqli_real_escape_string($conn, $_POST['course_type']);
								$title = mysqli_real_escape_string($conn, $_POST['title']);
									$phrase  = mysqli_real_escape_string($conn, $_POST['title']);
								$healthy = [")", "(", "''''"," "];
                                $yummy   = ["", "", "","-"];

                                $newPhrase = str_replace($healthy, $yummy, $phrase);
                
                
								$slug = $newPhrase;
								$short = mysqli_real_escape_string($conn, $_POST['short']);
								$aliascoursename = mysqli_real_escape_string($conn, $_POST['title']);
								$description = mysqli_real_escape_string($conn, $_POST['description']);
								$shortdescription = mysqli_real_escape_string($conn, $_POST['shortdescription']);
								$price = mysqli_real_escape_string($conn, $_POST['price']);
								$shippingCharge = '0';
								$mrp = mysqli_real_escape_string($conn, $_POST['price']);
								$delivery_types = mysqli_real_escape_string($conn, $_POST['delivery_types']);
								$tax = '0';
								$duration = mysqli_real_escape_string($conn, $_POST['duration']);
								$duration_type = mysqli_real_escape_string($conn, $_POST['duration_type']);
								$orderby = '0';
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
                    							  $targetPath = "../assets/images/course/".$image; // Target path where file is to be stored
                    							  if(move_uploaded_file($sourcePath,$targetPath)){}else{
                    								 echo  'Error while uploading your image try again later!';
                    								 $up=0;
                    							  }
                    						 }  
                    					}else{
                    						 echo 'Only jpg, jpeg and png file allowed!';
                    					}
                    				}
                    			}
							$insert = $conn->query("INSERT INTO courses (catid,title,slug,description,image,status,addedby,price, shippingCharge, tax, mrp,shortdescription,short,aliascoursename,orderby,duration,course_type,duration_type,delivery_types) VALUES('".$category."','".$title."','".$slug."','".$description."','".$image."','1','".$_SESSION['admin']."','".$price."', '".$shippingCharge."', '".$tax."', '".$mrp."', '".$shortdescription."', '".$short."','".$aliascoursename."','".$orderby."', '".$duration."', '".$course_type."','".$duration_type."','".$delivery_types."')");
							if($insert){
							    $lastid = $conn->insert_id;
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
						?>
						
                        <div class="ibox-content">
                            <form method="post" enctype="multipart/form-data">
                                		<div class="form-group  row">
									<label class="col-sm-2 col-form-label">Select Category</label>
									<div class="col-sm-4">
										<select class="form-control" required name="category">
											<option value="">Select</option>
											<?php $count=0;
											$contact = $conn->query("SELECT * FROM category WHERE status='1' order by id ASC");
											while($fetch = $contact->fetch_assoc()) {$count++; ?>
											<option value="<?php echo $fetch['id']; ?>"><?php echo $fetch['title']; ?></option>
											<?php } ?>
										</select>
									</div>
									<label class="col-sm-2 col-form-label">Course Type</label>
									<div class="col-sm-4">
										<select class="form-control" required name="course_type">
											<option value="">Select</option>
											<option value="Public">Public</option>
											<option value="Private">Private</option>
										</select>
									</div>
								</div>
                                <div class="form-group  row"><label class="col-sm-2 col-form-label">Course Name</label>
                                    <div class="col-sm-4"><input type="text" class="form-control" required name="title" value=""></div>
									<label class="col-sm-2 col-form-label">Course Code</label>
                                    <div class="col-sm-4"><input type="text" class="form-control" required name="short" oninput="this.value = this.value.toUpperCase()"  value=""></div>
								</div>
                                <div class="hr-line-dashed"></div> 
                                
								<div class="form-group  row">
								    <label class="col-sm-2 col-form-label">Price</label>
                                    <div class="col-sm-4"><input type="number" step="0.01" class="form-control" required name="price" value=""></div> 
                                <label class="col-sm-2 col-form-label">Different types of delivery </label>
                                    <div class="col-sm-4"><select class="form-control" required name="delivery_types">
                                        <option value="">Select</option>
                                        <option value="Face to Face">Face to Face</option>
                                        <option value="eLearning">eLearning</option>
                                        <option value="Connected Real Time Delivery">Connected Real Time Delivery</option>
                                    </select></div>
                               
                                </div>
                                <div class="hr-line-dashed"></div>  
                                <div class="form-group  row"><label class="col-sm-2 col-form-label">Course Duration </label>
                                    <div class="col-sm-4"><input type="number" class="form-control" required name="duration" value=""></div>
                                <label class="col-sm-2 col-form-label">Type</label>
                                    <div class="col-sm-4"><select class="form-control" required name="duration_type">
                                        <option value="">Select</option>
                                        <option value="Days">Days</option>
                                        <option value="Hours">Hours</option>
                                    </select></div>
                                </div>
                                    <div class="form-group  row">
                              <label class="col-sm-2 col-form-label">Image</label>
									<div class="col-sm-4">
										<div class="custom-file">
											<input id="logo" type="file" name="image" required class="custom-file-input">
											<label for="logo" class="custom-file-label">Choose file...</label>
										</div>
									</div>
                                </div>
								<div class="hr-line-dashed"></div>
                                <div class="form-group  row"><label class="col-sm-2 col-form-label">Short Description</label>
                                    <div class="col-sm-10"><textarea class="form-control ckeditor" name="shortdescription"></textarea></div>
                                </div>
								<!--<div class="hr-line-dashed"></div>-->
        <!--                        <div class="form-group  row"><label class="col-sm-2 col-form-label">Description</label>-->
        <!--                            <div class="col-sm-10"><textarea class="form-control ckeditor" name="description"></textarea></div>-->
        <!--                        </div>-->
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