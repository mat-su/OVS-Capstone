<?php
include '../functions.php';
session_start();
$conn = MYSQL_DB_Connection();

if (isset($_SESSION['sa_id']) && isset($_SESSION['sa_email'])) {

    $sa_orgid = $_SESSION['sa_org_id'];
    $sa_fname = $_SESSION['sa_fname'];
    $sa_lname = $_SESSION['sa_lname'];
    $stmt = $conn->prepare("SELECT * FROM tbl_stud_orgs o WHERE o.org_id = :id");
    $stmt->bindParam(':id', $sa_orgid, PDO::PARAM_INT);
    $stmt->execute();
    $org = $stmt->fetch(PDO::FETCH_ASSOC);
    $org_name = $org['org_name'];
    $org_acr = $org['org_acronym'];


    $org_related = fetchAll_OrgStructure($sa_orgid);
    template_header("Organization Structure");
?>

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
                    <a href="dashboard.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold">Dashboard</a>
                    <a href="org-struct.php" class="active list-group-item list-group-item-action bg-transparent second-text fw-bold">Org Structure</a>
                    <a href="partylist.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold">Partylist</a>
                    <a href="candidates.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold">Candidate</a>
                </div>
            </div>
            <!-- /#sidebar-wrapper -->

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
                                    <li><a class="dropdown-item" href="profile.php">Profile</a></li>
                                    <li><a class="dropdown-item" href="settings.php">Settings</a></li>
                                    <li><a class="dropdown-item" href="../logout.php">Logout</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>
                <div class="container-fluid px-4 my-2">
                    <div class="row">
                        <div class="col-md-12" id="msg"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-9">
                            <p class=""><em>Student Organization: <b><?= $org_name ?> (<?= $org_acr ?>)</b></em></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-9">
                            <p class="fs-4">Organization Structure Information</p>
                        </div>
                        <div class="col-md-3">
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-success mt-2 mb-3" data-bs-toggle="modal" data-bs-target="#staticBackdropCreate" style="float: right"><i class="fas fa-plus me-2"></i>Create New</button>


                        </div>
                    </div>

                    <div class="table-responsive">
                        <table id="org_struct_tbl" class="table bg-white rounded shadow-sm  table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Position</th>
                                    <th>Seat</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>

            </div>
            <!-- /#page-content-wrapper -->
        </div>
        <!--Create Modal -->
        <div class="modal fade" id="staticBackdropCreate" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabelCreate" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabelCreate">Create New Position</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <form method="post" id="frm_create" action="save_new_pos.php">
                                <div class="row">
                                    <div class="col-md-12" id="IP1">
                                        <label for="position" class="form-label">Position</label>
                                        <input type="text" class="form-control mb-2" placeholder="" name="position" id="position" required>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12" id="DrpDwn1">
                                        <label for="seats" class="form-label">Seats</label>
                                        <select class="form-select mb-2" aria-label="Default select example" name="seats" id="seats" form="frm_create">
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                        </select>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btn-cancel" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" form="frm_create">Save</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Create Modal -->
        <!-- Edit Modal -->
        <div class="modal fade" id="staticBackdropView" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabelView" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabelView">Edit Position</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="post" id="frm_edit" action="update_pos.php">
                            <input type="hidden" name="pos_id">
                            <div class="row">
                                <div class="col-md-12" id="IP2">
                                    <label for="position" class="form-label">Position</label>
                                    <input type="text" class="form-control mb-2" placeholder="" name="position" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12" id="DrpDwn2">
                                    <label for="seats" class="form-label">Seats</label>
                                    <select class="form-select mb-2" aria-label="Default select example" name="seats" id="seats" form="frm_edit">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btn-cancel" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" form="frm_edit">Edit</button>
                    </div>
                </div>
            </div>
        </div>
        <!--End Edit Modal-->
        <!--Delete Modal -->
        <div class="modal fade" id="staticBackdropDelete" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabelDelete" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabelDelete">Delete
                            Position</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="frm_delete" method="post" action="delete_pos.php">
                            <p> Are you sure you want to delete this position? </p>
                            <label class="form-label" for="position">Position:</label>
                            <input class="form-control" type="text" name="position" readonly>
                            <input type="hidden" name="pos_id">
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btn-cancel" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" form="frm_delete" class="btn btn-primary">Yes</button>
                    </div>
                </div>
            </div>
        </div>
        <!--End Delete Modal--->
        <?= template_footer() ?>
        <script>
            var el = document.getElementById("wrapper");
            var toggleButton = document.getElementById("menu-toggle");

            toggleButton.onclick = function() {
                el.classList.toggle("toggled");
            };
        </script>
        <!--Custom JS-->
        <script src="structure.js"></script>
    </body>

    </html>
<?php
} else {
    header("Location: ../index.php");
}
?>