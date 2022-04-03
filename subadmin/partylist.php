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

    template_header("Partylist Information");
?>

    <body>
        <div class="d-flex" id="wrapper">
            <!-- Sidebar -->
            <div class="bg-white" id="sidebar-wrapper">
                <div class="pt-5 text-center">
                    <h3><b>MENU</b></h3>
                </div>
                <div class="list-group list-group-flush my-3">
                    <a href="dashboard.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold">Dashboard</a>
                    <a href="students.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold">Students</a>
                    <a href="org-struct.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold">Org Structure</a>
                    <a href="partylist.php" class="active list-group-item list-group-item-action bg-transparent second-text fw-bold">Partylist</a>
                    <a href="candidates.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold">Candidate</a>
                    <a href="rules_regulations.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold">Rules & Regulations</a>
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
                        <h2>SUB ADMIN PORTAL</h2>
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
                        <div class="col-md-12" id="msg"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-9">
                            <p class=""><em>Student Organization: <b><?= $org_name ?> (<?= $org_acr ?>)</b></em></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-9">
                            <p class="fs-4">Partylist Information</p>
                        </div>
                        <div class="col-md-3">
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-success mt-2 mb-3" data-bs-toggle="modal" data-bs-target="#staticBackdropCreate" style="float: right"><i class="fas fa-plus me-2"></i>Create New</button>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table id="partylist_tbl" class="table bg-white rounded shadow-sm  table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Partylist Name</th>
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
                        <h5 class="modal-title" id="staticBackdropLabelCreate">Create New Partylist</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <form method="post" id="frm_create" action="save_new_party.php">
                                <div class="col-md-12">
                                    <label for="partylist" class="form-label">Partylist Name</label>
                                    <input type="text" class="form-control mb-2" placeholder="" name="partylist" required>
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
        <!--/End Create Modal -->
        <!-- Edit Modal -->
        <!-- Modal -->
        <div class="modal fade" id="staticBackdropView" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabelView" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabelView">Edit Partylist</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <form method="post" id="frm_edit" action="update_party.php">
                                <div class="col-md-12">
                                    <input type="hidden" class="form-control mb-2" name="id">
                                    <label for="partylist" class="form-label">Partylist Name</label>
                                    <input type="text" class="form-control mb-2" placeholder="" name="partylist" required>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btn-cancel" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" form="frm_edit">Edit</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /End Edit Modal -->
        <!-- Delete Modal -->
        <div class="modal fade" id="staticBackdropDelete" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabelDelete" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabelDelete">Delete
                            Partylist</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="frm_delete" method="post" action="delete_party.php">
                            <input type="hidden" class="form-control mb-2" name="id">
                            <p> Are you sure you want to delete this party? </p>
                            <label for="partylist" class="form-label">Partylist Name</label>
                            <input type="text" class="form-control mb-2" placeholder="" name="partylist" readonly>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btn-cancel" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" form="frm_delete" class="btn btn-primary">Yes</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /End Delete Modal-->
        <script>
            var el = document.getElementById("wrapper");
            var toggleButton = document.getElementById("menu-toggle");

            toggleButton.onclick = function() {
                el.classList.toggle("toggled");
            };
        </script>
        <!--Custom JS-->
        <script src="partylist.js"></script>
    </body>

    </html>
<?php
} else {
    header("Location: ../index.php");
}
?>