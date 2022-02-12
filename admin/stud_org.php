<?php
session_start();
if (isset($_SESSION['a_id']) && isset($_SESSION['a_email'])) {
    include '../functions.php';
    $conn = MYSQL_DB_Connection();

    $orgs = $conn->query("SELECT o.org_id AS org_id, CONCAT(o.org_name, ' (', o.org_acronym, ')') AS Org_Name, CONCAT(s.sa_fname, ' ', s.sa_lname) AS 'Adviser', c.id, CONCAT(c.course, ' (', c.acronym, ')') AS CourseName FROM tbl_stud_orgs o LEFT JOIN tbl_subadmin s ON org_id = s.sa_org_id LEFT JOIN tbl_course c ON o.org_course_id = c.id");

    $courses = $conn->query("SELECT id, CONCAT(course, ' (', acronym, ')') AS name FROM tbl_course");

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
        <title>Manage Stud Org</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
        <link rel="stylesheet" href="../assets/bootstrap/css/style.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <!--Logo-->
        <link rel="shortcut icon" type="image/jpg" href="https://ik.imagekit.io/nwlfpk0xpdg/img/tr:w-50,h-50/logo-png_Xt7bTS_7o.png?ik-sdk-version=javascript-1.4.3&updatedAt=1636213481504" />
        <script>
            $(document).ready(function() {
                $(document).on('click', '.linkview', function() {
                    var org_id = $(this).attr("id");
                    $.ajax({
                        url: "view-org.php",
                        method: "POST",
                        data: {
                            org_id: org_id
                        },
                        success: function(data) {
                            $('#edit_modal').html(data);
                            $('#staticBackdropView').modal('show');
                        }
                    });
                });
                $(document).on('click', '.linktrash', function() {
                    var org_id = $(this).attr("id");
                    $.ajax({
                        url: "delete-org.php",
                        method: "POST",
                        data: {
                            org_id: org_id
                        },
                        success: function(data) {
                            $('#delete_modal').html(data);
                            $('#staticBackdropDelete').modal('show');
                        }
                    });
                });
                $('#staticBackdropCreate').on('hidden.bs.modal', function() {
                    $(this).find('form').trigger('reset');
                });
            })
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
                    <a href="stud_org.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold active"><i class="fas fa-sitemap me-2"></i>Stud Orgs</a>
                    <a href="v_sched.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i class="far fa-calendar-alt fs-5 me-2"></i></i>Voting Schedule</a>
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
                            <p class="fs-4">Student Organization Information</p>
                        </div>
                        <div class="col-md-3">
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-success mt-2 mb-3" data-bs-toggle="modal" data-bs-target="#staticBackdropCreate" style="float: right"><i class="fas fa-plus me-2"></i>Create</button>

                            <!-- Modal -->
                            <div class="modal fade" id="staticBackdropCreate" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabelCreate" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="staticBackdropLabelCreate">Create New Student
                                                Organization</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="container-fluid">
                                                <form method="post" id="create" action="create-org.php">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <label for="org_name" class="form-label">Organization Name</label>
                                                            <input type="text" class="form-control mb-2" placeholder="" name="org_name" required>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <label for="org_acronym" class="form-label">Organization Acronym</label>
                                                            <input type="text" class="form-control mb-2" placeholder="" name="org_acronym" required>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class=" col-md-12">
                                                            <label for="" class="form-label">Course</label>
                                                            <select class="form-select mb-2" aria-label="Default select example" form="create" name="course_id" required>
                                                                <option value="" selected>--Select Course--</option>
                                                                <?php foreach ($courses as $c) : ?>
                                                                    <option value="<?= $c['id'] ?>"><?= $c['name'] ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-primary" form="create">Save</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- />Modal -->
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table id="example" class="table bg-white rounded shadow-sm  table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Org Name</th>
                                    <th>Course</th>
                                    <th>Adviser</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($orgs as $org) : ?>
                                    <tr>
                                        <td><?= $org['Org_Name'] ?></td>
                                        <td><?= $org['CourseName'] ?></td>
                                        <td><?= $org['Adviser'] ?></td>
                                        <td class="actions">
                                            <a href="" class="linkview" title="View Org" data-bs-toggle="modal" id="<?= $org['org_id'] ?>" data-bs-target="#staticBackdropView"><i class="fas fa-eye fa-xs fs-5"></i></a>
                                            <!-- Modal -->
                                            <div class="modal fade" id="staticBackdropView" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabelView" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="staticBackdropLabelView">Student
                                                                Organization</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body" id="edit_modal">
                                                            ...
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary" form="edit">Edit</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <a href="" class="linktrash" title="Delete Org" data-bs-toggle="modal" id="<?= $org['org_id'] ?>" data-bs-target="#staticBackdropDelete"><i class="fas fa-trash fa-xs fs-5"></i></a>
                                            <!-- Modal -->
                                            <div class="modal fade" id="staticBackdropDelete" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabelDelete" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="staticBackdropLabelDelete">Delete
                                                                Student Organization</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body" id="delete_modal">
                                                            ...
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                            <button type="submit" form="trash" class="btn btn-primary">Yes</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    <?php endforeach; ?>
                                    </tr>
                            </tbody>
                        </table>
                    </div>
                </div>


            </div>
        </div>
        <!-- /#page-content-wrapper -->
        </div>
        <?= template_footer() ?>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>

        <script type="text/javascript" src=" https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.min.js"></script>


        <script>
            var el = document.getElementById("wrapper");
            var toggleButton = document.getElementById("menu-toggle");

            toggleButton.onclick = function() {
                el.classList.toggle("toggled");
            };


            $(document).ready(function() {
                $('#example').DataTable({
                    "columnDefs": [{
                        "width": "40%",
                        "targets": [0, 1, 2]
                    }, {
                        "orderable": false,
                        "targets": [3]
                    }],
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