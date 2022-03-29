<?php
require 'functions.php';

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Home - 1VOTE 4PLMAR</title>

    <!--Logo-->
    <link rel="shortcut icon" type="image/jpg" href="https://ik.imagekit.io/nwlfpk0xpdg/img/ovs_logo_x6ne_tPjZ7.jpg?ik-sdk-version=javascript-1.4.3&updatedAt=1648299575563" />

    <!--Rica: I replace the stylecss into this line-->
    <link rel="stylesheet" href="css/style_index.css">

    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <!--Font-->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,400;0,500;1,300;1,400&display=swap" rel="stylesheet">
    
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

    <!--JQuery Validation PlugIn-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.js"></script>
    <script>
        $(document).ready(function() {
            const msg = document.querySelector('#msg');
            $('#VoterSignIn').on('hidden.bs.modal', function() {
                $(this).find('form').trigger('reset');
                $(msg).html("");
                msg.classList.remove('alert');
                msg.classList.remove('alert-danger');
                $('input[name=email]').removeClass("is-valid").removeClass("is-invalid");
                $('input[name=password]').removeClass("is-valid").removeClass("is-invalid");
            });
            // Validator custom methods
            $.validator.addMethod("validateEmail", function(value, element) {
                const regexEmail = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                return regexEmail.test(value);
            }, "Please enter a valid email address.");

            $('#frmSignIn').validate({
                rules: {
                    email: {
                        required: true,
                        validateEmail: true
                    },
                    password: {
                        required: true,
                    }
                },
                messages: {
                    email: {
                        required: "Please enter your email address",
                    },
                    password: {
                        required: "Please enter your password",
                    }
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass("is-invalid").removeClass("is-valid");
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).addClass("is-valid").removeClass("is-invalid");
                },
                submitHandler: function() {
                    let form = $('#frmSignIn');
                    let actionUrl = form.attr('action');
                    $.ajax({
                        type: "POST",
                        url: actionUrl,
                        dataType: "JSON",
                        data: form.serialize(), // serializes the form's elements.
                        success: function(resp) {
                            if (resp.feedback == 'authenticated') {
                                window.location.href = resp.action;
                            } else {
                                msg.classList.add('alert');
                                msg.classList.add('alert-danger');
                                msg.setAttribute('role', 'alert');
                                $(msg).html(`<i class="fa fa-times-circle fs-4 me-3"></i><small>${resp.action}</small>`);
                                $('input[name=email]').addClass("is-invalid").removeClass("is-valid");
                                $('input[name=password]').addClass("is-invalid").removeClass("is-valid");
                            }
                        }
                    });
                }
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
                    <small><a href="#footer" style="color: white;">Contact Us</a></small>
                </li>
                <li class="list-inline-item"></li><a style="color:#ffffff" target="_blank" href="mailto:educpurponly101@gmail.com"><i class="fa fa-envelope"></i></a>
                <li class="list-inline-item"></li><a style="color:#ffffff" target="_blank" href="https://www.facebook.com/cpaips/"><i class="fa fa-facebook"></i></a>
                </li>
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
                        <div id="msg"></div>
                        <div class="form-group mb-3">
                            <!--Rica: I add label for screen readers--> <label for="email">Email Address</label>
                            <input class="form-control validate" style="font-family:FontAwesome;" type="email" name="email" placeholder="&#xf007; Email Address" required="required">
                        </div>
                        <div class="form-group mb-3">
                            <!--Rica: I add label for screen readers--> <label for="email">Password</label>
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


    <!--Carousel Section-->
    <section id="carousel">
        <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="https://ik.imagekit.io/nwlfpk0xpdg/img/banner_1_QybUmOUm7.png?ik-sdk-version=javascript-1.4.3&updatedAt=1648354283887" class="d-block w-100">
                </div>
                <div class="carousel-item">
                    <img src="https://ik.imagekit.io/nwlfpk0xpdg/img/banner_2_WOeYYBCIz.png?ik-sdk-version=javascript-1.4.3&updatedAt=1648354280039" class="d-block w-100">
                </div>
                <div class="carousel-item">
                    <img src="https://ik.imagekit.io/nwlfpk0xpdg/img/banner_3_VJ6atg3yY.png?ik-sdk-version=javascript-1.4.3&updatedAt=1648354286611" class="d-block w-100">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </section>
    <!--End of Carousel Section-->

    <!--Hero OVS-->
    <section id="hero" class=" features-icons">
        <div class="container">
            <div class="row mb-5">
                <div class="col-md-4" id="hero_text">
                    <h1 id="hero_header">Voting made easy & secure!</h1>
                    <p> The platform that provide quality assurance and equitable balance among the administration, candidates, and voters.</p>
                    <button id="register_button">Register to VOTE!</button>
                </div>
                <div class="col-md-8">
                    <img src="https://ik.imagekit.io/nwlfpk0xpdg/img/hero_c3vLzDFbO.jpg?ik-sdk-version=javascript-1.4.3&updatedAt=1648298535312" class="img-fluid">
                </div>
            </div>
        </div>
    </section>
    <!--End Hero OVS-->

    <!--Feature SAE-->

    <div id="sae">
        <img id="sae_img" data-bss-hover-animate="pulse"" src=" https://ik.imagekit.io/nwlfpk0xpdg/img/1_secure_0b-W7PNTY.png?ik-sdk-version=javascript-1.4.3&updatedAt=1648321343518" alt="">
        <img id="sae_img" data-bss-hover-animate="pulse"" src=" https://ik.imagekit.io/nwlfpk0xpdg/img/3_accessible_4GyWFYO15.png?ik-sdk-version=javascript-1.4.3&updatedAt=1648321343835" alt="">
        <img id="sae_img" data-bss-hover-animate="pulse"" src=" https://ik.imagekit.io/nwlfpk0xpdg/img/2_easy_jBLOAIEDq.png?ik-sdk-version=javascript-1.4.3&updatedAt=1648321343706" alt="">
    </div>

    <div id="student_org" style="background-color: #f8f9fa;"><br></div>

    <!--Student Org Card Carousel-->
    <section id="studorg" class="bg-light">
        <div class="container">
            <h2 class=" mb-5 text-center ">Meet your Student Organizations</h2>
        </div>
        <div id="owl" class="text-center container">
            <div class="slider owl-carousel" id="org-carousel">
                <div class="card">
                    <div class="img"><img src="https://ik.imagekit.io/nwlfpk0xpdg/img/1.SO-csg_Tm4hxyw-N.png?updatedAt=1636213448254" alt="CSG"></div>
                    <div class="content">
                        <div class="title">CSG</div>
                    </div>
                    <div class="btn"><a id="button_yellow" class="btn" target="_blank" href="https://sites.google.com/view/plmar-student-organization/math/central-student-government-csg?authuser=0" role="button">Read more</a></div>
                </div>
                <div class="card">
                    <div class="img"><img src="https://ik.imagekit.io/nwlfpk0xpdg/img/2.SO-educ_qxPZF1Z-Z.png?updatedAt=1636213459182" alt="EDUCADA"></div>
                    <div class="content">
                        <div class="title">EDUCADA</div>
                        <div class="sub-title"></div>
                    </div>
                    <div class="btn"><a id="button_yellow" class="btn" target="_blank" href="https://sites.google.com/view/plmar-student-organization/math/education-confederation-of-adept-devotees-of-the-academe-educada?authuser=0" role="button">Read More</a></div>
                </div>
                <div class="card">
                    <div class="img"><img src="https://ik.imagekit.io/nwlfpk0xpdg/img/3.SO-dam_gh4cHwasC.png?updatedAt=1636213461446" alt="DAMLAY "></div>
                    <div class="content">
                        <div class="title">DAMLAY</div>
                        <div class="sub-title"></div>
                        <p class="lead mb-0">

                        </p>
                    </div>
                    <div class="btn"><a id="button_yellow" class="btn" target="_blank" href="https://sites.google.com/view/plmar-student-organization/math/damdamin-at-malay-damlay-filipino-major?authuser=0" role="button">Read More</a></div>
                </div>
                <div class="card">
                    <div class="img"><img src="https://ik.imagekit.io/nwlfpk0xpdg/img/4.SO-Englisc_dkZeeBF9F.png?updatedAt=1636213463011" alt="ENGLISC"></div>
                    <div class="content">
                        <div class="title">ENGLISC</div>
                        <div class="sub-title"></div>
                        <p class="lead mb-0">

                        </p>
                    </div>
                    <div class="btn"><a id="button_yellow" class="btn" target="_blank" href="https://sites.google.com/view/plmar-student-organization/math/englisc-english-major?authuser=0" role="button">Read More</a></div>
                </div>
                <div class="card">
                    <div class="img"><img src="https://ik.imagekit.io/nwlfpk0xpdg/img/5.SO-elem_jVjTZzmLr.png?updatedAt=1636213463225" alt="ELEMENTUM"></div>
                    <div class="content">
                        <div class="title">ELEMENTUM</div>
                        <div class="sub-title"></div>
                        <p class="lead mb-0">

                        </p>
                    </div>
                    <div class="btn"><a id="button_yellow" class="btn" target="_blank" href="https://sites.google.com/view/plmar-student-organization/math/elementum-mathematics-society?authuser=0" role="button">Read More</a></div>
                </div>
                <div class="card">
                    <div class="img"><img src="https://ik.imagekit.io/nwlfpk0xpdg/img/6.SO-ILLUS_qcRhsb3FC.png?updatedAt=1636213464652" alt="ILLUS"></div>
                    <div class="content">
                        <div class="title">ILUSTRADOS</div>
                        <div class="sub-title"></div>
                        <p class="lead mb-0">

                        </p>
                    </div>
                    <div class="btn"><a id="button_yellow" class="btn" target="_blank" href="https://sites.google.com/view/plmar-student-organization/math/intellectual-leaders-uniting-students-through-rational-alliance-dignifi?authuser=0" role="button">Read More</a></div>
                </div>
                <div class="card">
                    <div class="img"><img src="https://ik.imagekit.io/nwlfpk0xpdg/img/7.SO-deps_DOBr3oW_S.png?updatedAt=1636213466086" alt="DEPS"></div>
                    <div class="content">
                        <div class="title">DEPS</div>
                        <div class="sub-title"></div>
                        <p class="lead mb-0">

                        </p>
                    </div>
                    <div class="btn"><a id="button_yellow" class="btn" target="_blank" href="https://sites.google.com/view/plmar-student-organization/math/designed-to-educate-people-with-special-needs-deps?authuser=0" role="button">Read More</a></div>
                </div>
                <div class="card">
                    <div class="img"><img src="https://ik.imagekit.io/nwlfpk0xpdg/img/8.SO-paracs_Sp-COgRLdtK.png?updatedAt=1636213479051" alt="PARACS"></div>
                    <div class="content">
                        <div class="title">PARACS</div>
                        <div class="sub-title"></div>
                        <p class="lead mb-0">

                        </p>
                    </div>
                    <div class="btn"><a id="button_yellow" class="btn" target="_blank" href="https://sites.google.com/view/plmar-student-organization/math/peaceful-and-responsible-alliance-of-criminology-paracs?authuser=0" role="button">Read More</a></div>
                </div>
                <div class="card">
                    <div class="img"><img src="https://ik.imagekit.io/nwlfpk0xpdg/img/9.SO-pasa_93RbUXDzl.png?updatedAt=1636213485270" alt="PASA"></div>
                    <div class="content">
                        <div class="title">PASA</div>
                        <div class="sub-title"></div>
                        <p class="lead mb-0">

                        </p>
                    </div>
                    <div class="btn"><a id="button_yellow" class="btn" target="_blank" href="https://sites.google.com/view/plmar-student-organization/math/public-administraion-students-association-pasa?authuser=0" role="button">Read More</a></div>
                </div>
                <div class="card">
                    <div class="img"><img src="https://ik.imagekit.io/nwlfpk0xpdg/img/10.SO-sms_h2EDWdWZ-.png?updatedAt=1636213448348" alt="SMS"></div>
                    <div class="content">
                        <div class="title">SMS</div>
                        <div class="sub-title"></div>
                        <p class="lead mb-0">

                        </p>
                    </div>
                    <div class="btn"><a id="button_yellow" class="btn" target="_blank" href="https://sites.google.com/view/plmar-student-organization/math/society-of-mass-communication-students-sms?authuser=0" role="button">Read More</a></div>
                </div>
                <div class="card">
                    <div class="img"><img src="https://ik.imagekit.io/nwlfpk0xpdg/img/11.SO-psy_9j2DsDkj5ja.png?updatedAt=1636213449205" alt="PSYSOC"></div>
                    <div class="content">
                        <div class="title">PSYSOC</div>
                        <div class="sub-title"></div>
                        <p class="lead mb-0">

                        </p>
                    </div>
                    <div class="btn"><a id="button_yellow" class="btn" target="_blank" href="https://sites.google.com/view/plmar-student-organization/math/psychology-and-social-work-society-psysoc?authuser=0" role="button">Read More</a></div>
                </div>
                <div class="card">
                    <div class="img"><img src="https://ik.imagekit.io/nwlfpk0xpdg/img/12.SO-pe_7mTTOebSW.png?updatedAt=1636213450665" alt="PESA"></div>
                    <div class="content">
                        <div class="title">PESA</div>
                        <div class="sub-title"></div>
                        <p class="lead mb-0">
                        </p>
                    </div>
                    <div class="btn"><a id="button_yellow" class="btn" target="_blank" href="https://sites.google.com/view/plmar-student-organization/math/physical-education-students-association-pesa?authuser=0" role="button">Read More</a></div>
                </div>
                <div class="card">
                    <div class="img"><img src="https://ik.imagekit.io/nwlfpk0xpdg/img/13.SO-hcc_WnxRYVHAo.png?updatedAt=1636213451592" alt="HCS"></div>
                    <div class="content">
                        <div class="title">HCS</div>
                        <div class="sub-title"></div>
                        <p class="lead mb-0">

                        </p>
                    </div>
                    <div class="btn"><a id="button_yellow" class="btn" target="_blank" href="https://sites.google.com/view/plmar-student-organization/math/health-care-society-hcs?authuser=0" role="button">Read More</a></div>
                </div>
                <div class="card">
                    <div class="img"><img src="https://ik.imagekit.io/nwlfpk0xpdg/img/14.SO-hr_IVWHZ9I6RrN.png?updatedAt=1636213451940" alt="HRSS"></div>
                    <div class="content">
                        <div class="title">HRSS</div>
                        <div class="sub-title"></div>
                        <p class="lead mb-0">

                        </p>
                    </div>
                    <div class="btn"><a id="button_yellow" class="btn" target="_blank" href="https://sites.google.com/view/plmar-student-organization/math/human-rescources-student-society-hrss?authuser=0" role="button">Read More</a></div>
                </div>
                <div class="card">
                    <div class="img"><img src="https://ik.imagekit.io/nwlfpk0xpdg/img/15.SO-jems_aKbwOCYR4.png?updatedAt=1636213453231" alt="JEMS"></div>
                    <div class="content">
                        <div class="title">JEMS</div>
                        <div class="sub-title"></div>
                        <p class="lead mb-0">

                        </p>
                    </div>
                    <div class="btn"><a id="button_yellow" class="btn" target="_blank" href="https://sites.google.com/view/plmar-student-organization/math/junior-entrepreneurial-management-society-jems?authuser=0" role="button">Read More</a></div>
                </div>
                <div class="card">
                    <div class="img"><img src="https://ik.imagekit.io/nwlfpk0xpdg/img/16.SO-jfnex_ovfP1bw3E.png?updatedAt=1636213455854" alt="JFNEX"></div>
                    <div class="content">
                        <div class="title">JFNEX</div>
                        <div class="sub-title"></div>
                        <p class="lead mb-0">

                        </p>
                    </div>
                    <div class="btn"><a id="button_yellow" class="btn" target="_blank" href="https://sites.google.com/view/plmar-student-organization/math/junior-finance-executive-jfnex?authuser=0" role="button">Read More</a></div>
                </div>
                <div class="card">
                    <div class="img"><img src="https://ik.imagekit.io/nwlfpk0xpdg/img/17.SO-jmma_nCRG3s06R.png?updatedAt=1636213455755" alt="JMMA"></div>
                    <div class="content">
                        <div class="title">JMMA</div>
                        <div class="sub-title"></div>
                        <p class="lead mb-0">

                        </p>
                    </div>
                    <div class="btn"><a id="button_yellow" class="btn" target="_blank" href="https://sites.google.com/view/plmar-student-organization/math/junior-marketing-management-association-jmma?authuser=0" role="button">Read More</a></div>
                </div>
                <div class="card">
                    <div class="img"><img src="https://ik.imagekit.io/nwlfpk0xpdg/img/18.SO-jpia_je6cvoTjd.png?updatedAt=1636213455791" alt="JPIA"></div>
                    <div class="content">
                        <div class="title">JPIA</div>
                        <div class="sub-title"></div>
                        <p class="lead mb-0">

                        </p>
                    </div>
                    <div class="btn"><a id="button_yellow" class="btn" target="_blank" href="https://sites.google.com/view/plmar-student-organization/math/junior-philippine-institute-of-accountants-jpia?authuser=0" role="button">Read More</a></div>
                </div>
                <div class="card">
                    <div class="img"><img src="https://ik.imagekit.io/nwlfpk0xpdg/img/19-SO-horems_zIMssQt78.png?updatedAt=1636213457579" alt="HOREMS"></div>
                    <div class="content">
                        <div class="title">HOREMS</div>
                        <div class="sub-title"></div>
                        <p class="lead mb-0">

                        </p>
                    </div>
                    <div class="btn"><a id="button_yellow" class="btn" target="_blank" href="https://sites.google.com/view/plmar-student-organization/math/hotel-and-restaurant-management-society-horems?authuser=0" role="button">Read More</a></div>
                </div>
                <div class="card">
                    <div class="img"><img src="https://ik.imagekit.io/nwlfpk0xpdg/img/20.SO-tss_CsB4Wps0V5d.png?updatedAt=1636213460292" alt="TSS"></div>
                    <div class="content">
                        <div class="title">TSS</div>
                        <div class="sub-title"></div>
                        <p class="lead mb-0">
                        </p>
                    </div>
                    <div class="btn"><a id="button_yellow" class="btn " target="_blank" href="https://sites.google.com/view/plmar-student-organization/math/tourism-student-society-tss?authuser=0" role="button">Read More</a></div>
                </div>
                <div class="card">
                    <div class="img"><img src="https://ik.imagekit.io/nwlfpk0xpdg/img/21.SO-sits_B4Ya0vMqL.png?updatedAt=1636213460899" alt="SITS"></div>
                    <div class="content">
                        <div class="title">SITS</div>
                        <div class="sub-title"></div>
                        <p class="lead mb-0">
                        </p>
                    </div>
                    <div class="btn"><a id="button_yellow" class="btn " target="_blank" href="https://sites.google.com/view/plmar-student-organization/math/society-of-information-technology-students-sits?authuser=0" role="button">Read More</a></div>
                </div>
            </div>
        </div>
    </section>
    <!--End of Student Org Card Carousel-->

    <div id="hiw">
        <div class="container text-center">
            <h2>Steps on How OVS Works <br>VOTER SIDE</h2>
            <img src="https://ik.imagekit.io/nwlfpk0xpdg/img/hiw_B6O27prQc?ik-sdk-version=javascript-1.4.3&updatedAt=1648359020679" alt="">
        </div>
    </div>



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