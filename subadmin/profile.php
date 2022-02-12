<?php
include '../functions.php';
session_start();
$conn = MYSQL_DB_Connection();

if (isset($_SESSION['sa_id']) && isset($_SESSION['sa_email'])) {
    $id = $_SESSION['sa_id'];
    $stmt = $conn->prepare("SELECT sa_fname, sa_mname, sa_lname FROM tbl_subadmin WHERE sa_id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);
    $fname = $admin['sa_fname'];
    $mname = $admin['sa_mname'];
    $lname = $admin['sa_lname'];

    template_header("My Profile");
?>

    <body>
        <!--Contacts Section-->
        <nav class="navbar navbar-expand text-white py-0" style="background-color: #000000;">
            <div class="container-fluid">
                <ul class="navbar-nav ">
                    <li class="nav-item py-2">
                        <small>PAMANTASAN NG LUNGSOD NG MARIKINA</small>
                    </li>
                </ul>
                <ul class="navbar-nav collapse navbar-collapse justify-content-end">
                    <li class="nav-item"><span class="text-white">|</span></li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="dashboard.php"><small>Home</small></a>
                    </li>
                </ul>
            </div>
        </nav>
        <div class="container col col-md-6 offset-md-3 mt-3">
            <span class="fs-3">Sub Administrator Account</span>
        </div>
        <div class="container mt-3 mb-5">
            <div class="row">
                <div class="col col-md-6 offset-md-3 mb-4">
                    <div class="card rounded shadow mt-3">
                        <div class="card-body mt-2">
                            <p class="display-5 fs-5">Basic Information</p>
                            <table class="table table-bordered table-striped mt-3">
                                <colgroup>
                                    <col span="1" style="width: 30%;">
                                    <col span="1" style="width: 80%;">
                                </colgroup>
                                <tbody>
                                    <tr>
                                        <td>First Name</td>
                                        <td><?= $fname ?></td>
                                    </tr>
                                    <tr>
                                        <td>Middle Name</td>
                                        <td><?= $mname ?></td>
                                    </tr>
                                    <tr>
                                        <td>Last Name</td>
                                        <td><?= $lname ?></td>
                                    </tr>
                                </tbody>
                            </table>
                            <button class="btn btn-primary float-end mt-3" data-bs-toggle="modal" data-bs-target="#modalUP">Update Profile</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="modalUP" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">Update Profile</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p id="frmMessage"></p>
                            <form action="update-profile.php" method="POST" id="frmUP">
                                <label for="fname" class="form-label">First Name</label>
                                <input type="text" class="form-control mb-2" placeholder="" value="<?= $fname ?>" name="fname" id="fname" required>
                                <label for="mname" class="form-label">Middle Name</label>
                                <input type="text" class="form-control mb-2" placeholder="" name="mname" id="mname" value="<?= $mname ?>" >
                                <label for="lname" class="form-label">Last Name</label>
                                <input type="text" class="form-control mb-2" placeholder="" name="lname" id="lname" value="<?= $lname ?>" required>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" id="btnUP" form="frmUP" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br><br><br><br><br><br><br><br><br>
        <?php template_footer() ?>
        <script>
            $(document).ready(function() {
                $('#modalUP').on('hidden.bs.modal', function() {
                    //$(this).find('form').trigger('reset');
                    $(this).find('.alert').remove();
                    location.reload();
                });

                $.validator.addMethod("validateName", function(value, element) {
                    const regexName = /^[a-zA-Z]+(([',. -][a-zA-Z ])?[a-zA-Z]*)*$/;
                    return this.optional(element) || regexName.test(value);
                });

                $('#frmUP').validate({
                    rules: {
                        fname: {
                            required: true,
                            validateName: true
                        },
                        mname: {
                            validateName: true
                        },
                        lname: {
                            required: true,
                            validateName: true
                        }
                    },
                    messages: {
                        fname: {
                            required: "Please enter your firstname",
                            validateName: "Please enter a valid first name"
                        },
                        mname: {
                            validateName: "Please enter a valid middle name"
                        },
                        lname: {
                            required: "Please enter your lastname",
                            validateName: "Please enter a valid last name"
                        },
                        org: "Please select a student organization",
                    },
                    highlight: function(element, errorClass, validClass) {
                        $(element).addClass("is-invalid").removeClass("is-valid");
                    },
                    unhighlight: function(element, errorClass, validClass) {
                        $(element).addClass("is-valid").removeClass("is-invalid");
                    },
                    wrapper: "div",
                    submitHandler: function() {
                        var fname = $('#fname').val().trim();
                        var mname = $('#mname').val().trim();
                        var lname = $('#lname').val().trim();
                        var submit = $('#btnUP').val();
                        var adminID = '<?= ($id) ?>';
                        $('#frmMessage').load("update-profile.php", {
                            fname: fname,
                            mname: mname,
                            lname: lname,
                            submit: submit,
                            adminID: adminID
                        });
                    }
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