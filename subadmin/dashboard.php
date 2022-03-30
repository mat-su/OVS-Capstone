<?php
include '../functions.php';
session_start();
$conn = MYSQL_DB_Connection();

if (isset($_SESSION['sa_id']) && isset($_SESSION['sa_email'])) {
    $sa_orgid = $_SESSION['sa_org_id'];
    $sa_fname = $_SESSION['sa_fname'];
    $sa_lname = $_SESSION['sa_lname'];
    $stmt = $conn->prepare("SELECT * FROM tbl_stud_orgs o WHERE o.org_id = :id");
    $stmt->bindParam(':id', $sa_orgid, PDO::PARAM_STR);
    $stmt->execute();
    $org = $stmt->fetch(PDO::FETCH_ASSOC);
    $org_name = $org['org_name'];
    $org_acr = $org['org_acronym'];

    $sched = Select_VotingSched($sa_orgid);
    if (!empty($sched)) {
        $starts = $sched['startdate'];
        $ends = $sched['enddate'];
    } else {
        $starts = '';
        $ends = '';
    }
    template_header("Subadmin Dashboard");
?>

    <body>
        <div class="d-flex" id="wrapper">
            <!-- Sidebar -->
            <div class="bg-white" id="sidebar-wrapper">
                <div class="sidebar-heading text-center py-2 fs-3 fw-bold text-uppercase border-bottom">
                    <span class="navbar-brand fs-3 fw-bold"><img src="https://ik.imagekit.io/nwlfpk0xpdg/img/tr:w-50,h-40/ovs_logo_x6ne_tPjZ7.jpg?ik-sdk-version=javascript-1.4.3&updatedAt=1648299575563">1VOTE 4PLMAR</span>
                    <p class="my-0">OVS</p>
                </div>
                <div class="list-group list-group-flush my-3">
                    <a href="dashboard.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold active">Dashboard</a>
                    <a href="students.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold">Students</a>
                    <a href="org-struct.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold">Org Structure</a>
                    <a href="partylist.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold">Partylist</a>
                    <a href="candidates.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold">Candidate</a>
                    <a href="rules_regulations.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold">Rules & Regulations</a>
                </div>
            </div>

            <!-- Page Content -->
            <div id="page-content-wrapper">
                <nav class="navbar navbar-expand-lg navbar-light bg-light py-4 px-4">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-align-left primary-text fs-4 me-3" id="menu-toggle"></i>
                        <h2 class="fs-4 m-0">SUB-ADMINISTRATOR PORTAL</h2>
                    </div>

                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle second-text fw-bold" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-user me-2"></i><?= $sa_fname ?> <?= $sa_lname ?>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <li><a class="dropdown-item" href="settings.php">Settings</a></li>
                                    <li><a class="dropdown-item" href="../logout.php">Logout</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>

                <div class="container-fluid px-4 my-2">
                    <div class="row">
                        <div class="col-md-9">
                            <p class=""><em>Student Organization: <b><?= $org_name ?> (<?= $org_acr ?>)</b></em></p>
                        </div>
                    </div>
                    <div class="row g-3 my-2">
                        <div class="col-md-12" style="display: none;">
                            <!-- Voter Turnout -->
                            <div id="v-turnout" class="p-3 shadow-sm rounded" style="background-color: #ffe6ee;">
                                <div class="text-center">
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--tally-->
                        <div class="col-md-12" style="display:none;">
                            <div id="chart-container" class="p-3 shadow-sm rounded bg-white row">
                                <h3 class="text-center"><u><?= $org_acr . ' CHOICE ' . date("Y"); ?></u></h3>
                                <h2 class="text-center">ELECTION RESULTS</h2>
                                <div class="row m-0">
                                    <?php $positions = fetchAll_OrgStructure($sa_orgid);
                                    foreach ($positions as $p) : ?>
                                        <div class="col-md-6 border">
                                            <canvas id="<?= $p['position'] ?>"></canvas>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                        <!--/-end of tally-->
                    </div>

                </div>

            </div>
            <!-- /#page-content-wrapper -->
        </div>
        <?= template_footer() ?>
        <script>
            var el = document.getElementById("wrapper");
            var toggleButton = document.getElementById("menu-toggle");

            toggleButton.onclick = function() {
                el.classList.toggle("toggled");
            };
        </script>
        <script>
            $(function() {
                $('#v-turnout').load("../voter/voter-turnout.php");
                // Set the date we're counting down to
                var countDownDate1 = new Date("<?= $starts ?>").getTime();
                var countDownDate2 = new Date("<?= $ends ?>").getTime();


                var y = setInterval(VoterTurnout_Progress, 1000);

                function VoterTurnout_Progress() {
                    // Get today's date and time
                    var now = new Date().getTime();
                    var distance2 = countDownDate2 - now;
                    if (distance2 < 0) {
                        $('#btn_vn').prop('disabled', true);
                        $('.g-3 div:nth-child(1)').css("display", "block");
                        $('.g-3 div:nth-child(2)').css("display", "block");
                        clearInterval(y);
                    }
                    if (distance2 > 0 && now > countDownDate1) {
                        $('#btn_vn').prop('disabled', false);
                        $('#v-turnout').load("voter-turnout.php");
                    }
                }
            });
        </script>
        <script>
            //setup
            <?php foreach ($positions as $p) :
                $tally = ChartTally($sa_orgid, $p['id']);
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
                    type: 'doughnut',
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
                                align: 'center'
                            },
                            labels: {
                                render: 'value',
                                fontSize: 14,
                                fontStyle: 'bold',
                                fontColor: '#FFF',
                                fontFamily: '"Lucida Console", Monaco, monospace'
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