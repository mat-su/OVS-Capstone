<?php
session_start();

if (isset($_SESSION['a_id']) && isset($_SESSION['a_email'])) {
    include '../functions.php';
    $conn = MYSQL_DB_Connection();
    $orgs = $conn->query("SELECT o.org_id AS org_id, CONCAT(o.org_name, ' (', o.org_acronym, ')') AS Org_Name, s.vs_org_id, DATE_FORMAT(s.vs_start_date, '%a %b %e %Y') as strt, DATE_FORMAT(s.vs_end_date, '%a %b %e %Y') as end, DATE_FORMAT(s.vs_start_date, '%r') as strt_r, DATE_FORMAT(s.vs_end_date, '%r') as end_r FROM tbl_stud_orgs o LEFT JOIN tbl_vote_sched s ON o.org_id = s.vs_org_id ORDER BY org_id ASC");

    $id = $_SESSION['a_id'];
    $stmt = $conn->prepare("SELECT CONCAT(a_fname, ' ', a_lname) AS fullname FROM tbl_admin WHERE a_id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_STR);
    $stmt->execute();
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);
    $fullname = $admin['fullname'];

?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <!--Logo-->
        <link rel="shortcut icon" type="image/jpg" href="https://ik.imagekit.io/nwlfpk0xpdg/img/tr:w-50,h-50/logo-png_Xt7bTS_7o.png?ik-sdk-version=javascript-1.4.3&updatedAt=1636213481504" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
        <link rel="stylesheet" href="../assets/bootstrap/css/style.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css">
        <title>Voting Schedule</title>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

        <script>
            $(document).ready(function() {
                $(document).on('click', '.linkschedule', function() {
                    var org_id = $(this).attr("id");
                    $.ajax({
                        url: "sched.php",
                        method: "POST",
                        data: {
                            org_id: org_id
                        },
                        success: function(data) {
                            $('#vs_modal').html(data);
                            $('#staticBackdropSched').modal('show');
                        }
                    });
                });
                $(document).on('click', '.linkclrsched', function() {
                    var org_id = $(this).attr("id");
                    $.ajax({
                        url: "clearsched.php",
                        method: "POST",
                        data: {
                            org_id: org_id
                        },
                        success: function(data) {
                            $('#cvs_modal').html(data);
                            $('#staticBackdropClrSched').modal('show');
                        }
                    });
                });
            });
        </script>
    </head>

    <body>
        <nav class="navbar navbar-expand text-white py-0" style="background-color: #000000;">
            <div class="container-fluid">
                <ul class="navbar-nav ">
                    <li class="nav-item py-2">
                        <small>PAMANTASAN NG LUNGSOD NG MARIKINA</small>
                    </li>

                </ul>
            </div>
        </nav>
        <div class="d-flex" id="wrapper">
            <!-- Sidebar -->
            <div class="bg-white" id="sidebar-wrapper">
                <div class="sidebar-heading text-center py-2 fs-3 fw-bold text-uppercase border-bottom">
                    <span class="navbar-brand fs-3 fw-bold"><img src="../assets/img/ovslogov2-ns.png" alt="" width="50" height="40">1VOTE 4PLMAR</span>
                    <p class="my-0">OVS</p>
                </div>
                <div class="list-group list-group-flush my-3">
                    <a href="dashboard.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold "><i class="fas fa-tachometer-alt me-2"></i>Dashboard</a>
                    <a href="sub-admin.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i class="fas fa-users-cog me-2"></i>Sub Admin</a>
                    <a href="stud_org.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i class="fas fa-sitemap me-2"></i>Stud Orgs</a>
                    <a href="v_sched.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold active"><i class="far fa-calendar-alt fs-5 me-2"></i></i>Voting Schedule</a>
                    <a href="import_file.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i class="fas fa-file-import me-2"></i>Import file</a>
                </div>
            </div>
            <!-- /#sidebar-wrapper -->

            <!-- Page Content -->
            <div id="page-content-wrapper">
                <nav class="navbar navbar-expand-lg navbar-light bg-light py-4 px-4">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-align-left primary-text fs-4 me-3" id="menu-toggle"></i>
                        <h2 class="fs-4 m-0">ADMINISTRATOR PORTAL</h2>
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
                                    <li><a class="dropdown-item" href="account-settings.php">Account Settings</a></li>
                                    <li><a class="dropdown-item" href="create-new-acc.php">Create New Account</a></li>
                                    <li><a class="dropdown-item" href="../logout.php">Logout</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>

                <div class="container-fluid px-4 my-4">
                    <div class="row">
                        <div class="col-md-9">
                            <p class="fs-4">Voting Schedule</p>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table id="tbl_sched" class="table bg-white rounded shadow-sm  table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Org Name</th>
                                    <th>Start</th>
                                    <th>End</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($orgs as $o) : ?>
                                    <tr>
                                        <td><?= $o['Org_Name'] ?></td>
                                        <td><?= $o["strt"] ?> <?= substr_replace($o['strt_r'], '', 5, 3); ?></td>
                                        <td><?= $o["end"] ?> <?= substr_replace($o['end_r'], '', 5, 3); ?></td>
                                        <td class="actions">
                                            <a href="" class="linkschedule" title="Set Schedule" data-bs-toggle="modal" id="<?= $o['org_id'] ?>" data-bs-target="#staticBackdropSched"><i class="far fa-calendar-alt fs-5"></i></a>
                                            <?php
                                            if ($o["vs_org_id"] != "") { ?>
                                                <a href="" class="linkclrsched" title="Set Schedule" data-bs-toggle="modal" id="<?= $o['org_id'] ?>" data-bs-target="#staticBackdropClrSched"><i class="fas fa-eraser text-danger"></i></a>
                                            <?php } ?>
                                            <!-- Modal set voting schedule -->
                                            <div class="modal fade" id="staticBackdropSched" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabelSched" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="staticBackdropLabelSched"> Voting
                                                                Schedule</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body" id="vs_modal">

                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary" form="sched">
                                                                Save Schedule
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Modal for clear voting schedule-->
                                            <div class="modal fade" id="staticBackdropClrSched" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabelClrSched" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="staticBackdropLabelClrSched"> Clear Voting
                                                                Schedule</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body" id="cvs_modal">

                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary" form="clrsched">
                                                                Yes
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
            <!-- /#page-content-wrapper -->
        </div>
        <?= template_footer() ?>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script type="text/javascript" src="    https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.min.js"></script>

        <script>
            var el = document.getElementById("wrapper");
            var toggleButton = document.getElementById("menu-toggle");

            toggleButton.onclick = function() {
                el.classList.toggle("toggled");
            };

            $(document).ready(function() {
                $('#tbl_sched').DataTable({
                    "ordering": false,
                    "aLengthMenu": [
                        [5, 10, 15, -1],
                        [5, 10, 15, "All"]
                    ]
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