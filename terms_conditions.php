
<?php
require 'functions.php';
?>
<!DOCTYPE html>
    <html>
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>OVS Terms and Condition | Data Privacy Policy</title>

    <!--Logo-->
    <link rel="shortcut icon" type="image/jpg" href="https://ik.imagekit.io/nwlfpk0xpdg/img/ovs_logo_x6ne_tPjZ7.jpg?ik-sdk-version=javascript-1.4.3&updatedAt=1648299575563" />
    
    <!--Rica: I replace the stylecss into this line--><link rel="stylesheet" href="style_terms_condition.css">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">

   <!--Font-->
    <!--Rica: I remove the lato font and add this line for the font--><link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,400;0,500;1,300;1,400&display=swap" rel="stylesheet">    
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/fonts/simple-line-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">


    <!--jQuery CDN for Owl Carousel-->
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <!--OWL Carousel CSS,JS-->
    <script src="https://cdn.boomcdn.com/libs/owl-carousel/2.3.4/owl.carousel.min.js"></script>
    <link rel="stylesheet" href="https://cdn.boomcdn.com/libs/owl-carousel/2.3.4/assets/owl.carousel.min.css">

    <!--FontAwesome Kit-->
    <script src="https://kit.fontawesome.com/8acebfc2d4.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <script>
        $(document).ready(function() {
            $('#VoterSignIn').on('hidden.bs.modal', function() {
                $(this).find('form').trigger('reset');
            });
        });
    </script>
</head>

   

<body>
    <!--Contacts Section-->
    <nav class="navbar navbar-expand text-white py-0 " style="background-color: #d00000;">
        <div class="container">
            <ul class="navbar-nav ">
                <li class="nav-item" style="margin-right: 10px;">
                    <small>Call (02) 392-0455</small>
                </li>
                <li class="list-inline-item"></li><a style="color:#ffffff" target="_blank" href="https://www.facebook.com/cpaips/"><i class="fa fa-facebook"></i></a>
                </li>
                <li class="list-inline-item"></li><a style="color:#ffffff" target="_blank" href="mailto:educpurponly101@gmail.com"><i class="fa fa-envelope"></i></a>
                </li>
                <li class="list-inline-item"></li><a style="color:#ffffff" target="_blank" href="https://www.youtube.com/channel/UCz7GtBK1hzFv7eEyZD2Y7hw"><i class="fab fa-youtube"></i></a>
                </li>
            </ul>
            <ul class="navbar-nav collapse navbar-collapse justify-content-end">
                <li class="nav-item">
                    <a class="nav-link text-white" href="admin-signin.php"><i class="fas fa-user-cog me-1"></i><small>Admin Portal</small></a>
                </li>
                <li class="nav-item"><span class="text-white">|</span></li>
              
            </ul>
        </div>
    </nav>

    <!--Main navbar-->
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg sticky-top">
        <!-- Container wrapper -->
        <div class="container" id="main-nav">

            <!-- Navbar brand -->
            <a class="navbar-brand mb-0 text-wrap" href="index.php"><img src="https://ik.imagekit.io/nwlfpk0xpdg/img/tr:w-50,h-50/ovs_logo_x6ne_tPjZ7.jpg?ik-sdk-version=javascript-1.4.3&updatedAt=1648299575563" alt="">
            <span class="brand">PLMAR Online Voting System</span></a>
            <!-- Toggle button -->
            <button id="button_toggle" class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
            </button>

            <!-- Collapsible wrapper -->
            <div class="collapse navbar-collapse" id="navbarText">
                <!-- Left links -->
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    
                    <li class="nav-item">
                        <a class="nav-link d-flex flex-column text-center" aria-current="page" href="index.php#student_org"><i class="fas fa-sitemap"></i>
                        <span class="small">Student Organizations</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link d-flex flex-column text-center" href="#VoterSignIn" data-bs-toggle="modal"><i class="fas fa-user-lock me-1"></i>
                        <span class="small">Voter Portal</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link d-flex flex-column text-center" aria-current="page" href="signup.php"><i class="fas fa-sign-in-alt"></i>
                        <span class="small">Sign Up</span></a>
                    </li>
                </ul>
                <!-- Left links -->
            </div>  
            <!-- Collapsible wrapper -->
          
        </div>
        <!-- Container wrapper -->
    </nav>
    <!-- End Navbar -->

    
    <!-- Modal -->
    <div class="modal fade" id="VoterSignIn" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-login">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="logo">
                        <img src="https://ik.imagekit.io/nwlfpk0xpdg/img/plmar__Bd61zVwi.png?ik-sdk-version=javascript-1.4.3&updatedAt=1636213486017" alt="">
                    </div>
                    <h2 class="modal-title w-100 font-weight-bold"><strong>Voter Login</strong></h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="vot_auth-login.php" method="post" id="frmSignIn">
                        <?php if (isset($_GET['error'])) { ?>
                            <div class="alert alert-danger" role="alert">
                                <i class="fa fa-times-circle fs-4 me-3"></i><small><?= $_GET['error'] ?></small>
                            </div>
                            <script type="text/javascript">
                                $(window).on('load', function() {
                                    $('#VoterSignIn').modal('toggle');
                                });
                                $('#VoterSignIn').on('hidden.bs.modal', function() {
                                    window.location.replace("index.php");
                                });
                            </script>
                        <?php } ?>
                        <div class="form-group mb-3">
<!--Rica: I add label for screen readers-->                            <label for="email">Email Address</label>
                            <input class="form-control validate" style="font-family:FontAwesome;" type="email" name="email" placeholder="&#xf007; Email Address" required="required">
                        </div>
                        <div class="form-group mb-3">
<!--Rica: I add label for screen readers-->                             <label for="email">Password</label>
                            <input class="form-control" type="password" style="font-family:FontAwesome;" name="password" placeholder="&#xf023; Password" required="required">
                        </div>
                        <div class="form-group mb-3 text-center">
                            <button class="btn btn-primary" type="submit">Sign In</button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    No account yet? <a class="" href="signup.php" style="color:blue; text-decoration: none;">Sign up here.</a>
                </div>
            </div>
        </div>
    </div>
    <!--End of Modal Voter Signin Section-->


    <!--body-->
    <div class="container">
        <div class="headerTAC">
            <h3>TERMS AND CONDITIONS AND PRIVACY POLICY</h3>
        </div>
        <div class="bodyTAC">
            <h5><bold>TERMS AND CONDITIONS</h5>
                <p>Please read the terms and conditions carefully before using the website, and the voting system.</p>
            <h5><bold>CONDITION OF USE</h5>
                <p>By using this website, you certify that you have read and reviewed this Agreement and that you agree to comply with the terms. If you do not want to be bound by the terms of this Agreement, you are advised to leave the website accordingly, the Online Voting System only grants use and access of this website, its system, and process to those who have accepted its terms.</p>
            <h5><bold>PRIVACY POLICY</h5>
                <p>Before you continue using the website, we advise you to read our <span><a href="#privacypolicy" >Privacy Policy</a><span> regarding our user data collection. It will help you better understand our practices and different information that the system will collect for it is needed for the system and website’s usage.</p>
            <h5><bold>USER RESTRICTION</h5>
                <p>You must be a student of PLMar, and enrolled in any of the courses being offered in the Pamantasan. By using this website, you warrant that you are a student, and currently enrolled and you may legally adhere to this Agreement. The website and system assumes no responsibility for liabilities related to user misrepresentation.</p>    
            <h5><bold>INTELLECTUAL PROPERTY</h5>
                <p>You agree that all materials, products, and processes provided on this website and system are property of OVS, its affiliates, admins, coordinators, and the Pamantasan including all copyrights, trade secrets, trademarks, patent, and other intellectual property. You also agree that you will not reproduce or redistribute the website’s and OVS’ intellectual property in any way, including electric, digital, or new trademark registrations.</p>
            <h5><bold>USER ACCOUNTS</h5>
                <p>As a user of this website and system, you may be asked to register with us and provide private information such as Student Name, Student Course, Student Number, and Email Address. You are responsible for ensuring the accuracy of this information, and you are responsible for maintaining the safety and security of your identifying information. You are also responsible for all activities that occur under your account or password.</p>
                <p>If you think there are any possible issues regarding the security of your account on the website, inform us immediately so we may address them accordingly.</p>
                <p>We reserve all rights to terminate accounts, edit, or remove content and cancel your registration at our sole discretion if you, as a student and user, violate said terms.</p>
            <h5><bold>LIMITATION ON LIABILITY, DISPUTES AND INDEMNIFICATION</h5>
                <p>The website and system is not liable for any damages that may occur to you as a result of your misuse of our website.</p>
                <p>Any disputes related in any way to your visit to this website or to how you use the system shall be arbitrated by the Pamantasan and you consent to exclusive jurisdiction and venue of such meeting for clearing any disputes and conflicts between you and the other party. The system and website will not be held liable to any disputes and conflicts you and the other party may incur.</p>
                <p>You agree to indemnify the website and its affiliates, admins, coordinators and the Pamantasan and hold harmless against legal claims and demands that may arise from your use or misuse of our system. </p>
                <p id="privacypolicy">The OVS and website reserves the right to edit, modify and change this Agreement at any time. We shall let our users know of these changes through electronic mail (e-mail). This Agreement is an understanding between the website and the user, and this supersedes and replaces all prior agreements regarding the use of this website.</p>
        </div>

        <div class="headerTAC">
            <h3>PRIVACY POLICY</h3>
        </div>
        <div class="bodyTAC">
            <h5><bold>PRIVACY POLICY</h5>
            <p>This privacy policy will help you understand how the website and system uses and protects the data and information you provide to us when you visit and use the website and system.</p>
            <p>We reserve the right to change this policy at any given time, of which you will be promptly updated. If you want to make sure that you are up to date with the latest changes, we advise you to frequently visit the website and system.</p>
            <h5><bold>WHAT USER DATA AND INFORMATION WE COLLECT</h5>
            <p>When you visit the website and want to access the system, we may collect information about you in a variety of ways. The information we may collect through the website depends on the process and access level you may want to have and use.</p>
            <h5><bold>PERSONAL DATA</h5>
            <p>We collect and store all personal information related to your user profile, which you voluntarily give us either upon registration or through continued use of the website.</p>
            <ul>
                <li>Student Name</li>
                <li>Student Course</li>
                <li>Student Number</li>
                <li>Email Address</li>
                <li>Photo Uploaded</li>
                <li>Miscellaneous information such as Campaign Platform and Candidacy Info if you as a user is categorized as a Candidate.</li>
                <li>Vote</li>
            </ul>
            <p>Information the server automatically collects when you want to visit and access the website and system, such as your native actions that are integral to the system, actions taken when creating entries, editing entries and uploading media to the website. As such, we may also request access to your device’s photo roll or camera in order for us to upload your media to the system. Any media uploaded to this website will be collected and stored on our servers. If you wish to change our access or permissions, you may do so in your device’s settings. </p>
            <h5><bold>WHY WE COLLECT DATA AND INFORMATION AND HOW WE USE IT</h5>
            <p>We are collecting your data and information for several reasons.</p>
            <ul>
                <li>To validate whether you are an enrolled student of PLMar that is eligible to have access to the system.</li>
                <li>To give you, an eligible user, an access to the website and system.</li>
                <li>To authenticate that you are a user and have the right credentials to access the voting system.</li>
                <li>To better understand your needs.</li>
                <li>To improve the website and the system.</li>
                <li>To customize our website and system according to the user’s behavior and personal preferences.</li>
            </ul>
            <p>We use your data and information for the sole purpose of its need for the website and system. As such, we do not allow its usage in other purposes.</p>
            <h5><bold>SAFEGUARDING, SECURING AND CONFIDENTIALITY OF YOUR DATA AND INFORMATION</h5>
            <p>The website and OVS is committed to securing your data and keeping it confidential. The website will do in all its power to prevent data theft, unauthorized access, and disclosure by implementing the latest technologies and software, which will help us safeguard all the information we collect online.</p>
            <p>The data and information provided by the user will be used only to the website and system, and will not and can’t be used for other purposes outside its original and sole purpose of needs.</p>
            <h5><bold>OUR COOKIE POLICY</h5>
            <p>Once you agree to allow our website to use cookies, you also agree to use the data it collects regarding your online behavior.</p>
            <p>The data we collect by using cookies is used to customize our website to your needs. After we use the data for statistical analysis, the data is completely removed from our systems.</p>
            <p>Please note that cookies don’t allow us to gain control of your computer in any way. They are strictly used to monitor which pages you find useful and which you do not so that we can provide a better experience for you.</p>
            <p>If you want to disable cookies, you can do it by accessing the settings to your internet browser.</p>
            <h5><bold>RESTRICTING THE COLLECTION OF YOUR PERSONAL DATA AND ITS RETENTION TO THE WEBSITE AND SYSTEM</h5>
            <p>At some point, you might wish to restrict the use and collection of your personal data. You can achieve by doing the following:</p>
            <ul>
                <li>When you are filling the forms on the website, make sure to check if there is a box which you can leave unchecked, if you don’t want to disclose your personal information.</li>
                <li>If you have already agreed to share your information with us, feel free to contact us via email and we will be more than happy to change this for you.</li>
            </ul>
            <p>When you are a Registered User, we retain your data as long as you remain a Registered User or, in the case of OVS, as long as before the yearly update and reset of the database of the system.</p>
            <p>The website will not lease, sell or distribute your personal information to any third parties, unless we have your permission. We might do so if the law forces us. Your personal information will be used when we need to send you promotional materials and other notices if you agree to this privacy policy.</p>

    </div>
    </div>
<!--end of Body-->

       
<div class="pt-5 bg-light"></div>

<?php template_footer() ?>

<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/js/bs-init.js"></script>

<!--OWL Carousel-->
<script>
    $(".slider").owlCarousel({
        loop: true,
        autoplay: true,
        autoplayTimeout: 2000, //2000ms = 2s;
        autoplayHoverPause: true,
        margin: 0,
        responsive: {
            0: {
                items: 1
            },
            400: {
                items: 2
            },
            800: {
                items: 3
            },
            1000: {
                items: 4
            }
        }
    })
</script>

<!--Modal-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>

</body>
</html>