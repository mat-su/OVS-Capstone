<?php
session_start();
if (isset($_SESSION['a_id']) && isset($_SESSION['a_email'])) {
    include '../functions.php';
    $conn = MYSQL_DB_Connection();
    $orgs = $conn->query("SELECT org_id, CONCAT(o.org_name, ' (', o.org_acronym, ')') AS Org_Name FROM tbl_stud_orgs o");

    $id = $_SESSION['a_id'];
    $stmt = $conn->prepare("SELECT CONCAT(a_fname, ' ', a_lname) AS fullname FROM tbl_admin WHERE a_id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_STR);
    $stmt->execute();
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);
    $fullname = $admin['fullname'];

    template_header('Manage Sub Admin');
?>

    <body class="">
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
                    <a href="sub-admin.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold active"><i class="fas fa-users-cog me-2"></i>Sub Admin</a>
                    <a href="stud_org.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i class="fas fa-sitemap me-2"></i>Stud Orgs</a>
                    <a href="v_sched.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i class="far fa-calendar-alt fs-5 me-2"></i></i>Voting Schedule</a>
                    <a href="import_file.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i class="fas fa-file-import me-2"></i>Import file</a>
                </div>
            </div>
            <!-- /#sidebar-wrapper -->
            <div id="page-content-wrapper">
                <nav class="navbar navbar-expand-lg navbar-light bg-light py-4 px-4">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-align-left primary-text fs-4 me-3" id="menu-toggle"></i>
                        <h2 class="fs-4 m-0">SUB ADMINISTRATOR PORTAL</h2>
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
                        <div class="col-md-12" id="msg"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-9">
                            <p class="fs-4">Sub Admin Information</p>
                        </div>
                        <div class="col-md-3">
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-success mt-2 mb-3" data-bs-toggle="modal" data-bs-target="#staticBackdropCreate" style="float: right"><i class="fas fa-plus me-2"></i>Create New</button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="subadmin-tbl" class="table bg-white rounded shadow-sm  table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Student Org</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <?php echo template_footer() ?>
        <!--Create Modal -->
        <div class="modal fade" id="staticBackdropCreate" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabelCreate" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabelCreate">Create New Sub Admin</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <form id="frm_create_sub" method="post" action="save_new_sa.php">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="fname" class="form-label">Firstname</label>
                                        <input type="text" class="form-control mb-2" placeholder="" name="fname" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="mname" class="form-label">Middlename</label>
                                        <input type="text" class="form-control mb-2" placeholder="" name="mname">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="lname" class="form-label">Lastname</label>
                                        <input type="text" class="form-control mb-2" placeholder="" name="lname" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-8">
                                        <label for="email" class="form-label">Email Address</label>
                                        <input type="email" class="form-control mb-2" placeholder="" name="email" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class=" col-md-12">
                                        <label for="" class="form-label">Student Organization</label>
                                        <select class="form-select" aria-label="Default select example" name="org" form="frm_create_sub" required>
                                            <option value="">--Select Student Organization--</option>
                                            <?php foreach ($orgs as $o) : ?>
                                                <option value="<?= $o['org_id'] ?>"><?= $o['Org_Name'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="cancel-btn" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" form="frm_create_sub">Save</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- / Create Modal -->
        <!-- View/Edit Modal -->
        <div class="modal fade" id="staticBackdropView" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabelView" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabelView">Sub Admin Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <form id="frm_edit_sub" method="post" action="update_sa.php">
                                <input type="hidden" name="sa_id" id="sa_id">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="fname" class="form-label">First Name</label>
                                        <input type="text" class="form-control mb-2" placeholder="" name="fname" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="mname" class="form-label">Middle Name</label>
                                        <input type="text" class="form-control mb-2" placeholder="" name="mname">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="lname" class="form-label">Last Name</label>
                                        <input type="text" class="form-control mb-2" placeholder="" name="lname" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-8">
                                        <label for="email" class="form-label">Email Address</label>
                                        <input type="email" class="form-control mb-2" placeholder="" name="email" required readonly>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class=" col-md-12">
                                        <label for="" class="form-label">Student Organization</label>
                                        <select class="form-select" id="org" aria-label="Default select example" name="org" form="frm_edit_sub" required>
                                            <option value="">--Select Student Organization--</option>
                                            <?php $orgs = $conn->query("SELECT org_id, CONCAT(o.org_name, ' (', o.org_acronym, ')') AS Org_Name FROM tbl_stud_orgs o");

                                            foreach ($orgs as $o) : ?>
                                                <option value="<?= $o['org_id'] ?>"><?= $o['Org_Name'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="cancel-btn" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" form="frm_edit_sub">Edit</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- / View/Edit Modal -->
        <!-- Delete Modal -->
        <div class="modal fade" id="staticBackdropDelete" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabelDelete" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabelDelete">Delete Sub Admin</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="frm_delete_sub" method="post" action="delete_sa.php">
                            <p> Are you sure you want to delete this sub admin? </p>
                            <label for="sa_name" class="form-label">Sub Admin:</label>
                            <input type="text" id="sa_name" name="sa_name" class="form-control" disabled>
                            <label for="sa_name" class="form-label mt-2">Student Org:</label>
                            <input type="text" id="sa_org" name="sa_org" class="form-control" disabled><br>
                            <input type="hidden" name="sa_id" id="sa_id">
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="cancel-btn" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" form="frm_delete_sub">Yes</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- / Delete Modal -->

        <script>
            var el = document.getElementById("wrapper");
            var toggleButton = document.getElementById("menu-toggle");

            toggleButton.onclick = function() {
                el.classList.toggle("toggled");
            };
        </script>
        <!--Custom JS-->
        <script src="subadmin.js"></script>
    </body>

    </html>
<?php
} else {
    header("Location: ../index.php");
}
?>