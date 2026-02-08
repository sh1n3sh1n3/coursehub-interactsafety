<?php session_start(); include('include/conn.php'); 
$coursesdata = $conn->query("SELECT * FROM courses WHERE id=".$_GET['courseid'])->fetch_assoc();
$course_slotsdata = $conn->query("SELECT * FROM course_slots WHERE id=".$_GET['slotid'])->fetch_assoc();
$locationsdata = $conn->query("SELECT * FROM locations WHERE id=".$_GET['locid'])->fetch_assoc();
$citiesdata = $conn->query("SELECT * FROM cities WHERE id=".$_GET['cityid'])->fetch_assoc();
?>

<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>

    <meta name="viewport" content="width=device-width,initial-scale=1.0" />
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">

    <title>Attandance | Company Name</title>
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
                <div class="container pt-20 pb-20" >

                    <div class="section-content">
                        <div class="row">
                            <div class="col-md-12">
                                <h2 class="text-theme-colored2 font-36">Attandance</h2>
                                <ol class="breadcrumb text-left mt-10 white">
                                    <li><a href="index.php">Home</a></li>
                                    <li class="active">Attandance</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section>
                <div class="container mt-30 mb-30 pt-30 pb-30">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="single-service">
                              <div class="attendance-container row">
                                    <div class="qr-container col-4">
                                        <div class="scanner-con">
                                            <h5 class="text-center">Scan you QR Code here for your attedance</h5>
                                            <video id="interactive" class="viewport" width="100%">
                                        </div>
                        
                                        <div class="qr-detected-container" style="display: none;">
                                            <form action="./endpoint/add-attendance.php" method="POST">
                                                <h4 class="text-center">Student QR Detected!</h4>
                                                <input type="hidden" id="detected-qr-code" name="qr_code">
                                                <button type="submit" class="btn btn-dark form-control">Submit Attendance</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
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
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>

    <!-- instascan Js -->
    <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>

    <script>

        
        let scanner;

        function startScanner() {
            scanner = new Instascan.Scanner({ video: document.getElementById('interactive') });

            scanner.addListener('scan', function (content) {
                $("#detected-qr-code").val(content);
                console.log(content);
                scanner.stop();
                document.querySelector(".qr-detected-container").style.display = '';
                document.querySelector(".scanner-con").style.display = 'none';
            });

            Instascan.Camera.getCameras()
                .then(function (cameras) {
                    if (cameras.length > 0) {
                        scanner.start(cameras[0]);
                    } else {
                        console.error('No cameras found.');
                        alert('No cameras found.');
                    }
                })
                .catch(function (err) {
                    console.error('Camera access error:', err);
                    alert('Camera access error: ' + err);
                });
        }

        document.addEventListener('DOMContentLoaded', startScanner);

        function deleteAttendance(id) {
            if (confirm("Do you want to remove this attendance?")) {
                window.location = "./endpoint/delete-attendance.php?attendance=" + id;
            }
        }
    </script>
</body>
</html>