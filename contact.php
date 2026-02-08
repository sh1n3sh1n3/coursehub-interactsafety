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
        <?php
        include("include/head.php");
        ?>
     <div class="main-content">

            <section class="inner-header divider layer-overlay overlay-theme-colored-7" data-bg-img="images/bg/bg1.jpg">
                <div class="container pt-20 pb-20" id="book">

                    <div class="section-content">
                        <div class="row">
                            <div class="col-md-12">
                                <h2 class="text-theme-colored2 font-36">Company Name Safety and Training: Contact</h2>
                                <ol class="breadcrumb text-left mt-10 white">
                                    <li><a href="#">Home</a></li>                                    
                                    <li class="active">Contact</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

           <section class="divider">
                <div class="container pt-50 pb-70">
                    <div class="row pt-10">
                        <div class="col-md-5">
                            <h4 class="mt-0 mb-30 line-bottom-theme-colored-2">Find Our Location</h4>

                            <iframe class="w-100" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d29993.713570913787!2d144.9679653259878!3d-37.797051606704585!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6ad65d4c2b349649%3A0xb6899234e561db11!2sEnvato!5e0!3m2!1sen!2sbd!4v1697103076200!5m2!1sen!2sbd" height="400" style="border:0;" allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                        <div class="col-md-7">
                            <h4 class="mt-0 mb-30 line-bottom-theme-colored-2">Interested in discussing?</h4>

                            <form id="contact_form" name="contact_form" class method="post">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group mb-30">
                                            <input id="form_name" name="form_name" class="form-control" type="text" placeholder="Enter Name" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group mb-30">
                                            <input id="form_email" name="form_email" class="form-control required email" type="email" placeholder="Enter Email">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group mb-30">
                                            <input id="form_subject" name="form_subject" class="form-control required" type="text" placeholder="Enter Subject">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group mb-30">
                                            <input id="form_phone" name="form_phone" class="form-control" type="text" placeholder="Enter Phone">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-30">
<textarea id="form_message" name="form_message" class="form-control required" rows="7" placeholder="Enter Message"></textarea>
                                </div>
                                <div class="form-group">
                                    <input id="form_botcheck" name="form_botcheck" class="form-control" type="hidden" value />
                                    <button type="submit" class="btn btn-flat btn-default bg-hover-theme-colored mr-5" data-loading-text="Please wait...">Send your message</button>
                                    <button type="reset" class="btn btn-flat btn-theme-colored2 bg-hover-theme-colored">Reset</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="row mt-60">
                        <div class="col-sm-12 col-md-3">
                            <div class="contact-info text-center bg-silver-light border-1px pt-60 pb-60">
                                <i class="fa fa-phone font-36 mb-10 text-theme-colored2"></i>
                                <h4>Call Us</h4>
                                <h6 class="text-gray">Phone: +0000 000 0000</h6>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-3">
                            <div class="contact-info text-center bg-silver-light border-1px pt-60 pb-60">
                                <i class="fa fa-map-marker font-36 mb-10 text-theme-colored2"></i>
                                <h4>Address</h4>
                                <h6 class="text-gray">121 King Street, Australia</h6>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-3">
                            <div class="contact-info text-center bg-silver-light border-1px pt-60 pb-60">
                                <i class="fa fa-envelope font-36 mb-10 text-theme-colored2"></i>
                                <h4>Email</h4>
                                <h6 class="text-gray"><a href="#" class="__cf_email__" data-cfemail="ccb5a3b98cb5a3b9bea8a3a1ada5a2e2afa3a1">[email&#160;protected]</a></h6>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-3">
                            <div class="contact-info text-center bg-silver-light border-1px pt-60 pb-60">
                                <i class="fa fa-fax font-36 mb-10 text-theme-colored2"></i>
                                <h4>Fax</h4>
                                <h6 class="text-gray">0000 000 0000</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <?php
        include("include/footer.php");
        ?>
    </div>
    <?php
    include("include/footer_script.php");
    ?>
</body>
</html>