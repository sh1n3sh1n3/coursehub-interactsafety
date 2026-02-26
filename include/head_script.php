<?php
// Use current request URL so local (localhost) and production work without redirecting to production
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'localhost';
$scriptDir = isset($_SERVER['SCRIPT_NAME']) ? dirname($_SERVER['SCRIPT_NAME']) : '';
$basePath = ($scriptDir === '/coursehub' || strpos($scriptDir, '/coursehub/') === 0) ? '/coursehub' : '';
$baseHref = rtrim($protocol . '://' . $host . $basePath, '/') . '/';
?>
<base href="<?php echo htmlspecialchars($baseHref); ?>">
<link href="images/logo/favicon.ico" rel="shortcut icon" type="image/x-icon">
<link href="images/logo/favicon-32x32.png" rel="icon" type="image/png" sizes="32x32">
<link href="images/logo/favicon-16x16.png" rel="icon" type="image/png" sizes="16x16">
<link href="images/logo/apple-touch-icon.png" rel="apple-touch-icon">
<link href="images/logo/site.webmanifest" rel="manifest">
<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="css/jquery-ui.min.css" rel="stylesheet" type="text/css">
<link href="css/animate.css" rel="stylesheet" type="text/css">
<link href="css/css-plugin-collections.css" rel="stylesheet" />
<link href="css/select2.min.css" rel="stylesheet" type="text/css" />
<link href="css/menuzord-megamenu.css" rel="stylesheet" />
<link id="menuzord-menu-skins" href="css/menuzord-skins/menuzord-rounded-boxed.css" rel="stylesheet" />
<link href="css/style-main.css" rel="stylesheet" type="text/css">
<link href="css/preloader.css" rel="stylesheet" type="text/css">
<link href="css/custom-bootstrap-margin-padding.css" rel="stylesheet" type="text/css">
<link href="css/responsive.css" rel="stylesheet" type="text/css">
<link href="js/revolution-slider/css/settings.css" rel="stylesheet" type="text/css" />
<link href="js/revolution-slider/css/layers.css" rel="stylesheet" type="text/css" />
<link href="js/revolution-slider/css/navigation.css" rel="stylesheet" type="text/css" />
<link href="css/colors/theme-skin-color-set1.css" rel="stylesheet" type="text/css">
<link href="https://cdn.datatables.net/2.0.1/css/dataTables.dataTables.css" rel="stylesheet" type="text/css">
<link href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<style>
.select2-container--default .select2-selection--single {
    border: 1px solid #eee;
}
.select2-container .select2-selection--single .select2-selection__rendered {
    padding-left: 12px;
    padding-right: 12px;
}
.dataTables_length {
    display: inline;
    margin-left: 5px;
}
.dataTables_info {
    float: left;
    display: inline;
}
.dataTables_paginate.paging_simple_numbers {
    float: right;
    display: inline;
}
.menuzord-menu>li {
    margin-left: 4px !important;
}
.mandatory, .footnote {
color: #f00;
font-weight: bold;
}
.account-tabs.nav-tabs>li {
    width:100%;
}
.account-tabs.nav-tabs>li>a {
    border-bottom: 1px solid #ddd !important;
}
.account-tabs.nav-tabs>li.active>a, .account-tabs.nav-tabs>li.active>a:focus, .account-tabs.nav-tabs>li.active>a:hover {
    border-bottom: 1px solid #fc9928 !important;
    background: #f9f9f6;
}
.account-box .panel-default {
    border-color: transparent !Important;
}
.testimonial-box {
    padding: 25px 25px 25px 50px;
    margin-bottom: 25px;
    background: #ebebeb !important;
    position: relative;
    font-style:italic;
}
.testimonial-content.testimonial-div::after {
    width: 50px;
    height: 45px;
    background: #165F9A;
    text-align: center;
    font-size: 22px;
    color: #fff;
    line-height: 45px;
    position: absolute;
    top: 37px;
    left: -19px;
    opacity: 1;
}
.testimonial .testimonial-box:after {
    content: "";
    display: inline-block;
    width: 20px;
    height: 20px;
    background: #ebebeb !important;
    position: absolute;
    bottom: -10px;
    left: 22px;
    transform: rotate(45deg);
}
.testimonial-content.testimonial-div {
    margin-top: 0;
    margin-left: 25px;
    position: relative;
}
.sortable-handler { touch-action: auto; }
html, body, #wrapper {
    overflow-y: auto !important;
    height: auto !important;
}

* {
    touch-action: auto !important;
}

</style>