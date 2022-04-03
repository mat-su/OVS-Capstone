<?php
session_start();
include '../functions.php';
if (isset($_SESSION['a_id']) && isset($_SESSION['a_email'])) {
    $conn = MYSQL_DB_Connection();
    $id = $_SESSION['a_id'];
    $stmt = $conn->prepare("SELECT CONCAT(a_fname, ' ', a_lname) AS fullname FROM tbl_admin WHERE a_id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_STR);
    $stmt->execute();
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);
    $fullname = $admin['fullname'];

    $courses = $conn->query("SELECT course, CONCAT(course, ' (', acronym, ')') AS courses FROM tbl_course");

    template_header('Enrolled Students');

    $stmt = $conn->prepare("SHOW TABLES LIKE 'tbl_enr_stud'");
    $stmt->execute();
    if ($stmt->rowCount() == 0) {
        echo '<script>alert("Enrolled Student table is EMPTY! Please import first the data.")</script>';
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
                    <a href="dashboard.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i class="fas fa-tachometer-alt me-2"></i>Dashboard</a>
                    <a href="students.php" class="active list-group-item list-group-item-action bg-transparent second-text fw-bold"><i class="fas fa-users me-2"></i>Enrolled Students</a>
                    <a href="sub-admin.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i class="fas fa-users-cog me-2"></i>Sub Admin</a>
                    <a href="stud_org.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i class="fas fa-sitemap me-2"></i>Student Organization</a>
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
                        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
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
                <div class="container-fluid px-4 my-2">

                    <div class="row">
                        <div class="col-md-9">
                            <p class="fs-4">Enrolled Students Section</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <select name="course" id="course" class="form-select">
                                <option value="">Select All Course</option>
                                <?php foreach ($courses as $c) : ?>
                                    <option value="<?= $c['course'] ?>"><?= $c['courses'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <select name="ylvl" id="ylvl" class="form-select">
                                <option value="">Select All Year Level</option>
                                <option value="First Year">First Year</option>
                                <option value="Second Year">Second Year</option>
                                <option value="Third Year">Third Year</option>
                                <option value="Fourth Year">Fourth Year</option>
                            </select>
                        </div>
                    </div>
                    <div class="table-responsive mt-4">
                        <table id="student-tbl" class="table bg-white rounded shadow-sm  table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Student Number</th>
                                    <th>Name</th>
                                    <th>Course</th>
                                    <th>Year Level</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>

                <script>
                    var el = document.getElementById("wrapper");
                    var toggleButton = document.getElementById("menu-toggle");

                    toggleButton.onclick = function() {
                        el.classList.toggle("toggled");
                    };
                </script>

            </div>

            <!--Custom JS-->
            <script src="student.js"></script>

        </div>
    </body>

    </html>
<?php
} else {
    header("Location: ../index.php");
}
?>