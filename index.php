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
    <link rel="shortcut icon" type="image/jpg" href="https://ik.imagekit.io/nwlfpk0xpdg/img/tr:w-50,h-50/logo-png_Xt7bTS_7o.png?ik-sdk-version=javascript-1.4.3&updatedAt=1636213481504" />
    
    <link rel="stylesheet" href="assets/bootstrap/css/style.css">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic">
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
    <nav class="navbar navbar-expand text-white py-0 " style="background-color: #000000;">
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
                <li class="nav-item">
                    <a class="nav-link text-white" href="#VoterSignIn" data-bs-toggle="modal"><i class="fas fa-user-lock me-1"></i><small>Voter Portal</small></a>
                </li>
            </ul>
        </div>
    </nav>

    <!--Main navbar-->
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top">
        <!-- Container wrapper -->
        <div class="container-fluid" id="main-nav">

            <!-- Navbar brand -->
            <a class="navbar-brand mb-0 text-wrap" href="#"><img src="https://ik.imagekit.io/nwlfpk0xpdg/img/tr:w-50,h-50/logo-png_Xt7bTS_7o.png?updatedAt=1636213481504" alt="">PLMAR Online Voting System</a>
            <!-- Toggle button -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
            </button>
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
                            <input class="form-control validate" style="font-family:FontAwesome;" type="email" name="email" placeholder="&#xf007; Email Address" required="required">
                        </div>
                        <div class="form-group mb-3">
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
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="3" aria-label="Slide 4"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="4" aria-label="Slide 5"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="5" aria-label="Slide 6"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="https://ik.imagekit.io/nwlfpk0xpdg/img/ban1_0vPuAntvgY0.png?updatedAt=1636213471265" class="d-block w-100" alt="OVS">
                </div>
                <div class="carousel-item">
                    <img src="https://ik.imagekit.io/nwlfpk0xpdg/img/ban2_e_Ekr_PDi.png?updatedAt=1636213520225" class="d-block w-100" alt="1PagAsa4PLMAR">
                </div>
                <div class="carousel-item">
                    <img src="https://ik.imagekit.io/nwlfpk0xpdg/img/ban3_dzkBFHtns.png?updatedAt=1636213521865" class="d-block w-100" alt="oath taking">
                </div>
                <div class="carousel-item">
                    <img src="https://ik.imagekit.io/nwlfpk0xpdg/img/ban4_SavPMPzXl.png?updatedAt=1636213484443" class="d-block w-100" alt="red liberty">
                </div>
                <div class="carousel-item">
                    <img src="https://ik.imagekit.io/nwlfpk0xpdg/img/ban5_fFHS1hAYmEn.png?updatedAt=1636213482696" class="d-block w-100" alt="vote hands">
                </div>
                <div class="carousel-item">
                    <img src="https://ik.imagekit.io/nwlfpk0xpdg/img/ban6_98s6oTH0Nd.png?updatedAt=1636213481297" class="d-block w-100" alt="voter superpower">
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
    <!--About OVS-->
    <section class="bg-light features-icons">
        <div class="container">
            <h2>PLMAR Online Voting System for College Student Organization</h2>
            <div class="row mb-5">
                <div class="col-md-9">
                    <p class="lead mb-0">The Pamantasan ng Lungsod ng Marikina Online Voting System (PLMar OVS) is an online web-based software platform that allows the institution to conduct an easy and secured election for Student Organization. OVS advertise the transition of traditional to advance technical standards. The platform aims to provide quality assurance and equitable balance among the administration, candidates, and voters.</p>
                </div>
                <div class="col-md-3">
                    <img src="https://ik.imagekit.io/nwlfpk0xpdg/img/logo-png_Xt7bTS_7o.png?updatedAt=1636213481504" alt="ovs logo" class="img-fluid">
                </div>
            </div>

            <!--Our Work Section-->
            <section id="work">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 text-center text-danger">
                            <h3 class="fs-1">Go Vote!</h3>
                        </div>
                        <div class="col-md-6 text-center mx-auto text-danger">
                            <i class="fas fa-vote-yea fa-5x"></i>
                        </div>
                    </div>
                </div>
            </section>
            <!--End of Our Work Section-->

            <div class="row text-center features-icons">
                <div class="col-lg-4">
                    <div class="mx-auto features-icons-item mb-5 mb-lg-0 mb-lg-3">
                        <div class="d-flex features-icons-icon"><i class="far fa-thumbs-up m-auto text-primary" data-bss-hover-animate="pulse"></i></div>
                        <h3>Easy</h3>
                        <p class="lead mb-0">This theme will look great on any device, no matter the size!</p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="mx-auto features-icons-item mb-5 mb-lg-0 mb-lg-3">
                        <div class="d-flex features-icons-icon"><i class="fas fa-user-shield m-auto text-primary" data-bss-hover-animate="pulse"></i></div>
                        <h3>Safe</h3>
                        <p class="lead mb-0">Ready to use with your own content, or customize the source files!</p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="mx-auto features-icons-item mb-5 mb-lg-0 mb-lg-3">
                        <div class="d-flex features-icons-icon"><i class="fas fa-globe m-auto text-primary" data-bss-hover-animate="pulse"></i></div>
                        <h3>Accessible</h3>
                        <p class="lead mb-0">Featuring the latest build of the new Bootstrap 4 framework!</p>
                    </div>
                </div>
                <div id="student_org"></div>
                <!--used to solve the sticky top blocking-->
            </div>
        </div>


    </section>


    <!--Student Org Card Carousel-->
    <section class="bg-light">
        <div class="container">
            <h2 class="mb-2">Student Organizations</h2>
        </div>
        <div id="owl" class="text-center container ">
            <div class="slider owl-carousel" id="org-carousel">
                <div class="card">
                    <div class="img"><img src="https://ik.imagekit.io/nwlfpk0xpdg/img/1.SO-csg_Tm4hxyw-N.png?updatedAt=1636213448254" alt="CSG"></div>
                    <div class="content">
                        <div class="title">CSG</div>
                        <div class="sub-title">
                            <p class="lead mb-0">Central Student Government</p>
                        </div>
                    </div>
                    <div class="btn"><a class="btn btn-primary" target="_blank" href="https://sites.google.com/view/plmar-student-organization/math/central-student-government-csg?authuser=0" role="button">Read More</a></div>
                </div>
                <div class="card">
                    <div class="img"><img src="https://ik.imagekit.io/nwlfpk0xpdg/img/2.SO-educ_qxPZF1Z-Z.png?updatedAt=1636213459182" alt="EDUCADA"></div>
                    <div class="content">
                        <div class="title">EDUCADA</div>
                        <div class="sub-title"></div>
                        <p class="lead mb-0">Education Confederation of Adept Devotees of the Academe</p>
                    </div>
                    <div class="btn"><a class="btn btn-primary" target="_blank" href="https://sites.google.com/view/plmar-student-organization/math/education-confederation-of-adept-devotees-of-the-academe-educada?authuser=0" role="button">Read More</a></div>
                </div>
                <div class="card">
                    <div class="img"><img src="https://ik.imagekit.io/nwlfpk0xpdg/img/3.SO-dam_gh4cHwasC.png?updatedAt=1636213461446" alt="DAMLAY "></div>
                    <div class="content">
                        <div class="title">DAMLAY</div>
                        <div class="sub-title"></div>
                        <p class="lead mb-0">DAMDAMIN AT MALAY</p>
                    </div>
                    <div class="btn"><a class="btn btn-primary" target="_blank" href="https://sites.google.com/view/plmar-student-organization/math/damdamin-at-malay-damlay-filipino-major?authuser=0" role="button">Read More</a></div>
                </div>
                <div class="card">
                    <div class="img"><img src="https://ik.imagekit.io/nwlfpk0xpdg/img/4.SO-Englisc_dkZeeBF9F.png?updatedAt=1636213463011" alt="ENGLISC"></div>
                    <div class="content">
                        <div class="title">ENGLISC</div>
                        <div class="sub-title"></div>
                        <p class="lead mb-0">ENGLISC- ENGLISH MAJOR</p>
                    </div>
                    <div class="btn"><a class="btn btn-primary" target="_blank" href="https://sites.google.com/view/plmar-student-organization/math/englisc-english-major?authuser=0" role="button">Read More</a></div>
                </div>
                <div class="card">
                    <div class="img"><img src="https://ik.imagekit.io/nwlfpk0xpdg/img/5.SO-elem_jVjTZzmLr.png?updatedAt=1636213463225" alt="ELEMENTUM"></div>
                    <div class="content">
                        <div class="title">ELEMENTUM</div>
                        <div class="sub-title"></div>
                        <p class="lead mb-0">ELEMENTUM- MATHEMATICS SOCIETY</p>
                    </div>
                    <div class="btn"><a class="btn btn-primary" target="_blank" href="https://sites.google.com/view/plmar-student-organization/math/elementum-mathematics-society?authuser=0" role="button">Read More</a></div>
                </div>
                <div class="card">
                    <div class="img"><img src="https://ik.imagekit.io/nwlfpk0xpdg/img/6.SO-ILLUS_qcRhsb3FC.png?updatedAt=1636213464652" alt="ILLUS"></div>
                    <div class="content">
                        <div class="title">ILLUS</div>
                        <div class="sub-title"></div>
                        <p class="lead mb-0">INTELLECTUAL LEADERS UNITING STUDENTS THROUGH RATIONAL ALLIANCE DIGNIFIED AND ORGANIZED SOCIETY</p>
                    </div>
                    <div class="btn"><a class="btn btn-primary" target="_blank" href="https://sites.google.com/view/plmar-student-organization/math/intellectual-leaders-uniting-students-through-rational-alliance-dignifi?authuser=0" role="button">Read More</a></div>
                </div>
                <div class="card">
                    <div class="img"><img src="https://ik.imagekit.io/nwlfpk0xpdg/img/7.SO-deps_DOBr3oW_S.png?updatedAt=1636213466086" alt="DEPS"></div>
                    <div class="content">
                        <div class="title">DEPS</div>
                        <div class="sub-title"></div>
                        <p class="lead mb-0">DESIGNED TO EDUCATE PEOPLE WITH SPECIAL NEEDS</p>
                    </div>
                    <div class="btn"><a class="btn btn-primary" target="_blank" href="https://sites.google.com/view/plmar-student-organization/math/designed-to-educate-people-with-special-needs-deps?authuser=0" role="button">Read More</a></div>
                </div>
                <div class="card">
                    <div class="img"><img src="https://ik.imagekit.io/nwlfpk0xpdg/img/8.SO-paracs_Sp-COgRLdtK.png?updatedAt=1636213479051" alt="PARACS"></div>
                    <div class="content">
                        <div class="title">PARACS</div>
                        <div class="sub-title"></div>
                        <p class="lead mb-0">PEACEFUL AND RESPONSIBLE ALLIANCE OF CRIMINOLOGY</p>
                    </div>
                    <div class="btn"><a class="btn btn-primary" target="_blank" href="https://sites.google.com/view/plmar-student-organization/math/peaceful-and-responsible-alliance-of-criminology-paracs?authuser=0" role="button">Read More</a></div>
                </div>
                <div class="card">
                    <div class="img"><img src="https://ik.imagekit.io/nwlfpk0xpdg/img/9.SO-pasa_93RbUXDzl.png?updatedAt=1636213485270" alt="PASA"></div>
                    <div class="content">
                        <div class="title">PASA</div>
                        <div class="sub-title"></div>
                        <p class="lead mb-0">PUBLIC ADMINISTRAION STUDENT’S ASSOCIATION</p>
                    </div>
                    <div class="btn"><a class="btn btn-primary" target="_blank" href="https://sites.google.com/view/plmar-student-organization/math/public-administraion-students-association-pasa?authuser=0" role="button">Read More</a></div>
                </div>
                <div class="card">
                    <div class="img"><img src="https://ik.imagekit.io/nwlfpk0xpdg/img/10.SO-sms_h2EDWdWZ-.png?updatedAt=1636213448348" alt="SMS"></div>
                    <div class="content">
                        <div class="title">SMS</div>
                        <div class="sub-title"></div>
                        <p class="lead mb-0">SOCIETY OF MASS COMMUNICATION STUDENTS</p>
                    </div>
                    <div class="btn"><a class="btn btn-primary" target="_blank" href="https://sites.google.com/view/plmar-student-organization/math/society-of-mass-communication-students-sms?authuser=0" role="button">Read More</a></div>
                </div>
                <div class="card">
                    <div class="img"><img src="https://ik.imagekit.io/nwlfpk0xpdg/img/11.SO-psy_9j2DsDkj5ja.png?updatedAt=1636213449205" alt="PSYSOC"></div>
                    <div class="content">
                        <div class="title">PSYSOC</div>
                        <div class="sub-title"></div>
                        <p class="lead mb-0">PSYCHOLOGY AND SOCIAL WORK SOCIETY </p>
                    </div>
                    <div class="btn"><a class="btn btn-primary" target="_blank" href="https://sites.google.com/view/plmar-student-organization/math/psychology-and-social-work-society-psysoc?authuser=0" role="button">Read More</a></div>
                </div>
                <div class="card">
                    <div class="img"><img src="https://ik.imagekit.io/nwlfpk0xpdg/img/12.SO-pe_7mTTOebSW.png?updatedAt=1636213450665" alt="PESA"></div>
                    <div class="content">
                        <div class="title">PESA</div>
                        <div class="sub-title"></div>
                        <p class="lead mb-0">PHYSICAL EDUCATION STUDENTS ASSOCIATION</p>
                    </div>
                    <div class="btn"><a class="btn btn-primary" target="_blank" href="https://sites.google.com/view/plmar-student-organization/math/physical-education-students-association-pesa?authuser=0" role="button">Read More</a></div>
                </div>
                <div class="card">
                    <div class="img"><img src="https://ik.imagekit.io/nwlfpk0xpdg/img/13.SO-hcc_WnxRYVHAo.png?updatedAt=1636213451592" alt="HCS"></div>
                    <div class="content">
                        <div class="title">HCS</div>
                        <div class="sub-title"></div>
                        <p class="lead mb-0">HEALTH CARE SOCIETY</p>
                    </div>
                    <div class="btn"><a class="btn btn-primary" target="_blank" href="https://sites.google.com/view/plmar-student-organization/math/health-care-society-hcs?authuser=0" role="button">Read More</a></div>
                </div>
                <div class="card">
                    <div class="img"><img src="https://ik.imagekit.io/nwlfpk0xpdg/img/14.SO-hr_IVWHZ9I6RrN.png?updatedAt=1636213451940" alt="HRSS"></div>
                    <div class="content">
                        <div class="title">HRSS</div>
                        <div class="sub-title"></div>
                        <p class="lead mb-0">HUMAN RESCOURCES STUDENT SOCIETY </p>
                    </div>
                    <div class="btn"><a class="btn btn-primary" target="_blank" href="https://sites.google.com/view/plmar-student-organization/math/human-rescources-student-society-hrss?authuser=0" role="button">Read More</a></div>
                </div>
                <div class="card">
                    <div class="img"><img src="https://ik.imagekit.io/nwlfpk0xpdg/img/15.SO-jems_aKbwOCYR4.png?updatedAt=1636213453231" alt="JEMS"></div>
                    <div class="content">
                        <div class="title">JEMS</div>
                        <div class="sub-title"></div>
                        <p class="lead mb-0">JUNIOR ENTREPRENEURIAL MANAGEMENT SOCIETY</p>
                    </div>
                    <div class="btn"><a class="btn btn-primary" target="_blank" href="https://sites.google.com/view/plmar-student-organization/math/junior-entrepreneurial-management-society-jems?authuser=0" role="button">Read More</a></div>
                </div>
                <div class="card">
                    <div class="img"><img src="https://ik.imagekit.io/nwlfpk0xpdg/img/16.SO-jfnex_ovfP1bw3E.png?updatedAt=1636213455854" alt="JFNEX"></div>
                    <div class="content">
                        <div class="title">JFNEX</div>
                        <div class="sub-title"></div>
                        <p class="lead mb-0">JUNIOR FINANCE EXECUTIVE</p>
                    </div>
                    <div class="btn"><a class="btn btn-primary" target="_blank" href="https://sites.google.com/view/plmar-student-organization/math/junior-finance-executive-jfnex?authuser=0" role="button">Read More</a></div>
                </div>
                <div class="card">
                    <div class="img"><img src="https://ik.imagekit.io/nwlfpk0xpdg/img/17.SO-jmma_nCRG3s06R.png?updatedAt=1636213455755" alt="JMMA"></div>
                    <div class="content">
                        <div class="title">JMMA</div>
                        <div class="sub-title"></div>
                        <p class="lead mb-0">JUNIOR MARKETING MANAGEMENT ASSOCIATION</p>
                    </div>
                    <div class="btn"><a class="btn btn-primary" target="_blank" href="https://sites.google.com/view/plmar-student-organization/math/junior-marketing-management-association-jmma?authuser=0" role="button">Read More</a></div>
                </div>
                <div class="card">
                    <div class="img"><img src="https://ik.imagekit.io/nwlfpk0xpdg/img/18.SO-jpia_je6cvoTjd.png?updatedAt=1636213455791" alt="JPIA"></div>
                    <div class="content">
                        <div class="title">JPIA</div>
                        <div class="sub-title"></div>
                        <p class="lead mb-0">JUNIOR PHILIPPINE INSTITUTE OF ACCOUNTANTS</p>
                    </div>
                    <div class="btn"><a class="btn btn-primary" target="_blank" href="https://sites.google.com/view/plmar-student-organization/math/junior-philippine-institute-of-accountants-jpia?authuser=0" role="button">Read More</a></div>
                </div>
                <div class="card">
                    <div class="img"><img src="https://ik.imagekit.io/nwlfpk0xpdg/img/19-SO-horems_zIMssQt78.png?updatedAt=1636213457579" alt="HOREMS"></div>
                    <div class="content">
                        <div class="title">HOREMS</div>
                        <div class="sub-title"></div>
                        <p class="lead mb-0">HOTEL AND RESTAURANT MANAGEMENT SOCIETY</p>
                    </div>
                    <div class="btn"><a class="btn btn-primary" target="_blank" href="https://sites.google.com/view/plmar-student-organization/math/hotel-and-restaurant-management-society-horems?authuser=0" role="button">Read More</a></div>
                </div>
                <div class="card">
                    <div class="img"><img src="https://ik.imagekit.io/nwlfpk0xpdg/img/20.SO-tss_CsB4Wps0V5d.png?updatedAt=1636213460292" alt="TSS"></div>
                    <div class="content">
                        <div class="title">TSS</div>
                        <div class="sub-title"></div>
                        <p class="lead mb-0">TOURISM STUDENT SOCIETY </p>
                    </div>
                    <div class="btn"><a class="btn btn-primary" target="_blank" href="https://sites.google.com/view/plmar-student-organization/math/tourism-student-society-tss?authuser=0" role="button">Read More</a></div>
                </div>
                <div class="card">
                    <div class="img"><img src="https://ik.imagekit.io/nwlfpk0xpdg/img/21.SO-sits_B4Ya0vMqL.png?updatedAt=1636213460899" alt="SITS"></div>
                    <div class="content">
                        <div class="title">SITS</div>
                        <div class="sub-title"></div>
                        <p class="lead mb-0">SOCIETY OF INFORMATION TECHNOLOGY STUDENTS </p>
                    </div>
                    <div class="btn"><a class="btn btn-primary" target="_blank" href="https://sites.google.com/view/plmar-student-organization/math/society-of-information-technology-students-sits?authuser=0" role="button">Read More</a></div>
                </div>
                <script>
                    $(document).ready(function() {
                        $(".card").mouseenter(function() {
                            $(this).children().slideDown();
                        });
                        $(".card").mouseleave(function() {
                            $(this).children(".content").slideUp();
                        });
                        $(".card").click(function() {
                            $(this).children(".content").slideDown();
                        });

                        $(".content").slideUp();
                    });
                </script>
            </div>
        </div>
    </section>
    <!--End of Student Org Card Carousel-->

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