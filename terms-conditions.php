<?php session_start();
include('include/conn.php');

$terms_static = true; // Set to false to use content from admin (policy id=2)
if ($terms_static) {
    $terms_content = get_interact_safety_terms();
} else {
    $policy = $conn->query("SELECT * FROM policy WHERE id='2'")->fetch_assoc();
    $terms_content = $policy['content'] ?? '';
}

function get_interact_safety_terms() {
    ob_start();
    ?>
<div class="content">
    <h3 class="text-theme-colored2 mt-0">Interact Safety – Training Course Terms & Conditions</h3>

    <h4 class="mt-30 mb-10">1. Application of These Terms</h4>
    <p>These Terms and Conditions apply to all training courses delivered by Interact Safety, including but not limited to Health and Safety Representative (HSR) training, HSR Refresher training, First Aid courses, and any future training services delivered under the Interact Safety brand.</p>
    <p>By enrolling in a course, you agree to these Terms and Conditions.</p>

    <h4 class="mt-30 mb-10">2. Enrolment and Payment (Seat Confirmation)</h4>
    <p>A place in a course is only confirmed once full payment has been successfully received.</p>
    <p>Interact Safety does not reserve, hold, or guarantee seats without payment.</p>
    <p>If payment is not completed, the enrolment will not be confirmed and the seat may be released to other participants.</p>

    <h4 class="mt-30 mb-10">3. Course Information and Communication</h4>
    <p>Upon successful enrolment and payment, students will receive a confirmation email and receipt containing course details, location, start times, and any requirements for attendance.</p>
    <p>It is the student's responsibility to provide a correct email address and contact details at the time of booking.</p>

    <h4 class="mt-30 mb-10">4. Attendance and Participation Requirements</h4>
    <p>Students are expected to attend the full duration of the course and actively participate in all required learning and assessment activities.</p>
    <p>For HSR and accredited training, full attendance may be required to meet certification and regulatory requirements.</p>
    <p>Failure to attend or complete the required components may result in a certificate not being issued.</p>

    <h4 class="mt-30 mb-10">5. Certification and Course Completion</h4>
    <p>Certificates will be issued to students who successfully meet the course attendance and assessment requirements, where applicable.</p>
    <p>Certificates will be sent to the email address provided during enrolment unless otherwise specified.</p>

    <h4 class="mt-30 mb-10">6. Cancellations, Transfers and Rescheduling</h4>
    <p>If a student is unable to attend a scheduled course, Interact Safety must be notified as soon as possible.</p>
    <p>At our discretion, students may be offered a transfer to a future course date, subject to availability.</p>
    <p>Late cancellations or non-attendance may result in forfeiture of course fees, as course resources and trainer allocations are committed in advance.</p>

    <h4 class="mt-30 mb-10">7. Course Changes and Trainer Allocation</h4>
    <p>Interact Safety reserves the right to make reasonable changes to course dates, locations, delivery format, or trainers where necessary.</p>
    <p>Courses may be delivered by suitably qualified and competent trainers engaged by or working on behalf of Interact Safety.</p>
    <p>All trainers will meet the relevant competency and training requirements for the course being delivered.</p>

    <h4 class="mt-30 mb-10">8. Student Conduct and Workplace Safety</h4>
    <p>Interact Safety is committed to providing a respectful, safe, and professional learning environment.</p>
    <p>Participants are expected to behave in a manner that supports a positive training environment.</p>
    <p>Interact Safety reserves the right to remove any participant whose behaviour is unsafe, disruptive, or inappropriate, without refund where reasonable.</p>

    <h4 class="mt-30 mb-10">9. Photography, Video and Promotional Media</h4>
    <p>Interact Safety may take photographs or short video recordings during training sessions for training records, quality assurance, and promotional purposes, including use on our website and social media platforms (such as LinkedIn, Facebook, and Instagram).</p>
    <p>Students who do not wish to be photographed or recorded must notify Interact Safety prior to or at the commencement of the course. Reasonable steps will be taken to respect these preferences.</p>

    <h4 class="mt-30 mb-10">10. Privacy and Data Collection</h4>
    <p>Interact Safety collects and stores student information for the purpose of course administration, communication, certification, and compliance with relevant training and regulatory requirements (including HSR course administration where applicable).</p>
    <p>Personal information will be handled in accordance with applicable privacy obligations and will not be disclosed to third parties except where required for certification, compliance, or legal purposes.</p>

    <h4 class="mt-30 mb-10">11. Limitation of Liability</h4>
    <p>Interact Safety provides training services with due care, skill, and professionalism.</p>
    <p>To the extent permitted by law, Interact Safety is not liable for any indirect or consequential loss arising from participation in a training course, except where required under Australian Consumer Law.</p>

    <h4 class="mt-30 mb-10">12. Acceptance of Terms</h4>
    <p>By proceeding with enrolment and payment, you confirm that you have read, understood, and agree to these Terms and Conditions.</p>
    <p>Payment confirms your place in the course and acceptance of the above conditions.</p>
</div>
    <?php
    return ob_get_clean();
}
?>
<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>

    <meta name="viewport" content="width=device-width,initial-scale=1.0" />
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <meta name="description" content="Learnpro - Education University School Kindergarten Learning HTML Template" />
    <meta name="keywords" content="education,school,university,educational,learn,learning,teaching,workshop" />
    <meta name="author" content="ThemeMascot" />
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">

    <title>Training Course Terms & Conditions | Interact Safety</title>
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
                                <h2 class="text-theme-colored2 font-36">Training Course Terms & Conditions</h2>
                                <ol class="breadcrumb text-left mt-10 white">
                                    <li><a href="index.php">Home</a></li>
                                    <li><a href="terms-conditions.php" class="active">Training Course Terms & Conditions</a></li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section>
                <div class="container mt-30 mb-30 pt-30 pb-30">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="single-service">                             
                                <?php echo $terms_content; ?>
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