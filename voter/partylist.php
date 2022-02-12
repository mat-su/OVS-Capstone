<?php
session_start();
include '../functions.php';
$conn = MYSQL_DB_Connection();
if (isset($_SESSION['v_id']) && isset($_SESSION['v_email']) && isset($_SESSION['org_id']) && isset($_SESSION['org_name'])) {

    $_SESSION['dashboard'] = false;
    $_SESSION['partylist'] = true;

    $id = $_SESSION['v_id'];
    $stmt = $conn->prepare("SELECT CONCAT(v_fname, ' ', v_lname) AS fullname FROM tbl_voter WHERE v_id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_STR);
    $stmt->execute();
    $voter = $stmt->fetch(PDO::FETCH_ASSOC);
    $fullname = $voter['fullname'];

    $org_id = $_SESSION['org_id'];
    $partylists = SelectAll_Partylists($org_id);
    $sched = Select_VotingSched($org_id);
    if (!empty($sched)) {
        $strt_time = substr_replace($sched['strt_r'], '', 5, 3);
        $end_time = substr_replace($sched['end_r'], '', 5, 3);
        $starts = $sched['vs_start_date'];
        $ends = $sched['vs_end_date'];
    } else {
        $starts = '';
        $ends = '';
    }
?>


    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
        <title>Partylist</title>

        <link rel="stylesheet" href="style.css">

        <!--jQuery CDN for Owl Carousel-->
        <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
        <!--OWL Carousel CSS,JS-->
        <script src="https://cdn.boomcdn.com/libs/owl-carousel/2.3.4/owl.carousel.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" integrity="sha512-tS3S5qG0BlhnQROyJXvNjeEM4UpMXHrQfTGmbQ1gKmelCxlSEBUaxhRBj/EFTzpbP4RVSrpEikbmdJobCvhE3g==" crossorigin="anonymous" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" integrity="sha512-sMXtMNL1zRzolHYKEujM2AqCLUR9F2C4/05cdbxjjLSRvMQIciEPCQZo++nk7go3BtSuK9kfa/s+a4f4i5pLkw==" crossorigin="anonymous" />

        <!--FontAwesome Kit-->
        <script src="https://kit.fontawesome.com/8acebfc2d4.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">

        <script>
            $(document).ready(function() {
                $(document).on('click', '.btn_rm', function() {
                    var can_id = $(this).attr("id");
                    $.ajax({
                        url: "view-can.php",
                        method: "POST",
                        data: {
                            can_id: can_id
                        },
                        success: function(data) {
                            $('#view_can_modal').html(data);
                            $('#SBReadMore').modal('show');
                        }
                    });
                });

            });
        </script>
    </head>

    <body>
        <!--Contacts Section-->
        <nav class="navbar navbar-expand text-white" style="background-color: #000000;">
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

        <div class="d-flex " id="wrapper">
            <!-- Sidebar -->
            <nav class="bg-white" id="sidebar-wrapper">
                <div class="sidebar-heading text-center py-2 fs-3 fw-bold text-uppercase border-bottom">
                    <span class="navbar-brand fs-3 fw-bold me-2"><img src="../assets/img/ovslogov2-ns.png" alt="" width="50" height="40">1VOTE 4PLMAR</span>
                    <p class="mb-2">OVS</p>
                </div>
                <div class="list-group list-group-flush">
                    <a href="dashboard.php" class="list-group-item list-group-item-action second-text fw-bold "><i class="fas fa-tachometer-alt me-2"></i>Dashboard</a>
                    <a href="partylist.php" class="list-group-item list-group-item-action second-text fw-bold active"><i class="fas fa-fist-raised me-2"></i> Partylist</a>
                   

                    <!--Election Schedule Section -->
                    <div class="container-fluid pt-4 text-center ">

                        <div class="rounded bg-gradient-4 text-dark shadow py-5 text-center">
                            <h6 class=" fw-bolder fs-5"><i class="far fa-calendar-alt"></i> ELECTION SCHEDULE</h6>
                            <?php if (!empty($sched)) { ?>
                                <div class="fw-bold">
                                    <div class="mt-4">
                                        <span class="text-danger">STARTS</span><br>
                                        <?= $sched['strt_dw'] ?> <?= $sched['strt_dm'] ?> <?= $sched['strt_sd1'] ?> <?= $sched['strt_sd2'] ?> <?= $strt_time ?>
                                    </div>
                                    <div class="mt-4">
                                        <span class="text-danger">ENDS</span><br> <?= $sched['end_dw'] ?> <?= $sched['end_dm'] ?> <?= $sched['end_sd1'] ?> <?= $sched['end_sd2'] ?> <?= $end_time ?>
                                    </div>
                                </div>
                            <?php } else { ?>
                                <small class="fw-bold">NOT YET SET</small>
                            <?php } ?>
                            <div class="divider div-transparent mb-1"></div>

                            <div class="mt-4">
                                <button id="btn_vn" class="btn btn-lg btn-danger" onclick="location.href='ballot-form.php'" type="button" disabled>
                                    Vote Now</button>
                            </div>
                        </div>

                    </div>
                </div>
            </nav>
            <!-- /#sidebar-wrapper -->

            <!-- Page Content -->
            <div id="page-content-wrapper">
                <nav class="navbar navbar-expand-lg navbar-light bg-light py-4 px-4 sticky-top">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-align-left primary-text fs-4 me-3" id="menu-toggle"></i>
                        <h2 class="fs-4 m-0">VOTER PORTAL</h2>
                    </div>

                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle second-text fw-bold" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-user me-2"></i><?= $fullname ?>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <li><a class="dropdown-item" href="profile.php">Profile</a></li>
                                    <li><a class="dropdown-item" href="settings.php">Settings</a></li>
                                    <li><a class="dropdown-item" href="im-a-candidate.php">I'm a Candidate</a></li>
                                    <li><a class="dropdown-item" href="../logout.php">Logout</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>
                <div class="container-fluid px-4 my-4">
                <?php if (isset($_GET['err'])) { ?>
                    <div class="alert alert-danger mt-3" role="alert">
                        <i class="fas fa-times fs-4 me-3"></i><span><?= $_GET['err'] ?></span>
                    </div>
                <?php } ?>
                    <div class="row">
                        <div class="col-md-9">
                            <p class=""><em>Student Organization: <b><?= $_SESSION['org_name'] ?></b></em></p>
                        </div>
                    </div>
                    <p class="fs-4 text-left">Partylists</p>
                    <div class="row text-center m-2">
                        <?php foreach ($partylists as $p) :
                            $candidates = SelectAll_Candidates($org_id, $p['pname']);
                        ?>
                        <div class="shadow-sm d-flex mt-3 align-items-center rounded">
                                <i class="fas fa-users fs-3 rounded-full bg-info bg-gradient text-dark p-3"><?= $p['pname'] ?></i>
                        </div>
                            <div id="owl" class="text-center container mt-2">
                                <div class="slider owl-carousel">
                                    <?php foreach ($candidates as $c) :

                                        $dir_img_file = './img-uploads/' . $c['Profile Image'];
                                        $candidate_img = (!empty($c['Profile Image'])) ? $dir_img_file : '../assets/img/default_candi.png';

                                    ?>
                                        <div class="card p-3">
                                            <div class="d-flex justify-content-center"><img src="<?= $candidate_img ?>" class="img-fluid mt-2" style="height: 130px; width: auto;" alt=""></div>
                                            <div class="content">
                                                <div class="title fs-5"><?= $c['cname'] ?></div>
                                                <p class="lead mb-0 fs-6"><?= $c['position'] ?></p>
                                            </div>
                                            <div><button class="btn_rm btn btn-primary" id="<?= $c['cid'] ?>" type="button" data-bs-toggle="modal" data-bs-target="#SBReadMore">Read More</button></div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Modal for read more-->

                    <div class="modal fade" id="SBReadMore" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="staticBackdropLabel">Candidate Information</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body" id="view_can_modal">
                                    ...
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row my-5"></div>
                </div>
            </div>
            <!-- /#page-content-wrapper -->
        </div>

        <?php template_footer()?>

        </div>
        <!-- End of .container -->

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            var el = document.getElementById("wrapper");
            var toggleButton = document.getElementById("menu-toggle");

            toggleButton.onclick = function() {
                el.classList.toggle("toggled");
            };

            $(document).ready(function() {
                $('.alert').delay(3000).slideUp(200, function() {
                    $(this).alert('close');
                });
            });
        </script>


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
                    768: {
                        items: 2
                    },
                    1200: {
                        items: 3
                    }
                    
                }
            });
        </script>
        <script>
            $(function() {
                // Set the date we're counting down to
                var countDownDate1 = new Date("<?= $starts ?>").getTime();
                var countDownDate2 = new Date("<?= $ends ?>").getTime();
                // Update the count down every 1 second

                var x = setInterval(function() {
                    // Get today's date and time
                    var now = new Date().getTime();
                    // Find the distance between now and the count down date
                    var distance1 = countDownDate1 - now;

                    // If the count down is finished, write some text
                    if (distance1 < 0 && now < countDownDate2) {
                        clearInterval(x);
                        $('#btn_vn').prop('disabled', false);
                    } else {
                        $('#btn_vn').prop('disabled', true);
                    }
                }, 1000);

                var y = setInterval(VoterTurnout_Progress, 1000);

                function VoterTurnout_Progress() {
                    // Get today's date and time
                    var now = new Date().getTime();
                    var distance2 = (countDownDate2) - now;
                    if (distance2 < 0) {
                        $('#btn_vn').prop('disabled', true);
                        clearInterval(y);
                    }
                    if (distance2 > 0 && now > countDownDate1) {
                        $('#btn_vn').prop('disabled', false);
                    }
                }
            });
        </script>
    </body>
    </html>


<?php
} else {
    header("Location: ../index.php");
}
?>