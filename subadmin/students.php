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
    template_header('Students');
?>

    <body>
        <div class="d-flex" id="wrapper">
            <!-- Sidebar -->
            <div class="bg-white" id="sidebar-wrapper">
                <div class="list-group list-group-flush my-3">
                    <a href="dashboard.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold">Dashboard</a>
                    <a href="students.php" class="active list-group-item list-group-item-action bg-transparent second-text fw-bold active">Students</a>
                    <a href="org-struct.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold">Org Structure</a>
                    <a href="partylist.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold">Partylist</a>
                    <a href="candidates.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold">Candidate</a>
                    <a href="rules_regulations.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold">Rules & Regulations</a>
                </div>
            </div>

            <!-- Page Content -->
            <div id="page-content-wrapper">
                <nav class="navbar navbar-expand-lg navbar-light bg-light py-4 px-4">
                    <div class="d-flex align-items-end">
                        <i class="fas fa-align-left fs-4 me-3" id="menu-toggle"></i>
                        <span class="navbar-brand fs-3 fw-bold"><img src="https://ik.imagekit.io/nwlfpk0xpdg/img/tr:w-50,h-40/ovs_logo_x6ne_tPjZ7.jpg?ik-sdk-version=javascript-1.4.3&updatedAt=1648299575563">
                        </span>
                        <h2>SUB ADMIN PORTAL</h2>
                    </div> <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
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
                    <div class="row">
                        <div class="col-md-9">
                            <p class="fs-4">Students Section</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <select name="class" id="class" class="form-select">
                                <option value="">Enrolled Students</option>
                                <option value="voter">Registered Voters</option>
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
                                    <th>Year Level</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>

            </div>
            <!-- /#page-content-wrapper -->
        </div>
        <script src="student.js"></script>

        <script>
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