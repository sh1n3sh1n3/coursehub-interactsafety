<?php session_start(); include('include/conn.php'); 
$catid=$_GET['id'];
//$courses_details = $conn->query("SELECT * FROM courses WHERE id='".$catid."'")->fetch_assoc();
$cate = $conn->query("SELECT *,replace(slug,' ','-') as slug FROM category WHERE id='".$catid."'")->fetch_assoc();
//require_once('phpmailer/class.phpmailer.php');
  //  $emailaccount = $conn->query("SELECT * FROM emails WHERE type='support'")->fetch_assoc();
    //$refitcertifiedph = $emailaccount['phone'];
    //$refitcertifiedem = $emailaccount['email1'];
?>

<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>

    <meta name="viewport" content="width=device-width,initial-scale=1.0" />
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <meta name="description" content="<?php echo $cate['title']; ?> " />
    <meta name="keywords" content="<?php echo $cate['title']; ?> " />
    <meta name="author" content="<?php echo $cate['title']; ?> " />
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <title><?php echo $cate['title']; ?> | Interact Safety</title>
    <?php include("include/head_script.php");?>
    <style>
    .course-card { border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.08); transition: box-shadow 0.2s; }
    .course-card:hover { box-shadow: 0 4px 14px rgba(0,0,0,0.12); }
    .course-card .thumb { overflow: hidden; }
    .course-card .thumb img { height: 180px; width: 100%; object-fit: cover; display: block; }
    .course-card .card-body { padding: 16px; background: #fff; }
    .course-card .card-title { font-size: 14px; font-weight: 600; margin: 0 0 10px 0; line-height: 1.35; min-height: 2.7em; }
    .course-card .card-title a { color: #333; }
    .course-card .card-title a:hover { color: #D8701A; text-decoration: none; }
    .course-card .card-meta { display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; padding-bottom: 10px; border-bottom: 1px solid #eee; font-size: 14px; }
    .course-card .card-price { color: #D8701A; font-weight: 700; }
    .course-card .card-duration { color: #666; }
    .course-card .card-desc { font-size: 13px; color: #555; line-height: 1.45; min-height: 2.9em; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; }
    .course-card a { display: block; text-decoration: none; color: inherit; }
    </style>
</head>
<body class>
<div id="wrapper" class="clearfix">
        <?php include("include/head.php"); ?>
        <div class="main-content">
            <section class="inner-header divider layer-overlay overlay-theme-colored-7" data-bg-img="images/bg/bg1.jpg">
                <div class="container pt-20 pb-20">
                    <div class="section-content">
                        <div class="row">
                            <div class="col-md-12">
                                <h2 class="text-theme-colored2 font-36"><?php echo $cate['title']; ?></h2>
                                <ol class="breadcrumb text-left mt-10 white">
                                    <li><a href="index.php">Home</a></li>
                                    <li><a href="courses-category.php">Courses</a></li>
                                    <li class="active"><?php echo $cate['title']; ?></li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section>
                <div class="container pt-70 pb-40">
                    <div class="section-content">
                        <div class="panel panel-warning">
                            <div class="panel-heading clearfix">
                                <h2 class="panel-title">Select or change your region 
                                <div data-example-id="split-button-dropdown" class="bs-example pull-right">
                                  <div class="btn-group">
                                    <a href="javascript:" onclick="filterdata('all')" class="btn btn-warning" role="button">Show All</a>
                                  </div>
                                  	<?php $contact = $conn->query("SELECT DISTINCT state FROM locations order by state asc");
                                	while($fetch = $contact->fetch_assoc()) { 
                                	    $states = $conn->query("SELECT * FROM states WHERE id=".$fetch['state'])->fetch_assoc();
                                	?>
                                      <div class="btn-group">
                                        <button class="btn btn-warning" type="button"><?php echo $states['code']; ?></button>
                                        <button aria-expanded="false" aria-haspopup="true" data-toggle="dropdown" class="btn btn-warning dropdown-toggle" type="button">
                                         <span class="caret"></span> <span class="sr-only">Toggle Dropdown</span> </button>
                                        <ul class="dropdown-menu">
                                            <?php	$contact1 = $conn->query("SELECT DISTINCT city, id FROM locations WHERE state='".$fetch['state']."' order by id ASC");
                                    		while($fetch1 = $contact1->fetch_assoc()) {
                                	        $cities = $conn->query("SELECT * FROM cities WHERE id=".$fetch1['city'])->fetch_assoc(); ?>
                                                <li><a href="javascript:" onclick="filterdata(<?php echo $fetch1['id']; ?>)"><?php echo $cities['name']; ?></a></li>
                                          	<?php } ?>
                                        </ul>
                                      </div>
                                  	<?php } ?>
                                </div>
                            </div>
                            <div class="panel-body" style="padding-top: 0 "> 
                                <div class="row multi-row-clearfix" id="filteredData">
                                <div class="bg-silver-deep" style="padding:15px"><b>All Records</b></div>
<?php $catid=$_GET['id'];
            					$courses = $conn->query("SELECT *,replace(slug,' ','-') as slug FROM courses WHERE status='1' AND isPublished='1' and catid='".$catid."'  order by title ASC");
            					if($courses->num_rows > 0) {
            					while($fetchcourses = $courses->fetch_assoc()) {
            					    $id = $fetchcourses['id'];
            					    $price = isset($fetchcourses['price']) && $fetchcourses['price'] !== '' ? $fetchcourses['price'] : null;
            					    $duration = '';
            					    if (!empty($fetchcourses['duration'])) $duration = $fetchcourses['duration'] . ' ' . (isset($fetchcourses['duration_type']) ? $fetchcourses['duration_type'] : 'days');
            					?>
                                    <div class="col-sm-6 col-md-3">
                                        <div class="course-card mb-30">
                                            <a href="courses-detail/<?php echo $fetchcourses['id']; ?>/<?php echo $fetchcourses['slug']; ?>">
                                                <div class="thumb">
                                                    <img src="assets/images/course/<?php echo htmlspecialchars($fetchcourses['image']); ?>" alt="<?php echo htmlspecialchars($fetchcourses['title']); ?>">
                                                </div>
                                                <div class="card-body">
                                                    <h5 class="card-title text-uppercase"><?php echo htmlspecialchars($fetchcourses['title']); ?></h5>
                                                    <div class="card-meta">
                                                        <?php if ($price !== null) { ?><span class="card-price"><?php echo htmlspecialchars($price); ?></span><?php } ?>
                                                        <?php if ($duration !== '') { ?><span class="card-duration"><?php echo htmlspecialchars($duration); ?></span><?php } ?>
                                                    </div>
                                                    <?php if (!empty($fetchcourses['shortdescription'])) { ?><div class="card-desc"><?php echo $fetchcourses['shortdescription']; ?></div><?php } ?>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
            					<?php } } else { ?>
                            	<div class="col-sm-12 col-md-12"><h3><center>No record found!!</center></h3></div>
                            	<?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <?php include("include/footer.php"); ?>
    </div>
    <?php include("include/footer_script.php"); ?>
    <script>
        function filterdata(val) {
            var catid = '<?php echo $_GET['id']; ?>';
           $.ajax({
               url: "filterdataCourse.php",
               type: "POST",
               data:  {val : val, catid : catid},
               success: function(data) {
                 $("#filteredData").html("").html(data);
              },       
            }); 
        }
    </script>
</body>
</html>