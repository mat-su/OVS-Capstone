<?php
session_start();
include '../functions.php';
$conn = MYSQL_DB_Connection();
date_default_timezone_set('Asia/Hong_Kong');
$current_date = date('Y-m-d H:i:s', time());

$voter_id = $_SESSION['v_id'];
$stmt = $conn->prepare("SELECT v_id, v_status FROM tbl_voter_status WHERE v_id = :v_id");
$stmt->bindParam(':v_id', $voter_id, PDO::PARAM_INT);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    if (isset($_SESSION['dashboard']) && $_SESSION['dashboard'] === true) {
        header("Location: dashboard.php?err=Sorry you have already cast a vote!");
    } elseif (isset($_SESSION['partylist']) && $_SESSION['partylist'] === true) {
        header("Location: partylist.php?err=Sorry you have already cast a vote!");
    } else {
        header("Location: rules_regulations.php?err=Sorry you have already cast a vote!");
    }
} else {
    if (isset($_SESSION['v_id']) && isset($_SESSION['org_id'])) {
        $id = $_SESSION['v_id'];
        $org_id = $_SESSION['org_id'];
        $sched = Select_VotingSched($org_id);
        $target_s_date = $sched['startdate'];
        $target_e_date = $sched['enddate'];
        $target = $target_e_date;
        /* $tempdate = date('Y-m-d H:i:s', strtotime($target_e_date));
        $tempdate2 = new DateTime($tempdate);
        $tempdate2->add(new DateInterval('PT1M'));
        $target = $tempdate2->format('Y-m-d H:i:s'); */
        //target == target_e_date

        if ($current_date < $target_s_date) { //not yet started
            if (isset($_SESSION['dashboard']) && $_SESSION['dashboard'] === true) {
                header("Location: dashboard.php?err=Voting has not yet started!");
            } elseif (isset($_SESSION['partylist']) && $_SESSION['partylist'] === true) {
                header("Location: partylist.php?err=Voting has not yet started!");
            } else {
                header("Location: rules_regulations.php?err=Voting has not yet started!");
            }
        } else if ($current_date >= $target_s_date && $current_date <= $target) { //started but not yet finished
            $org_struc = fetchAll_OrgStructure($org_id);
        } else if ($current_date > $target) {
            if (isset($_SESSION['dashboard']) && $_SESSION['dashboard'] === true) {
                header("Location: dashboard.php?err=Voting has ended!");
            } elseif (isset($_SESSION['partylist']) && $_SESSION['partylist'] === true) {
                header("Location: partylist.php?err=Voting has ended!");
            } else {
                header("Location: rules_regulations.php?err=Voting has ended!");
            }
        }

?>
        <!DOCTYPE html>
        <html>

        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
            <title>Ballot Form</title>

            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" />
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
            <link rel="stylesheet" href="../assets/bootstrap/css/style.css">

            <!--FontAwesome Kit-->
            <script src="https://kit.fontawesome.com/8acebfc2d4.js" crossorigin="anonymous"></script>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

            <!-- Bootstrap CSS -->
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
            <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
            <script>
                $(document).ready(function() {
                    $('#loader').fadeOut(400);

                    $('#proceed').click(function() {
                        $(function() {
                            $('#staticBackdrop').modal('toggle');
                            $('#loader').show();
                            $('#clear, #submit').prop('disabled', true);
                        });
                    });
                });
            </script>
        </head>

        <body>
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

            <!--Main navbar-->
            <!-- Navbar -->
            <nav class="navbar navbar-expand-lg navbar-light bg-white">
                <!-- Container wrapper -->
                <div class="container-fluid" id="main-nav">
                    <!-- Navbar brand -->
                    <div class="container col-12">
                        <a class="navbar-brand lead mb-0 text-wrap" href="#"><img src="../assets/img/ovslogov2-ns.png" alt="" width="auto" height="40px"> PLMAR Online Voting System</a>
                    </div>

                    <a class="nav-link d-flex flex-column text-center" aria-current="page" href="dashboard.php"><i class="fas fa-home text-dark"></i><span class="small text-dark">Home</span></a>
                </div>
                <!-- Container wrapper -->
            </nav>
            <!-- End Navbar -->
            <div class="d-flex justify-content-center" id="loader_section">
                <div class="lds-ellipsis" id="loader">
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
            </div>
            <!--Ballot-->
            <div class="container px-5 my-4">
                <?php if (isset($_GET['err'])) { ?>
                    <div class="alert alert-danger mt-3" role="alert">
                        <i class="fas fa-times fs-4 me-3"></i><span><?= $_GET['err'] ?></span>
                    </div>
                <?php } ?>
                <div class="row">
                    <div class="col-md-12 rounded-top bg-dark text-white border border-dark">
                        <h3 class="display-1 fs-2 text-center">-Ballot-</h3>
                        <h3 class="display-4 fs-5 text-center"><?= $_SESSION['org_name'] ?></h3>
                    </div>
                    <div class="col-lg-12 rounded-bottom border border-dark ">
                        <form id="ballot" action="send-ballot.php" method="post">
                            <div class="row">
                                <?php foreach ($org_struc as $o) : ?>
                                    <div class="col-md-4 mx-0 my-3">
                                        <h5 class="bg-dark text-white text-center m-0 rounded-top "><?= $o['position'] ?>:</h5>
                                        <div class="col-12 rounded-bottom border border-dark ">
                                            <div class="container d-flex justify-content-center mt-2 fst-italic">
                                                <?php
                                                if ($o['seats'] > 1) {
                                                    echo "--Choose up to " . $o['seats'] . " candidates--";
                                                }
                                                ?>
                                            </div>
                                            <?php
                                            $can = fetchAll_CandidatesforBallot($org_id, $o['id']);
                                            foreach ($can as $c) {
                                                if ($c['seats'] == 1) {

                                                    $dir_img_file = './img-uploads/' . $c['img'];
                                                    $candidate_img = (!empty($c['img'])) ? $dir_img_file  : '../assets/img/default_candi.png';
                                            ?>
                                                    <div class="form-check mx-3 my-3">

                                                        <img class="rounded-circle border img-fluid my-3" src="<?= $candidate_img ?>" alt="" style="width: auto; height:5rem;">

                                                        <input class="form-check-input" type="radio" name="<?= $o['position'] ?>" value="<?= $c['cid'] ?>" id="<?= $c['cname'] ?>">
                                                        <label id="<?= $o['position'] ?>" class="form-check-label">
                                                            <?= $c['cname'] ?>
                                                        </label>
                                                    </div>
                                                <?php
                                                } else {
                                                    $dir_img_file = './img-uploads/' . $c['img'];
                                                    $candidate_img = (!empty($c['img'])) ? $dir_img_file  : '../assets/img/default_candi.png'; ?>
                                                    <div class="form-check mx-3 my-3">

                                                        <img class="rounded-circle border img-fluid my-3" src="<?= $candidate_img ?>" alt="" style="width: auto; height:5rem;">

                                                        <input class="form-check-input" type="checkbox" name="<?= $o['position'] . '[]' ?>" value="<?= $c['cid'] ?>" id="<?= $c['cname'] ?>" data-max="<?= $c['seats'] ?>">
                                                        <label id="<?= $o['position'] ?>" class="form-check-label">
                                                            <?= $c['cname'] ?>
                                                        </label>
                                                    </div>
                                            <?php    }
                                            }  ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end p-3">
                                <button class="btn btn-primary" id="submit" type="button" data-bs-toggle="modal" data-bs-target="#staticBackdrop" value="ballot" onclick="displayBallot()">Submit
                                    Ballot</button>
                                <button class="btn btn-primary me-md-2" id="clear" type="button" onclick="clearRadio()">Clear</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

            <!--End Ballot-->

            <!--Ballot Preview Modal-->

            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">Ballot Preview</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div id="voted" class="p-3"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" id="proceed" class="btn btn-primary" form="ballot" name="submit">Proceed</button>
                        </div>
                    </div>
                </div>
            </div>
            <!--End Ballot Preview Modal-->

            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>

            <script src="../assets/js/ballot.js"></script>
            <script>
                function limit() {
                    var count = 0;
                    var boxes = document.querySelectorAll("input[type=checkbox]");
                    for (var i = 0; i < boxes.length; i++) {
                        if (boxes[i].checked && boxes[i].name == this.name) {
                            count++;
                        }
                    }
                    if (count > this.getAttribute("data-max")) {
                        this.checked = false;
                        alert("Maximum of " + this.getAttribute("data-max") + ".");
                    }
                }
                window.onload = function() {
                    var boxes = document.querySelectorAll("input[type=checkbox]");
                    for (var i = 0; i < boxes.length; i++) {
                        boxes[i].addEventListener('change', limit, false);
                    }
                }
                $(document).ready(function() {
                    $('.alert').delay(10000).slideUp(200, function() {
                        $(this).alert('close');
                    });
                });
            </script>

        </body>

        </html>

<?php
    } else {
        if (isset($_SESSION['dashboard']) && $_SESSION['dashboard'] === true) {
            header("Location: dashboard.php?err=There was an error!");
        } elseif (isset($_SESSION['partylist']) && $_SESSION['partylist'] === true) {
            header("Location: partylist.php?err=There was an error!");
        } else {
            header("Location: rules_regulations.php?err=There was an error!");
        }
    }
}
?>