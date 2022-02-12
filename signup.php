<?php
require 'functions.php';

$conn = MYSQL_DB_Connection();
$courses = $conn->query("SELECT course, CONCAT(course, ' (', acronym, ')') AS courses FROM tbl_course");

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Sign Up - 1VOTE 4PLMAR</title>

    <!--Logo-->
    <link rel="shortcut icon" type="image/jpg" href="https://ik.imagekit.io/nwlfpk0xpdg/img/tr:w-50,h-50/logo-png_Xt7bTS_7o.png?ik-sdk-version=javascript-1.4.3&updatedAt=1636213481504" />
    
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">


    <!--FontAwesome Kit-->
    <script src="https://kit.fontawesome.com/8acebfc2d4.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <script>
        $(document).ready(function() {
            $('#studnum').keyup(function(e) {
                var x = $('#studnum')[0];
                x.value = x.value.toUpperCase();
            });

            $('#btn_sendOTP').click(function(e) {
                e.preventDefault();
                $('#btn_sendOTP').prop('disabled', true);
                var email = $('#email').val().trim();

                $.ajax({
                    type: "POST",
                    url: "send-otp.php",
                    data: {
                        "email": email,
                    },
                    dataType: "text",
                    success: function(response) {
                        $("#getdetails").html(response);
                    }
                });
            });

            $('#btn_verOTP').click(function(e) {
                e.preventDefault();
                var email = $('#email').val().trim();
                var otp = $('#otp').val().trim();

                $.ajax({
                    type: "POST",
                    url: "verify-otp.php",
                    data: {
                        "email": email,
                        "otp": otp,
                    },
                    dataType: "text",
                    success: function(response) {
                        $("#getConfirmation").html(response);
                    }
                });
            });

            $('#btn_sendOTP').prop('disabled', true);
            $('#v_input_group').prop('hidden', true);

            $('#email').keyup(function() {
                const email = document.querySelector('#email');
                const re = /^([a-zA-Z0-9_\-?\.?]){3,}@([a-zA-Z]){3,}\.([a-zA-Z]){2,5}$/;
                if ($(this).val() != '' && re.test(email.value)) {
                    $('#btn_sendOTP').prop('disabled', false);
                } else {
                    $('#btn_sendOTP').prop('disabled', true);
                }
            });

            $('#email').blur(function() {
                const email = document.querySelector('#email');
                const re = /^([a-zA-Z0-9_\-?\.?]){3,}@([a-zA-Z]){3,}\.([a-zA-Z]){2,5}$/;
                if ($(this).val() != '' && re.test(email.value)) {
                    $('#btn_sendOTP').prop('disabled', false);
                } else {
                    $('#btn_sendOTP').prop('disabled', true);
                }
            });
        });
    </script>
    // On the first line inside BODY tag
    <script type="text/javascript">
        $("body").prepend('<div id="preloader">Loading...</div>');
        $(document).ready(function() {
            $("#preloader").remove();
        });
    </script>
</head>

<body>
    <!--Contacts Section-->
    <nav class="navbar navbar-expand text-white py-2 fixed-top" style="background-color: #000000;">
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
        </div>
    </nav>
    <!--Main navbar-->
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top" style="top:35px;">
        <!-- Container wrapper -->
        <div class="container-fluid" id="main-nav">
            <!-- Navbar brand -->
            <a class="navbar-brand lead mb-0 col col-md-6" href="#"><img src="assets/img/ovslogov2-ns.png" alt="" width="auto" height="40px">PLMAR Online Voting System</a>
            <!-- Toggle button -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-bars"></i></button>
            <!-- Collapsible wrapper -->
            <div class="collapse navbar-collapse" id="navbarText">
                <!-- Left links -->
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active d-flex flex-column text-center" aria-current="page" href="index.php"><i class="fas fa-home text-primary"></i><span class="small">Home</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link d-flex flex-column text-center" aria-current="page" href="index.php#student_org"><i class="fas fa-sitemap text-primary"></i><span class="small">Student Organizations</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link d-flex flex-column text-center" aria-current="page" href="#contacts"><i class="fas fa-envelope text-primary"></i><span class="small">Contacts</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link d-flex flex-column text-center" aria-current="page" href="signup.php"><i class="fas fa-sign-in-alt text-primary"></i><span class="small">Sign Up</span></a>
                    </li>
                </ul>
                <!-- Left links -->
            </div>
            <!-- Collapsible wrapper -->
        </div>
        <!-- Container wrapper -->
    </nav>
    <!-- End Navbar -->

    <!--Sign Up-->

    <section class="reg-section" id="sign-up">
        <div class="container-fluid p-0">
            <div class="row g-0">
                <div class="col-lg-4 text-white order-lg-1 showcase-img" style="background-image:url(&quot;https://ik.imagekit.io/nwlfpk0xpdg/img/vote1_jKcG_OesF.jpg?updatedAt=1636213495093&quot;);"><span></span>
                </div>

                <div class="col-lg-8 my-auto order-lg-2 reg-section-text">

                    <h3 id="form__head" class="mb-4 ">Registration Form</h3>
                    <form id="newform" action="auth.php" method="POST" class="needs-validation" novalidate>

                        <div class="flex-container">
                            <!--Left Column-->
                            <div class="flex-child">
                                <div class="form-group">
                                    <!--Firstname-->
                                    <input type="text" class="form-control" id="fname" name="fname" placeholder="Firstname" required form="newform" />
                                    <div class="invalid-feedback mb-2">Enter a valid First Name.</div>
                                    <div class="valid-feedback mb-2">Looks Good</div>
                                </div>

                                <div class="form-group">
                                    <!--Middlename-->
                                    <input type="text" class="form-control" id="mname" name="mname" placeholder="Middlename" required />
                                    <div class="invalid-feedback mb-2">Enter a valid Middlename.</div>
                                    <div class="valid-feedback mb-2">Looks Good</div>
                                </div>

                                <div class="form-group">
                                    <!--Lastname-->
                                    <input type="text" class="form-control" id="lname" name="lname" placeholder="Lastname" required />
                                    <div class="invalid-feedback mb-2">Enter a valid Lastname.</div>
                                    <div class="valid-feedback mb-2">Looks Good</div>
                                </div>
                            </div>
                            <!--End Left-->

                            <!--Right Column-->
                            <div class="flex-child">
                                <div class="form-group">
                                    <!--Student Number-->

                                    <input type="studnum" class="form-control" id="studnum" name="studnum" maxlength="13" placeholder="PM-XX-XXXXX-X" required />
                                    <div class="invalid-feedback mb-2">Student Number cannot be blank or format is invalid
                                    </div>
                                    <div class="valid-feedback mb-2">Looks Good</div>
                                </div>

                                <div class="form-group">
                                    <!--Course-->
                                    <select class="form-select" id="course" name="course" aria-label="Default select example">
                                        <option value="">--Select Course--</option>
                                        <?php foreach ($courses as $c) : ?>
                                            <option value="<?= $c['course'] ?>"><?= $c['courses'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="invalid-feedback mb-2">You haven't select a course
                                    </div>
                                    <div class="valid-feedback mb-2">Looks Good</div>
                                </div>
                            </div>
                            <!--End Right-->
                        </div>

                        <div style="padding-left: 1em;">
                            <b id="getdetails"></b>
                        </div>

                        <!--Flex container-->
                        <div class="flex-container mt-4">
                            <!--Left Column-->
                            <div class="flex-child col-md-8">
                                <div class="form-group">
                                    <div class="input-group">
                                        <!--Email-->


                                        <input type="email" class="form-control" name="email" id="email" placeholder="plmar@ovs.com" required />
                                        <div class="input-group-append">
                                            <button id="btn_sendOTP" class="btn btn-outline-dark" type="submit"><small>Send
                                                    OTP</small></button>
                                        </div>
                                        <div class="invalid-feedback mb-3">Email cannot be blank. Please Check Mail again.
                                        </div>
                                        <div class="valid-feedback mb-3">
                                            <div class="row">
                                                <div class="col-8">
                                                    Looks Good
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--End Left-->
                            <!--Right Column-->
                            <div class="flex-child col-md-4">
                                <div class="form-group">
                                    <div class="input-group" id=v_input_group hidden>
                                        <input type="text" maxlength="6" class="form-control mb-2" placeholder="" name="otp" id="otp">
                                        <div class="input-group-append">
                                            <button id="btn_verOTP" class="btn btn-outline-dark" type="submit" form="newform"><small>Verify
                                                    OTP</small></button>
                                        </div>
                                    </div>
                                    <div><span id="getConfirmation"></span></div>
                                </div>
                            </div>
                            <!--End Right-->
                        </div>
                        <!--Flex container-->
                        <div class="" style="padding-left: 1em;">
                            <div class="form-check mb-3">
                                <input type="checkbox" class="form-check-input" id="chk_agree" form="newform" required>
                                <label class="form-check-label" for="chk_agree">I agree to terms and conditions</label>
                                <div class="invalid-feedback">You must agree before submitting</div>
                            </div>
                            <button type="submit" class=" mt-4 d-block w-100 btn btn-primary float-end" id="submit">Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>




    <!--End of Sign up-->
    <?php template_footer() ?>

    <!--Modal-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous">
    </script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
    </script>
    <script src="assets/js/registervalidate.js"></script>

</body>

</html>