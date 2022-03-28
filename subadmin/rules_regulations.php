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

    $stmt = $conn->prepare("SELECT * FROM tbl_org_rules o WHERE o.org_id = :id");
    $stmt->bindParam(':id', $sa_orgid, PDO::PARAM_STR);
    $stmt->execute();
    $studorg = $stmt->fetch(PDO::FETCH_ASSOC);
    $rules = (!empty($studorg['rules'])) ? $studorg['rules'] : '';
    template_header("Rules and Regulations");
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
                    <a href="students.php" class="active list-group-item list-group-item-action bg-transparent second-text fw-bold active">Students</a>
                    <a href="org-struct.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold">Org Structure</a>
                    <a href="partylist.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold">Partylist</a>
                    <a href="candidates.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold">Candidate</a>
                    <a href="rules_regulations.php" class="active list-group-item list-group-item-action bg-transparent second-text fw-bold">Rules & Regulations</a>
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
                        <div class="col-md-12" id="msg"><?php if (isset($_GET['err'])) { ?>
                                <div class="alert alert-danger mt-3" role="alert">
                                    <i class="fas fa-times fs-4 me-3"></i><span><?= $_GET['err'] ?></span>
                                </div>
                            <?php } ?>
                            <?php if (isset($_GET['info'])) { ?>
                                <div class="alert alert-success mt-3" role="alert">
                                    <i class="fas fa-check fs-4 me-3"></i><span><?= $_GET['info'] ?></span>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-9">
                            <p class=""><em>Student Organization: <b><?= $org_name ?> (<?= $org_acr ?>)</b></em></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class=""><button class="btn btn-primary w-25 float-end" id="btn-edit-rules">Rules and Regulations <i class="fas fa-edit"></i></button></div>
                    </div>
                    <div class="row bg-white mx-2 mt-4 p-5 shadow-lg justify-content-around rounded border border-danger border-3">
                        <div class="row" style="font-family: 'Montserrat', sans-serif;">
                            <p class="fw-bolder mb-0" style="font-size: 26px;">Must Read</p><br>
                            <p class="" style="font-size: 16px;">Rules and Regulations</p>
                            <div id="display-section" style="word-wrap: break-word;">
                                <p><?= htmlspecialchars_decode($rules) ?></p>
                            </div>

                        </div>
                        <div class="card card-body col-12 shadow mb-3" id="rules-sec" hidden>
                            <form action="org-rules.php" method="POST">
                                <div class="form-floating">
                                    <textarea id="rules-and-reg" name="rules-and-reg"><?= $rules ?></textarea>
                                </div>
                                <div class="mt-2">
                                    <button type="submit" class="btn btn-primary float-end" name="submit">Save</button>
                                    <button type="button" class="btn btn-secondary float-end me-2" id="btn-close">Close</button>
                                </div>
                            </form>
                        </div>
                    </div>



                </div>
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
            $(document).ready(function() {
                $('.alert').delay(3000).slideUp(200, function() {
                    $(this).alert('close');
                });
                $('#btn-edit-rules').click(function() {
                    $('#btn-edit-rules').prop('hidden', true);
                    $('#rules-sec').prop('hidden', false);
                    $('#display-section').prop('hidden', true);
                });

                $('#btn-close').click(function() {
                    $('#btn-edit-rules').prop('hidden', false);
                    $('#rules-sec').prop('hidden', true);
                    $('#rules-and-reg').summernote('reset');
                    $('span.note-icon-caret').remove();
                    $('#display-section').prop('hidden', false);
                })

                $('#rules-and-reg').summernote({
                    placeholder: 'Place your rules and regulations here.',
                    tabsize: 2,
                    height: 120,
                    lineHeights: ['0.2', '0.3', '0.4', '0.5', '0.6', '0.8', '1.0', '1.2', '1.4', '1.5', '2.0', '3.0'],
                    fontSizes: ['8', '9', '10', '11', '12', '14', '16', '18', '20', '22', '36', '40', '72'],
                    toolbar: [
                        ['style', ['style']],
                        ['font', ['bold', 'underline', 'clear']],
                        ['fontname', ['fontname']],
                        ['fontsize', ['fontsize']],
                        ['color', ['color']],
                        ['para', ['ul', 'ol', 'paragraph', 'height']],
                        ['table', ['table']],
                        ['insert', ['hr']],
                        ['view', ['help']]
                    ],
                    disableDragAndDrop: true,
                    fontNames: ['sans-serif', 'Arial', 'Arial Black', 'Comic Sans MS', 'Courier New', 'Helvetica', 'Impact', 'Lucida Grande', 'Montserrat', 'Tahoma', 'Times New Roman', 'Verdana', 'Sacramento'],
                    callbacks: { //restrict the pasting of images
                        onImageUpload: function(data) {
                            data.pop();
                        }
                    }
                });
                $('span.note-icon-caret').remove();
            });
        </script>
        <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    </body>

    </html>
<?php
} else {
    header("Location: ../index.php");
}
?>