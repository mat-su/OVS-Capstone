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
    header("Location: dashboard.php?err=Sorry you have already cast a vote!");
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
            } else {
                header("Location: partylist.php?err=Voting has not yet started!");
            }
        } else if ($current_date >= $target_s_date && $current_date <= $target) { //started but not yet finished
            $org_struc = fetchAll_OrgStructure($org_id);
        } else if ($current_date > $target) {
            if (isset($_SESSION['dashboard']) && $_SESSION['dashboard'] === true) {
                header("Location: dashboard.php?err=Voting has ended!");
            } else {
                header("Location: partylist.php?err=Voting has ended!");
            }
        }

?>

        <!DOCTYPE html>
        <html>

        <head>
            <meta charset="utf-8" />
            <title>Ballot Form</title>
            <meta content="width=device-width, initial-scale=1" name="viewport" />
            <!-- Custom CSS -->
            <link href="ballot.css" rel="stylesheet" type="text/css" />
            <!-- WebFont JS -->
            <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js" type="text/javascript"></script>
            <!-- Bootstrap CSS -->
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
            <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
            <script>
                WebFont.load({
                    google: {
                        families: [
                            "Montserrat:100,100italic,200,200italic,300,300italic,400,400italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic"
                        ]
                    }
                });
                $(document).ready(function() {
                    $('#loader').fadeOut(600);
                });

                $('#proceed').click(function() {
                    $(function() {
                        $('#staticBackdrop').modal('toggle');
                        $('#loader').show();
                        $('#clear, #submit').prop('disabled', true);
                    });
                });

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

        </head>

        <body>
            <div>
                <div class="d-flex justify-content-center pt-3" id="loader_section">
                    <div class="lds-ellipsis" id="loader">
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </div>
                <div class="div-block-ballot-wrapper">
                    
                    <div>
                        <h5 class="heading-ballot">-Ballot-</h5>
                        <h3 class="heading-ballot display-4 fs-5 text-center text-white"><?= $_SESSION['org_name'] ?></h3>
                    </div>
                    <div class="div-block-ballot-wrap">
                        <div class="form-block w-form">
                            <form id="ballot" name="" method="get" class="form">
                                <div class="div-block-2">
                                    <?php foreach ($org_struc as $o) : ?>
                                        <h5 class="bg-dark text-white text-center m-0"><?= $o['position'] ?>:</h5>
                                        <!-- Label available seat for this position if greater to 1 -->
                                        <div class="container d-flex mt-2 fst-italic field-label-6 fs-6">
                                            <?php
                                            if ($o['seats'] > 1) {
                                                echo "--Choose up to " . $o['seats'] . " candidates--";
                                            }
                                            ?>
                                        </div>
                                        <!-- /end -->

                                        <div class="div-block-ballot">
                                            <?php
                                            $can = fetchAll_CandidatesforBallot($org_id, $o['id']);
                                            foreach ($can as $c) {
                                                if ($c['seats'] == 1) {

                                                    $dir_img_file = './img-uploads/' . $c['img'];
                                                    $candidate_img = (!empty($c['img'])) ? $dir_img_file  : '../assets/img/default_candi.png';
                                            ?>
                                                    <div class="photo1"><img sizes="(max-width: 479px) 60px, (max-width: 991px) 80px, 100px" srcset="<?= $candidate_img ?> 500w, <?= $candidate_img ?> 800w, <?= $candidate_img ?> 1080w, <?= $candidate_img ?> 1600w, <?= $candidate_img ?> 2000w, <?= $candidate_img ?> 2600w, <?= $candidate_img ?> 3024w" src="<?= $candidate_img ?>" loading="lazy" alt="" class="image-3" />

                                                        <label class="radio-button-field-2 w-radio">
                                                            <input type="radio" name="<?= $o['position'] ?>" id="<?= $c['cname'] ?>" value="<?= $c['cid'] ?>" class="w-radio-input" />
                                                            <span id="<?= $o['position'] ?>" class="w-form-label" for=""><?= $c['cname'] ?></span>
                                                        </label>
                                                    </div>
                                                <?php
                                                } else {
                                                    $dir_img_file = './img-uploads/' . $c['img'];
                                                    $candidate_img = (!empty($c['img'])) ? $dir_img_file  : '../assets/img/default_candi.png'; ?>

                                                    <div class="photo1"><img sizes="(max-width: 479px) 60px, (max-width: 991px) 80px, 100px" srcset="<?= $candidate_img ?> 500w, <?= $candidate_img ?> 800w, <?= $candidate_img ?> 1080w, <?= $candidate_img ?> 1600w, <?= $candidate_img ?> 2000w, <?= $candidate_img ?> 2600w, <?= $candidate_img ?> 3024w" src="<?= $candidate_img ?>" loading="lazy" alt="" class="image-3" />

                                                        <label class="radio-button-field-2 w-radio">
                                                            <input type="radio" name="<?= $o['position'] ?>" id="<?= $c['cname'] ?>" value="<?= $c['cid'] ?>" class="w-radio-input" />
                                                            <span id="<?= $o['position'] ?>" class="w-form-label" for=""><?= $c['cname'] ?></span>
                                                        </label>
                                                    </div>
                                            <?php    }
                                            }  ?>
                                        </div>

                                    <?php endforeach; ?>
                                </div>
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end p-3">
                                    <button class="submit-button w-button" id="submit" type="button" data-bs-toggle="modal" data-bs-target="#staticBackdrop" value="ballot" onclick="displayBallot()">Submit
                                        Ballot</button>
                                    <button class="clear-button w-button me-md-2" id="clear" type="button" onclick="clearRadio()">Clear</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>


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
            </div>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>

            <script src="../assets/js/ballot.js"></script>
        </body>

        </html>

<?php
    } else {
        if (isset($_SESSION['dashboard']) && $_SESSION['dashboard'] === true) {
            header("Location: dashboard.php?err=There was an error!");
        } else {
            header("Location: partylist.php?err=There was an error!");
        }
    }
}
?>