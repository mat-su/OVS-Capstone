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

    $stmt = $conn->prepare("SELECT c.c_id AS cid, c.c_studnum AS studnum, CONCAT(c.c_fname, ' ', c.c_lname) as cname, pa.pname AS party, os.position AS position FROM tbl_candidates c LEFT JOIN tbl_partylist pa ON c.c_party = pa.id LEFT JOIN tbl_org_struct os ON c.c_position = os.id WHERE c.c_orgid = :id");
    $stmt->bindParam(':id', $sa_orgid, PDO::PARAM_INT);
    $stmt->execute();
    $candidates = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt = $conn->prepare("SELECT p.id AS pid, p.pname AS pname, p.p_orgid as org_id FROM tbl_partylist p LEFT JOIN tbl_stud_orgs o ON p.p_orgid = o.org_id WHERE p.p_orgid = :id");
    $stmt->bindParam(':id', $sa_orgid, PDO::PARAM_INT);
    $stmt->execute();
    $partylist = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt = $conn->prepare("SELECT os.id AS osid, os.position AS position, os.seats AS seats FROM tbl_org_struct os LEFT JOIN tbl_stud_orgs o ON os.org_id = o.org_id WHERE os.org_id = :id");
    $stmt->bindParam(':id', $sa_orgid, PDO::PARAM_INT);
    $stmt->execute();
    $org_related = $stmt->fetchAll(PDO::FETCH_ASSOC);
    template_header("Candidates Information");
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
                    <a href="dashboard.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold">Dashboard</a>
                    <a href="students.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold">Students</a>
                    <a href="org-struct.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold">Org Structure</a>
                    <a href="partylist.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold">Partylist</a>
                    <a href="candidates.php" class="active list-group-item list-group-item-action bg-transparent second-text fw-bold">Candidate</a>
                    <a href="rules_regulations.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold">Rules & Regulations</a>
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
                            <p class="fs-4">Candidates Information</p>
                        </div>
                        <div class="col-md-3">
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-success mt-2 mb-3" data-bs-toggle="modal" data-bs-target="#staticBackdropCreate" style="float: right"><i class="fas fa-plus me-2"></i>Create New</button>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table id="candidates_tbl" class="table bg-white rounded shadow-sm  table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Student Number</th>
                                    <th>Name</th>
                                    <th>Partylist</th>
                                    <th>Position</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>

            </div>
            <!-- /#page-content-wrapper -->
        </div>
        <?= template_footer() ?>
        <!--Create Modal -->
        <div class="modal fade" id="staticBackdropCreate" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabelCreate" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabelCreate">Create New Candidate</h5>
                        <button type="button" class="btn-close" id="times" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <form method="post" id="frm_create" action="create-can.php">
                                <div class="row">
                                    <div class="col-md-9">
                                        <label for="studnum" class="form-label">Student Number</label>
                                        <div class="input-group">
                                            <input type="text" maxlength="13" class="form-control mb-2" placeholder="PM-XX-XXXXX-X" name="studnum" id="studnum" required>
                                            <div>
                                                <button id="searchdata" class="btn btn-outline-dark" type="button" disabled><i class="fas fa-search fs-6 me-2"></i>Search</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="getdetails">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="fname" class="form-label">First Name</label>
                                            <input type="text" class="form-control mb-2" placeholder="" name="fname" readonly>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="mname" class="form-label">Middle Name</label>
                                            <input type="text" class="form-control mb-2" placeholder="" name="mname" readonly>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="lname" class="form-label">Last Name</label>
                                            <input type="text" class="form-control mb-2" placeholder="" name="lname" readonly>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="party" class="form-label">Partylist</label>
                                        <select class="form-select" name="party" id="party" form="frm_create" required>
                                            <option value="">--Select Partylist--</option>
                                            <?php foreach ($partylist as $p) : ?>
                                                <option value="<?= $p['pid'] ?>"><?= $p['pname'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="position" class="form-label">Running for</label>
                                        <select class="form-select" name="position" id="position" form="frm_create" required>
                                            <option value="">--Select Position--</option>
                                            <?php foreach ($org_related as $o) : ?>
                                                <option value="<?= $o['osid'] ?>"><?= $o['position'] ?></option>
                                            <?php endforeach; ?>
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
        <!-- /End Create Modal -->
        <!-- View Modal -->
        <div class="modal fade" id="staticBackdropView" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabelView" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabelView">Edit Candidate</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="edit_modal">
                        <div class="container-fluid">
                            <form method="post" id="frm_edit" action="">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="studnum" class="form-label">Student Number</label>
                                        <input type="text" maxlength="13" class="form-control mb-2" placeholder="PM-XX-XXXXX-X" name="studnum" id="studnum" readonly>
                                    </div>
                                </div>
                                <div id="getdetails">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="fname" class="form-label">First Name</label>
                                            <input type="text" class="form-control mb-2" placeholder="" name="fname" readonly>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="mname" class="form-label">Middle Name</label>
                                            <input type="text" class="form-control mb-2" placeholder="" name="mname" readonly>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="lname" class="form-label">Last Name</label>
                                            <input type="text" class="form-control mb-2" placeholder="" name="lname" readonly>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="party" class="form-label">Partylist</label>
                                        <select class="form-select" name="party" id="party" form="frm_edit" required>
                                            <option value="">--Select Partylist--</option>
                                            <?php foreach ($partylist as $p) : ?>
                                                <option value="<?= $p['pid'] ?>"><?= $p['pname'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="position" class="form-label">Running for</label>
                                        <select class="form-select" name="position" id="position" form="frm_edit" required>
                                            <option value="">--Select Position--</option>
                                            <?php foreach ($org_related as $o) : ?>
                                                <option value="<?= $o['osid'] ?>"><?= $o['position'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <input type="hidden" class="form-control mb-2" placeholder="" name="id" hidden>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btn-cancel" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" form="frm_edit">Save</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /End View Modal -->
        <!-- Delete Modal -->
        <div class="modal fade" id="staticBackdropDelete" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabelDelete" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabelDelete">Delete
                            Candidate</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="frm_delete" method="post" action="">
                            <p> Are you sure you want to delete this candidate? </p>
                            <input type="hidden" class="form-control mb-2" placeholder="" name="id" hidden>
                            <label for="candidate" class="form-label">Candidate Name</label>
                            <input type="text" class="form-control mb-2" placeholder="" name="candidate" readonly>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btn-cancel" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" form="frm_delete" class="btn btn-primary">Yes</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /End Delete Modal -->
        <script>
            var el = document.getElementById("wrapper");
            var toggleButton = document.getElementById("menu-toggle");

            toggleButton.onclick = function() {
                el.classList.toggle("toggled");
            };
        </script>
        <!-- Custom JS script -->
        <script src="candidates.js"></script>
    </body>

    </html>
<?php
} else {
    header("Location: ../index.php");
}
?>