<?php
session_start();
include '../functions.php';
$conn = MYSQL_DB_Connection();
if (isset($_SESSION['v_id']) && isset($_SESSION['v_email']) && isset($_SESSION['org_id'])) {
    $studnum = $_SESSION['v_studnum'];
    $stmt = $conn->prepare("SELECT c_studnum, c_id FROM tbl_candidates WHERE c_studnum = :studnum");
    $stmt->bindParam(':studnum', $studnum, PDO::PARAM_STR);
    $stmt->execute();
    if ($stmt->rowCount() == 1) {
        $c = $stmt->fetch(PDO::FETCH_ASSOC);
        $can = SelectAll_CandidateWithInfo($c['c_id']);
        $_SESSION['c_id'] = $c['c_id'];

        $fullname = $can['Name'];
        $position = $can['Position'];
        $platform = (!empty($can['Platform'])) ? $can['Platform'] : 'Nothing to show.';
        $dir_img_file = './img-uploads/' . $can['Profile Image'];
        $candidate_img = (!empty($can['Profile Image'])) ? $dir_img_file  : '../assets/img/default_candi.png';
        $course = $can['Course'];
        $ylvl = $can['Year Level'];
        $partylist = $can['Partylist'];
    } else {
        if (isset($_SESSION['dashboard']) && $_SESSION['dashboard'] === true) {
            header("Location: dashboard.php?err=Sorry your not an official candidate!");
        } else {
            header("Location: partylist.php?err=Sorry your not an official candidate!");
        }
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

    </head>

    <body>
        <!--Contacts Section-->
        <nav class="navbar navbar-expand text-white py-0" style="background-color: #000000;">
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
                    <li class="nav-item"><span class="text-white">|</span></li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="dashboard.php"><small>Home</small></a>
                    </li>
                </ul>
            </div>
        </nav>

        <div class="d-flex toggled" id="wrapper">
            <div id="page-content-wrapper">
                <div class="container">

                    <!--Candidate 1-->
                    <?php if (isset($_GET['err'])) { ?>
                        <div class="alert alert-danger mt-3" role="alert">
                            <i class="fas fa-times fs-4 me-3"></i><span><?= $_GET['err'] ?></span>
                        </div>
                    <?php } ?>
                    <?php if (isset($_GET['info'])) { ?>
                        <div class="alert alert-success mt-3" role="alert">
                            <i class="fas fa-check fs-4 me-3"></i><span><?= $_GET['info'] ?></span>
                        </div>
                    <?php } ?>
                    <div class="row bg-white m-2 p-3 shadow-lg justify-content-around align-items-center rounded border border-primary border-3">
                        <div class="col-md-6 text-center">
                            <div>
                                <img class="rounded-circle border img-fluid my-3" src="<?= $candidate_img ?>" alt="" style="width: auto; height:10rem;">
                                <div class="mb-3"><button class="btn btn-outline-primary" type="button" id="btn-edit-prof">Update Picture <i class="fas fa-camera"></i></button></div>
                            </div>
                            <div class="mb-3 card card-body shadow" id="upload-sec" hidden>
                                <div>
                                    <button type="button" class="btn-close float-end" aria-label="Close"></button>
                                    <p class="text-start">
                                        Please select an image from your device
                                        <br><small class="text-danger">*Image must be less than 1mb</small>
                                    </p>
                                </div>
                                <form action="upload-profile-img.php" method="POST" enctype="multipart/form-data">
                                    <div class="input-group input-group-sm ">
                                        <input type="file" name="profile-img" class="form-control" id="profile-img" aria-label="Upload" accept="image/*" required>
                                        <button class="btn btn-outline-primary" type="submit" id="btn_upload" name="upload">Upload</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <h3 class="fs-2"><?= $fullname ?></h3>
                            <h5 class="fs-3"><?= $position ?></h5>
                            <p class="fs-5">Get to know me!</p>
                        </div>

                        <div class="divider div-transparent mb-3"></div>
                        <div><button class="btn btn-secondary w-25 float-end" id="btn-edit-platform">Create Platform <i class="fas fa-edit"></i></button></div>
                        <div class="col-md-12 text-center">
                            <i class="fas fa-bullhorn fs-1 primary-text  secondary-bg p-4"></i>

                            <div id="display-platform">
                                <h3 class="fs-3 ">Platform</h3>
                                <p class="fs-6"><?= $platform ?></p>
                            </div>


                            <div class="card card-body col-8 offset-2 shadow mb-3" id="platform-sec" hidden>
                                <div class="mb-3"><span class="fs-3">Platform</span><button type="button" class="btn-close float-end" aria-label="Close" id="btn-close-platform1"></button></div>
                                <form action="candi-plat.php" method="POST" id="frmPlatform">
                                    <div class="form-floating">
                                        <textarea class="form-control" placeholder="Leave a comment here" id="txtarea-platform" style="height: 200px" maxlength="2000" name="platform"><?= $platform ?></textarea>
                                        <label for="txtarea-platform">Type your platform here</label>
                                        <small id=charNum class="text-muted"></small>
                                    </div>
                                </form>

                                <div class="mt-2">
                                    <button type="submit" class="btn btn-primary float-end" form="frmPlatform" name="submit">Save</button>
                                    <button type="button" class="btn btn-secondary float-end me-2" id="btn-close-platform2">Close</button>
                                </div>
                            </div>
                            <script>

                            </script>

                        </div>
                        <div class="divider div-transparent"></div>

                        <div class="col-md-6 text-center">


                            <i class="fas fa-id-card-alt fs-1 primary-text  secondary-bg p-4"></i>
                            <h3 class="fs-3 ">Info</h3>

                            <p class="fs-6"><?= $fullname ?></p>
                            <p class="fs-6"><?= $course ?></p>
                            <p class="fs-6"><?= $ylvl ?></p>
                            <p class="fs-6"><?= $partylist ?></p>

                        </div>
                    </div>
                    <!--End Candidate 1-->
                </div>
            </div>

        </div>


        <?= template_footer() ?>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>

        <script>
            $(document).ready(function() {
                $("#btn-edit-prof").click(function() {
                    $("#upload-sec").prop('hidden', false);
                    $("#btn-edit-prof").prop('hidden', true);
                });
                $(".btn-close").click(function() {
                    $("#upload-sec").prop('hidden', true);
                    $("#btn-edit-prof").prop('hidden', false);
                    $('#profile-img').val('');
                });
                $('.alert').delay(3000).slideUp(200, function() {
                    $(this).alert('close');
                });
                $("#btn-edit-platform").click(function() {
                    $("#platform-sec").prop("hidden", false);
                    $("#btn-edit-platform").prop("hidden", true);
                    $("#display-platform").prop("hidden", true);
                    // var str = "";
                    // var str = str.replace(/(?:\r\n|\r|\n)/g, '<br>');
                    // $('#txtarea-platform').val(str);
                });

                $('#btn-close-platform1, #btn-close-platform2').click(function() {
                    $("#platform-sec").prop("hidden", true);
                    $("#btn-edit-platform").prop("hidden", false);
                    $("#display-platform").prop("hidden", false);
                });

                $('#txtarea-platform').keyup(function() {
                    var len = this.value.length;
                    if (len >= 2000) {
                        val.value = val.value.substring(0, 2000);
                    } else {
                        $('#charNum').text(2000 - len + '/2000 characters');
                    }
                });
            });
        </script>
    </body>


    </html>


<?php
} else {
    header("Location: ../index.php");
}
?>