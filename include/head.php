<?php @session_start(); include('include/conn.php'); ?>
<?php $information = $conn->query("SELECT * FROM information WHERE id='1'")->fetch_assoc(); ?>
<header id="header" class="header">
    <div class="header-top bg-theme-colored2 sm-text-center">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="widget text-white">
                        <ul class="styled-icons icon-sm pull-left flip sm-pull-none sm-text-center mt-5">
                            <?php if(!empty($information['facebook'])) { ?><li><a href="<?php echo $information['facebook']; ?>" target="_blank"><i class="fa fa-facebook text-white"></i></a></li><?php } ?>
                                <?php if(!empty($information['instagram'])) { ?><li><a href="<?php echo $information['instagram']; ?>" target="_blank"><i class="fa fa-instagram text-white"></i></a></li><?php } ?>
                                <?php if(!empty($information['youtube'])) { ?><li><a href="<?php echo $information['youtube']; ?>" target="_blank"><i class="fa fa-youtube text-white"></i></a></li><?php } ?>
                                <?php if(!empty($information['twitter'])) { ?><li><a href="<?php echo $information['twitter']; ?>" target="_blank"><i class="fa fa-twitter text-white"></i></a></li><?php } ?>
                                <?php if(!empty($information['linkden'])) { ?><li><a href="<?php echo $information['linkden']; ?>" target="_blank"><i class="fa fa-linkedin text-white"></i></a></li><?php } ?>
                        </ul>
                    </div>
                </div>
                <div class="col-md-2 pr-0">
                    <div class="widget"></div>
                </div>
                <div class="col-md-4">
                    <ul class="list-inline sm-pull-none sm-text-center text-right text-white mb-sm-20 mt-10">
                        <?php if(isset($_SESSION['pin_user']) && !empty($_SESSION['pin_user']) && $_SESSION['pin_user'] != '') { ?>
                        <li class="m-0 pl-10"> <a href="account.php" class="text-white"><i class="fa fa-user-o mr-5 text-white"></i> My Account </a> </li>
                        <li class="m-0 pl-10"> <a href="logout.php" class="text-white"><i class="fa fa-sign-out mr-5 text-white"></i> Logout </a> </li>
                        <?php } else { ?>
                        <li class="m-0 pl-10"> <a href="javascript:" data-toggle="modal" data-target="#LoginModal" class="text-white"><i class="fa fa-user-o mr-5 text-white"></i> Login </a> </li>
                        <li class="m-0 pl-10 pr-10">
                            <a href="javascript:" data-toggle="modal" data-target="#AccountModal" class="text-white"><i class="fa fa-edit mr-5"></i>Register</a>
                        </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="header-middle p-0 bg-lightest xs-text-center">
        <div class="container pt-5 pb-5">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-3">
                    <a class="menuzord-brand pull-left flip sm-pull-center mb-5" href="index.php"><img style="max-height:85px;" src="images/logo.png" alt></a>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-9">
                    <div class="row">
                        <div class="col-xs-12 col-sm-1 col-md-1  pt-20"></div>
                        <?php if(!empty($information['phone'])) { ?>
				    	<div class="col-xs-12 col-sm-3 col-md-3  pt-20">
                            <div class="widget no-border sm-text-center mt-10 mb-10 m-0">
                                <i class="pe-7s-headphones text-theme-colored2 font-48 mt-0 mr-15 mr-sm-0 sm-display-block pull-left flip sm-pull-none"></i>
                                <span class="font-12 text-gray text-uppercase d-block">Call us</span>
                                <h6 class="font-12 text-black m-0"><?php echo htmlspecialchars($information['phone']); ?></h6>
                            </div>
                        </div>
                        <?php } ?>
                        <?php if(!empty($information['email'])) { ?>
                        <div class="col-xs-12 col-sm-3 col-md-3  pt-20">
                            <div class="widget no-border sm-text-center mt-10 mb-10 m-0">
                                <i class="pe-7s-mail-open text-theme-colored2 font-48 mt-0 mr-15 mr-sm-0 sm-display-block pull-left flip sm-pull-none"></i>
                                <span class="font-12 text-gray text-uppercase d-block">Email us</span>
                                <h6 class="font-12 m-0"><a href="mailto:<?php echo htmlspecialchars($information['email']); ?>" class="text-theme-colored2 font-weight-600"><?php echo htmlspecialchars($information['email']); ?></a></h6>
                            </div>
                        </div>
                         <?php } ?>
                         <div class="col-xs-12 col-sm-5 col-md-5  pt-20">
                            <div class="widget no-border sm-text-center mt-10 mb-10 m-0">
                                <div class="col-sm-2"></div><a href="#" class="font-12 text-gray text-uppercase">Private Course Code</a>
                                <form id="importformheader" name="importformheader" class="rest-form mb-0" method="post" action="javascript:">
                                    <div class="form-group  row" style="margin-bottom:0"><div class="col-sm-2"></div>
                                        <div class="col-sm-6 pl-0"><input type="text" style="height:30px" required minlength="8" maxlength="8" class="form-control bg-gray-gainsboro ml-10" name="course_code" id="course_codeheader"></div>
                                        <div class="col-sm-4 pl-0"><button style="width: 100px;text-align: center;float: none;margin: 0 auto;" type="submit" id="submitbookheader" class="btn btn-colored btn-block btn-theme-colored2 text-white btn-sm btn-flat" data-loading-text="Please wait...">Book Now</button></div>
                                    </div>
                                <p id="bookerrheader" style="display:none; color:red; font-weight:bold;text-align: right;"></p>
                                </form>
                                <div id="myloaderdef"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="header-nav"><?php $activePage = basename($_SERVER['PHP_SELF'], ".php"); ?>
        <div class="header-nav-wrapper navbar-scrolltofixed bg-white" style="position:relative">
            <div class="container">
                <nav id="menuzord" class="menuzord default menuzord-responsive">
                    <ul class="menuzord-menu">
                       <li class="<?= ($activePage == 'index' || $activePage == '') ? 'active':''; ?>"><a href="index.php">HOME</a></li>
						<li class="<?= ($activePage == 'contact') ? 'active':''; ?>"><a href="contact.php">CONTACT</a></li>
                    </ul>
                </nav>
            </div>
                    
        </div>
    </div>
</header>