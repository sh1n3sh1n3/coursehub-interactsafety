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
                    <h2>Blogs </h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="index.php">Home</a>
                        </li>
                        <li class="breadcrumb-item">
							<a href="blogs.php">Blogs</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>Add Blog</strong>
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
                            <h5>Add Blog</h5>
                        </div>
						<?php function checkimg($pic){
								if (file_exists("../assets/images/blog/" . $pic)) {
									return false;
								} else {
									return true;
								}
							}
							$err = $msg = '';
							if(isset($_POST['submit'])) {
								$title = mysqli_real_escape_string($conn, $_POST['title']);
								$slug = mysqli_real_escape_string($conn, $_POST['title']);
								$content = mysqli_real_escape_string($conn, $_POST['content']);
								$postedby = mysqli_real_escape_string($conn, $_POST['postedby']);
								$tags = mysqli_real_escape_string($conn, $_POST['tags']);
								$postdate = mysqli_real_escape_string($conn, $_POST['postdate']);
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
												  $targetPath = "../assets/images/blog/".$image; // Target path where file is to be stored
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
							$insert = $conn->query("INSERT INTO blogs (title,slug,content,postedby,tags,postdate,image) VALUES('".$title."','".$slug."','".$content."','".$postedby."','".$tags."','".$postdate."','".$image."')");
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
						?>
						
                        <div class="ibox-content">
                            <form method="post" enctype="multipart/form-data">
                                <div class="form-group  row"><label class="col-sm-2 col-form-label">Title</label>
                                    <div class="col-sm-10"><input type="text" class="form-control" required name="title"></div>
                                </div>
								<div class="hr-line-dashed"></div>
                                <div class="form-group  row"><label class="col-sm-2 col-form-label">Tags(comma separated)</label>
                                    <div class="col-sm-10"><input type="text" class="form-control" required name="tags"></div>
                                </div>
								<div class="hr-line-dashed"></div>
                                <div class="form-group  row"><label class="col-sm-2 col-form-label">Posted By</label>
                                    <div class="col-sm-10"><input type="text" class="form-control" required name="postedby"></div>
                                </div>
								<div class="hr-line-dashed"></div>
                                <div class="form-group  row"><label class="col-sm-2 col-form-label">Post Date</label>
                                    <div class="col-sm-10"><input type="date" class="form-control" required name="postdate"></div>
                                </div>
								<div class="hr-line-dashed"></div>
                                <div class="form-group  row"><label class="col-sm-2 col-form-label">Description</label>
                                    <div class="col-sm-10"><textarea class="form-control ckeditor" name="content"></textarea></div>
                                </div>
                                <div class="hr-line-dashed"></div> 
								<div class="form-group  row"><label class="col-sm-2 col-form-label">Image</label>
									<div class="col-sm-10">
										<div class="custom-file">
											<input id="logo" required type="file" name="image" class="custom-file-input">
											<label for="logo" class="custom-file-label">Choose file...</label>
										</div>
									</div>
                                </div>
                                <div class="hr-line-dashed"></div>   
                                <div class="form-group row">
                                    <div class="col-sm-4 col-sm-offset-2">
                                        <button class="btn btn-primary btn-sm" type="submit" name="submit">Submit</button>
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