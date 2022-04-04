<?php
include '../functions.php';
session_start();
$conn = MYSQL_DB_Connection();
$num_voter = $conn->query("SELECT count(*) FROM tbl_voter")->fetchColumn();
$num_sa = $conn->query("SELECT count(*) FROM tbl_subadmin")->fetchColumn();
$num_orgs = $conn->query("SELECT count(*) FROM tbl_stud_orgs")->fetchColumn();

if (isset($_SESSION['a_id']) && isset($_SESSION['a_email'])) {

    $id = $_SESSION['a_id'];
    $stmt = $conn->prepare("SELECT CONCAT(a_fname, ' ', a_lname) AS fullname FROM tbl_admin WHERE a_id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_STR);
    $stmt->execute();
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);
    $fullname = $admin['fullname'];

    $courses = $conn->query("SELECT c.id, c.course AS CourseName FROM tbl_course c ORDER BY c.course");
    template_header("Admin Dashboard");

    function checkTblEnrExistence()
    {
        $conn = MYSQL_DB_Connection();
        $stmt = $conn->prepare("SHOW TABLES LIKE 'tbl_enr_stud'");
        $stmt->execute();
        return $stmt->rowCount();
    }

    if (checkTblEnrExistence() == 0) {
        echo '<script>alert("Enrolled Student table is EMPTY! Please import first the data.")</script>';
    } else {
        $countAllEnr = $conn->query("SELECT COUNT(enr_id) AS COUNT_ENR_STUD
        FROM tbl_enr_stud;");
        $n = $countAllEnr->fetch(PDO::FETCH_ASSOC);
    }


    function countEnrStud($courseVal)
    {
        $stmt = "SELECT COUNT(enr_course) AS NumberOfEnrolledStud FROM tbl_enr_stud WHERE enr_course = '$courseVal'";
        $conn = MYSQL_DB_Connection();
        $count = $conn->query($stmt)->fetch(PDO::FETCH_ASSOC);
        echo $count['NumberOfEnrolledStud'];
    }

    function countRegStud($courseVal)
    {
        $stmt = "SELECT COUNT(v_course) AS NumberOfRegisteredStud FROM tbl_voter WHERE v_course = '$courseVal'";
        $conn = MYSQL_DB_Connection();
        $count = $conn->query($stmt)->fetch(PDO::FETCH_ASSOC);
        echo $count['NumberOfRegisteredStud'];
    }
?>

    <body>
        <div class="d-flex" id="wrapper">
            <!-- Sidebar -->
            <div class="bg-white" id="sidebar-wrapper">
                <div class="pt-5 text-center">
                    <h3><b>MENU</b></h3>
                </div>

                <div class="list-group list-group-flush my-3">
                    <a href="dashboard.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold active"><i class="fas fa-tachometer-alt me-2"></i>Dashboard</a>
                    <a href="students.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i class="fas fa-users me-2"></i>Enrolled Students</a>
                    <a href="stud_org.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i class="fas fa-sitemap me-2"></i>Student Organization</a>
                    <a href="sub-admin.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i class="fas fa-users-cog me-2"></i>Sub Admin</a>
                    <a href="v_sched.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i class="far fa-calendar-alt fs-5 me-2"></i></i>Voting Schedule</a>
                    <a href="import_file.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i class="fas fa-file-import me-2"></i>Import file</a>
                </div>
            </div>
            <!-- /#sidebar-wrapper -->

            <!-- Page Content -->
            <div id="page-content-wrapper">
                <nav class="navbar navbar-expand-lg navbar-light bg-light py-4 px-4">
                    <div class="d-flex align-items-end">
                        <i class="fas fa-align-left fs-4 me-3" id="menu-toggle"></i>
                        <span class="navbar-brand fs-3 fw-bold"><img src="https://ik.imagekit.io/nwlfpk0xpdg/img/tr:w-50,h-40/ovs_logo_x6ne_tPjZ7.jpg?ik-sdk-version=javascript-1.4.3&updatedAt=1648299575563">
                        </span>
                        <h2> ADMIN PORTAL</h2>
                    </div>

                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto mb-2 mb-lg-0 ">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle second-text fw-bold" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-user me-2"></i><?= $fullname ?>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <li><a class="dropdown-item" href="account-settings.php">Account Settings</a></li>
                                    <li><a class="dropdown-item" href="create-new-acc.php">Create Successor</a></li>
                                    <li><a class="dropdown-item" href="../logout.php">Logout</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>

                <div class="container-fluid px-4 my-4">
                    <div class="row g-3 my-2">
                        <div class="col-md-3">
                            <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
                                <div class="text-center">
                                    <?php
                                    if (checkTblEnrExistence() == 0) {
                                        echo '<h3 class="fs-2">0</h3>';
                                    } else {
                                        echo '<h3 class="fs-2">' . $n["COUNT_ENR_STUD"] . '</h3>';
                                    }
                                    ?>
                                    <p class="fs-5">Enrolled Students</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
                            <div class="text-center">
                                    <h3 class="fs-2"><?= $num_voter ?></h3>
                                    <p class="fs-5">Total Voters</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
                                <div class="text-center">
                                    <h3 class="fs-2"><?= $num_sa ?></h3>
                                    <p class="fs-5">Sub Admins</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
                            <div class="text-center">
                                    <h3 class="fs-2"><?= $num_orgs ?></h3>
                                    <p class="fs-5">Student Orgs</p>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="table-responsive mt-4">
                        <table id="insights-tbl" class="table bg-white rounded shadow-sm  table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Courses</th>
                                    <th># of Enrolled Students</th>
                                    <th># of Registered Voters</th>
                                    <th>More infos</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($courses as $c) : ?>
                                    <tr>
                                        <td><?= $c['CourseName'] ?></td>
                                        <td>
                                            <?php
                                            if (checkTblEnrExistence() == 0) {
                                                echo 0;
                                            } else {
                                                echo countEnrStud($c['CourseName']);
                                            }
                                            ?>
                                        </td>
                                        <td><?= countRegStud($c['CourseName']) ?></td>
                                        <td>
                                            <a href="" class="info" title="More Info" data-bs-toggle="modal" id="<?= $c['id'] ?>" data-bs-target="#staticBackdropView"><i class="fas fa-info-circle"></i></a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="row my-5"></div>
                </div>
            </div>
            <!-- /#page-content-wrapper -->
        </div>

        <div class="modal fade" id="staticBackdropView" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabelView" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabelView">Further Details:</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="info_modal">
                        ...
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>



        <script>
            $(document).ready(function() {
                $(document).on('click', '.info', function() {
                    var course_id = $(this).attr("id");
                    $.ajax({
                        url: "view-info.php",
                        method: "POST",
                        data: {
                            course_id: course_id
                        },
                        success: function(data) {
                            $('#info_modal').html(data);
                            $('#staticBackdropView').modal('show');
                        }
                    });
                });
            });

            var el = document.getElementById("wrapper");
            var toggleButton = document.getElementById("menu-toggle");

            toggleButton.onclick = function() {
                el.classList.toggle("toggled");
            };
        </script>
    </body>

    </html>
<?php
} else {
    header("Location: ../index.php");
}
?>