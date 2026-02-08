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
                    <h2>Offers </h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="index.php">Home</a>
                        </li>
                        <li class="breadcrumb-item">
							<a href="offers.php">Offers</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>Update Offers</strong>
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
                            <h5>Update Offers</h5>
                        </div>
						<?php function checkimg($pic){
								if (file_exists("../assets/images/offers/" . $pic)) {
									return false;
								} else {
									return true;
								}
							}
							$err = $msg = '';
							if(isset($_POST['submit'])) {
								$title = mysqli_real_escape_string($conn, $_POST['title']);
								$button = mysqli_real_escape_string($conn, $_POST['button']);
								$link = mysqli_real_escape_string($conn, $_POST['link']);
								$tag = mysqli_real_escape_string($conn, $_POST['tag']);
								$tag1 = mysqli_real_escape_string($conn, $_POST['tag1']);
								$description = mysqli_real_escape_string($conn, $_POST['description']);
								$discount = mysqli_real_escape_string($conn, $_POST['discount']);
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
                    							  $targetPath = "../assets/images/offers/".$image; // Target path where file is to be stored
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
							$insert = $conn->query("UPDATE offerbanner SET button= '".$button."',link= '".$link."',description= '".$description."',tag= '".$tag."',tag1= '".$tag1."',title= '".$title."', discount= '".$discount."', image= '".$image."' WHERE id=".$id);
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
						$testimonial = $conn->query("SELECT * FROM offerbanner WHERE id=".$_GET['id'])->fetch_assoc();
						?>
						
                        <div class="ibox-content">
                            <form method="post" enctype="multipart/form-data">
							<input type="hidden" name="id" value="<?php echo $testimonial['id']; ?>"/>
                                <div class="form-group  row"><label class="col-sm-2 col-form-label">Title</label>
                                    <div class="col-sm-10"><input type="text" class="form-control" required name="title" value="<?php echo $testimonial['title']; ?>"></div>
                                </div>
                                <div class="hr-line-dashed"></div>                       
                                <div class="form-group  row"><label class="col-sm-2 col-form-label">Brief</label>
                                    <div class="col-sm-10"><input type="text" class="form-control" required name="description" value="<?php echo $testimonial['description']; ?>"></div>
                                </div>
                                <div class="hr-line-dashed"></div>                       
                                <div class="form-group  row"><label class="col-sm-2 col-form-label">Button</label>
                                    <div class="col-sm-10"><input type="text" class="form-control" required name="button" value="<?php echo $testimonial['button']; ?>"></div>
                                </div>
                                <div class="hr-line-dashed"></div>                       
                                <div class="form-group  row"><label class="col-sm-2 col-form-label">Link</label>
                                    <div class="col-sm-10"><input type="text" class="form-control" required name="link" value="<?php echo $testimonial['link']; ?>"></div>
                                </div>
                                <div class="hr-line-dashed"></div>                       
                                <div class="form-group  row"><label class="col-sm-2 col-form-label">Tagline 1</label>
                                    <div class="col-sm-10"><input type="text" class="form-control" required name="tag" value="<?php echo $testimonial['tag']; ?>"></div>
                                </div>
                                <div class="hr-line-dashed"></div>                       
                                <div class="form-group  row"><label class="col-sm-2 col-form-label">Tagline 2</label>
                                    <div class="col-sm-10"><input type="text" class="form-control" name="tag1" value="<?php echo $testimonial['tag1']; ?>"></div>
                                </div>
                                <div class="hr-line-dashed"></div>                       
                                <div class="form-group  row"><label class="col-sm-2 col-form-label">Discount</label>
                                    <div class="col-sm-10"><input type="text" class="form-control" name="discount" value="<?php echo $testimonial['discount']; ?>"></div>
                                </div>
                                <div class="hr-line-dashed"></div>                       
                                <div class="form-group  row"><label class="col-sm-2 col-form-label">Image</label>
                                    <div class="col-sm-1"><img src="../assets/images/offers/<?php echo $testimonial['image']; ?>" style="width:75px;height:75px;"/></div>
									<input type="hidden" name="oldimg" value="<?php echo $testimonial['image']; ?>"/>
									<div class="col-sm-9">
										<div class="custom-file">
											<input id="logo" type="file" name="image" class="custom-file-input">
											<label for="logo" class="custom-file-label">Choose file...</label>
										</div>
									</div>
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