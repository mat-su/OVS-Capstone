<?php
require '../functions.php';
session_start();
$conn = MYSQL_DB_Connection();
if (isset($_SESSION['v_id']) && isset($_SESSION['v_email']) && isset($_SESSION['org_id']) && isset($_SESSION['org_name'])) {
    $_SESSION['dashboard'] = true;
    $_SESSION['partylist'] = false;
    $id = $_SESSION['v_id'];
    $stmt = $conn->prepare("SELECT v_fname, CONCAT(v_fname, ' ', v_lname) AS fullname FROM tbl_voter WHERE v_id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_STR);
    $stmt->execute();
    $voter = $stmt->fetch(PDO::FETCH_ASSOC);
    $fullname = $voter['fullname'];

    $org_id = $_SESSION['org_id'];
    $stmt = $conn->prepare("SELECT COUNT(*) as c FROM tbl_candidates WHERE c_orgid = :id");
    $stmt->bindParam(':id', $org_id, PDO::PARAM_INT);
    $stmt->execute();
    $candi = $stmt->fetch(PDO::FETCH_ASSOC);
    $countCandi = $candi['c'];

    $stmt = $conn->prepare("SELECT COUNT(*) as c FROM tbl_partylist WHERE p_orgid = :id");
    $stmt->bindParam(':id', $org_id, PDO::PARAM_INT);
    $stmt->execute();
    $party = $stmt->fetch(PDO::FETCH_ASSOC);
    $countParty = $party['c'];

    $sched = Select_VotingSched($org_id);
    if (!empty($sched)) {
        $strt_time = substr_replace($sched['strt_r'], '', 5, 3);
        $end_time = substr_replace($sched['end_r'], '', 5, 3);

        $starts = $sched['startdate'];
        $ends = $sched['enddate'];
    } else {
        $starts = '';
        $ends = '';
    }

    $v = Count_Voters($org_id);
?>


    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
        <title>Voter Dashboard</title>
        <!--Tab Logo-->
        <link rel="shortcut icon" type="image/jpg" href="https://ik.imagekit.io/nwlfpk0xpdg/img/ovs_logo_x6ne_tPjZ7.jpg?ik-sdk-version=javascript-1.4.3&updatedAt=1648299575563" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
        <link rel="stylesheet" href="style.css">

        <!--Font-->
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,400;0,500;1,300;1,400&display=swap" rel="stylesheet">


        <!--FontAwesome Kit-->
        <script src="https://kit.fontawesome.com/8acebfc2d4.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">

        <script src="https://code.jquery.com/jquery-3.6.0.js"></script>

        <!--Chart CDN-->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <!-- Chart Plugins -->
        <script src="https://unpkg.com/chart.js-plugin-labels-dv/dist/chartjs-plugin-labels.min.js"></script>

        <!--SmoothScroll JS-->
        <script src="../assets/js/smoothScroll.js"></script>

    </head>

    <body>
        <div class="d-flex " id="wrapper">
            <!-- Sidebar -->
            <div id="sidebar-wrapper">

                <div class="list-group list-group-flush">
                    <a href="dashboard.php" class="bg-red fw-bold px-3 py-2 text-decoration-none active"><i class="fas fa-tachometer-alt me-2"></i>Dashboard</a>
                    <a href="partylist.php" class="bg-blue fw-bold px-3 py-2 text-decoration-none"><i class="fas fa-fist-raised me-2"></i> Partylist</a>
                    <a href="rules_regulations.php" class="bg-blue fw-bold px-3 py-2 text-decoration-none"><i class="fas fa-tasks me-2"></i>Rules & Regulations</a>

                    <!--Election Schedule Section -->
                    <div class="container-fluid pt-5 text-center ">

                        <div class="rounded border text-white shadow py-5 text-center">
                            <h6 class=" fw-bolder schedHead"><i class="far fa-calendar-alt"></i> ELECTION SCHEDULE</h6>
                            <?php if (!empty($sched)) { ?>
                                <div>
                                    <div class="mt-4">
                                        <span class="fw-bold">STARTS</span><br>
                                        <?= $sched['strt_dw'] ?> <?= $sched['strt_dm'] ?> <?= $sched['strt_sd1'] ?> <?= $sched['strt_sd2'] ?> <?= $strt_time ?>
                                    </div>
                                    <div class="mt-4">
                                        <span class="fw-bold">ENDS</span><br> <?= $sched['end_dw'] ?> <?= $sched['end_dm'] ?> <?= $sched['end_sd1'] ?> <?= $sched['end_sd2'] ?> <?= $end_time ?>
                                    </div>
                                </div>
                            <?php } else { ?>
                                <small class="fw-bold">NOT YET SET</small>
                            <?php } ?>
                            <div class="divider div-transparent mb-1"></div>

                            <div class="mt-4">
                                <button id="btn_vn" class="btn btn-lg" onclick="location.href='ballot-form.php'" type="button" disabled>
                                    Vote Now</button>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
            <!-- /#sidebar-wrapper -->
            <!-- Page Content -->
            <div id="page-content-wrapper">
                <nav class="navbar navbar-expand-lg py-4 px-4">
                    <div id="upper-nav" class="d-flex align-items-center ">
                        <i class="fas fa-align-left fs-4 me-3 text-white" id="menu-toggle"></i>
                        <span class="navbar-brand fs-3 fw-bold"><img src="https://ik.imagekit.io/nwlfpk0xpdg/img/tr:w-50,h-40/ovs_logo_x6ne_tPjZ7.jpg?ik-sdk-version=javascript-1.4.3&updatedAt=1648299575563"></span>
                        <h2>VOTER PORTAL</h2>
                    </div>
                    <button id="button_toggle" class="navbar-toggler text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fas fa-bars"></i>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle  text-white" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-user me-2"></i><?= $fullname ?>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
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
                    <div class="row g-3 my-2">
                        <div class="col-md-12">
                            <div class="p-3 shadow-sm d-flex justify-content-around align-items-center text-center rounded">
                                <div class="container text-wrap py-5">
                                    <img src="https://ik.imagekit.io/nwlfpk0xpdg/img/welcome_Cupeh9RV8.png?updatedAt=1636213495762" alt="" width="auto" height="200">
                                    <h3 class="fs-2">Welcome to OVS!</h3>
                                    <p class="fs-6">Hi <b><?= $voter['v_fname'] ?></b>! We are excited to have you here. Always exercise your right to vote and be part of the school affairs. Do it for the good change.</p>
                                    <p style="color: #d00000;">Your STUDENT ORGANIZATION: <em><b><?= $_SESSION['org_name'] ?></b></em></p>
                                    <a href="#canpar" class="smoothScroll">
                                        <p class=" py-5">Scroll more for updates.<i class="fa fa-angle-double-down" aria-hidden="true"></i></p>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!--No. of candidate and partylist-->
                        <div id="canpar" class="d-flex justify-content-around ">
                            <div class="col-md-4 py-5 ">
                                <div class="bg-blue shadow-sm d-flex justify-content-around align-items-center rounded text-center p-5">
                                    <div>
                                        <h3 class="fs-2"><?= $countParty ?></h3>
                                        <p class="fs-5">Partylist</p>
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-4 py-5">
                                <div class="bg-blue shadow-sm d-flex justify-content-around align-items-center rounded text-center p-5">
                                    <div>
                                        <h3 class="fs-2"><?= $countCandi ?></h3>
                                        <p class="fs-5">Candidates</p>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <!--End of No. of candidate and partylist-->

                        <div class="col-md-12 p-5" style="display: none;">
                            <div id="v-turnout" class="p-3 shadow-sm rounded">
                                <div class="text-center">
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!--tally-->
                        <div class="col-md-12 p-5" style="display:none;">
                            <div id="chart-container" class="p-3 shadow-sm rounded row">
                                <h3 class="text-center"><u><?= $_SESSION['org_acr'] . ' CHOICE ' . date("Y"); ?></u></h3>
                                <h2 class="text-center">ELECTION RESULTS</h2>
                                <?php $positions = fetchAll_OrgStructure($org_id);
                                foreach ($positions as $p) : ?>
                                    <div class="col-md-6 border">
                                        <canvas id="<?= $p['position'] ?>"></canvas>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <!--/-end of tally-->

                        <!--elected officers-->
                        <div class="col-md-12 p-5" style="display:none;">
                            <div id="EO" class="shadow-sm rounded bg-white"></div>
                        </div>
                        <!--/-end of elected officers-->


                    </div>

                    <div class="row my-5"></div>
                </div>
            </div>
            <!-- /#page-content-wrapper -->
        </div>


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
        <script>
            $(function() {
                $('#v-turnout').load("voter-turnout.php");
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
                        $('.g-3 div:nth-child(3)').css("display", "block");
                    } else {
                        $('#btn_vn').prop('disabled', true);
                    }
                }, 1000);

                var y = setInterval(VoterTurnout_Progress, 1000);

                function VoterTurnout_Progress() {
                    // Get today's date and time
                    var now = new Date().getTime();
                    var distance2 = countDownDate2 - now;
                    if (distance2 < 0) {
                        $('#btn_vn').prop('disabled', true);
                        $('.g-3 div:nth-child(3)').css("display", "block");
                        $('.g-3 div:nth-child(4)').css("display", "block");
                        //$('.g-3 div:nth-child(4)').css("display", "block");
                        //$('#EO').load("elected-officers.php");
                        clearInterval(y);
                    }
                    if (distance2 > 0 && now > countDownDate1) {
                        $('#btn_vn').prop('disabled', false);
                        $('#v-turnout').load("voter-turnout.php");
                    }
                }
            });
            console.log(document.querySelector('.g-3 div:nth-child(3)'))
        </script>
        <script>
            //setup

            <?php foreach ($positions as $p) :
                $tally = ChartTally($org_id, $p['id']);
                $name = array();
                $votes = array();
                foreach ($tally as $ta) {
                    array_push($name, $ta['fullname']);
                    array_push($votes, $ta['tallies']);
                }
            ?>
                const labels<?= $p['id'] ?> = <?= json_encode($name) ?>;

                const data<?= $p['id'] ?> = {
                    labels: labels<?= $p['id'] ?>,
                    datasets: [{
                        // axis: 'y',
                        label: 'Number of Votes',
                        data: <?= json_encode($votes) ?>,
                        backgroundColor: [
                            '#073B4C',
                            '#118AB2',
                            '#0CB0A9',
                            '#06D6A0',
                            '#FFD166',
                            '#F78C6B',
                            '#EF476F',
                        ],
                        borderColor: [
                            '#073B4C',
                            '#118AB2',
                            '#0CB0A9',
                            '#06D6A0',
                            '#FFD166',
                            '#F78C6B',
                            '#EF476F',
                        ],
                        borderWidth: 1
                    }]
                };

                //config
                const config<?= $p['id'] ?> = {
                    type: 'pie',
                    data: data<?= $p['id'] ?>,
                    options: {
                        // scales: {
                        //     y: {
                        //         beginAtZero: true
                        //     }
                        // },
                        // indexAxis: 'y',
                        plugins: {
                            title: {
                                display: true,
                                text: "<?= $p['position'] ?>"
                            },
                            legend: {
                                display: true,
                                position: 'right',
                                align: 'center',
                                labels: {
                                    font: {
                                        
                                        family: 'Montserrat, sans-serif'
                                    }
                                }
                            },
                            labels: {
                                render: 'value',
                                fontSize: 14,
                                fontStyle: 'bold',
                                fontColor: '#FFF',
                            }
                        },

                    },
                };
            <?php endforeach; ?>

            <?php foreach ($positions as $p) : ?>
                //render
                const myChart<?= $p['id'] ?> = new Chart(
                    document.getElementById("<?= $p['position'] ?>"),
                    config<?= $p['id'] ?>
                );
            <?php endforeach; ?>
        </script>


    </body>

    </html>

<?php
} else {
    header("Location: ../index.php");
}
?>