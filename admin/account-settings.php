<?php
session_start();
if (isset($_SESSION['a_id']) && isset($_SESSION['a_email'])) {
    include '../functions.php';
    $conn = MYSQL_DB_Connection();
    $id = $_SESSION['a_id'];
    $stmt = $conn->prepare("SELECT a_fname, a_mname, a_lname, a_username, a_email, DATE_FORMAT(a_date_created, '%m/%d/%Y') as cdate FROM tbl_admin WHERE a_id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_STR);
    $stmt->execute();
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);
    $fname = $admin['a_fname'];
    $mname = $admin['a_mname'];
    $lname = $admin['a_lname'];
    $username = $admin['a_username'];
    $email = $admin['a_email'];
    $date = $admin['cdate'];

    template_header("Account Settings");

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
        <div class="container col col-md-6 offset-md-3 mt-3"><span class="fs-3">Administrator Account</span>
            <div id="getDetails"></div>
        </div>
        <div class="container mt-3 mb-5">
            <div class="row">
                <div class="col col-md-6 offset-md-3 mb-4">
                    <div class="card rounded shadow mt-3">
                        <div class="card-body mt-2 table-responsive">
                            <p class="display-5 fs-5">Account Information</p>
                            <table class="table table-bordered table-striped mt-3">
                                <colgroup>
                                    <col span="1" style="width: 30%;">
                                    <col span="1" style="width: 45%;">
                                    <col span="1" style="width: 30%;">
                                </colgroup>
                                <tbody>
                                    <tr>
                                        <td>Account ID</td>
                                        <td colspan="2" id="adminID"><?= $id ?></td>
                                    </tr>
                                    <tr>
                                        <td>Date Created</td>
                                        <td colspan="2"><?= $date ?></td>
                                    </tr>
                                    <tr>
                                        <td>Status</td>
                                        <td><i class="fa fa-check-square text-success"></i> Active </td>
                                        <td><button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalSuspend"><i class="fa fa-exclamation"></i> End</button></td>
                                    </tr>
                                    <tr>
                                        <td>Username</td>
                                        <td><?= $username ?></td>
                                        <td><button class="btn btn-primary btn-block" data-bs-toggle="modal" data-bs-target="#modalCU">Change</button></td>
                                    </tr>
                                    <tr>
                                        <td>Email Address</td>
                                        <td><?= $email ?></td>
                                        <td><button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCE">Change</button></td>
                                    </tr>
                                </tbody>
                            </table>
                            <button id="btnCP" class="btn btn-primary float-end mt-3" data-bs-toggle="modal" data-bs-target="#modalCP">Change Password</button>
                        </div>
                    </div>
                </div>
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
        </div>

        <!-- Modal1-->
        <div class="modal fade" id="modalSuspend" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Close My Account</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        You will be removed from the system and so lose access if you perform this procedure.<br><br>

                        NOTE: Because you are the only one with access to the system, you must first set up a successor and have the successor approve the request before proceeding to this operation.
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" id="btnUnderstood" class="btn btn-primary">Understood</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal2-->
        <div class="modal fade" id="modalCE" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Change Email Address</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p id="frmMessage1"></p>
                        <form action="change-email.php" method="POST" id="frmNewEmail">
                            <label for="newEmail" class="form-label">New Email Address</label>
                            <input type="email" class="form-control mb-2" placeholder="" name="newEmail" id="newEmail" required>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" id="btnCE" form="frmNewEmail" class="btn btn-primary">Change Email</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal3-->
        <div class="modal fade" id="modalCP" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Change Password</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p id="frmMessage2"></p>
                        <form action="change-pass.php" method="POST" id="frmNewPass">
                            <div class="col-12">
                                <label for="curPass" class="form-label">Current Password</label>
                                <input type="password" class="form-control mb-2" placeholder="" name="curPass" id="curPass" required>
                            </div>
                            <div class="col-12">
                                <label for="newPass" class="form-label">New Password</label>
                                <input type="password" class="form-control mb-2" placeholder="" name="newPass" id="newPass" required>
                            </div>
                            <div class="col-12">
                                <label for="rnewPass" class="form-label">Re-type New Password</label>
                                <input type="password" class="form-control mb-2" placeholder="" name="rnewPass" id="rnewPass" required>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" id="btnCP" form="frmNewPass" class="btn btn-primary">Change Password</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal4-->
        <div class="modal fade" id="modalCU" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Change Username</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p id="frmMessage3"></p>
                        <form action="change-uname.php" method="POST" id="frmNewUname" <label for="newUname" class="form-label">New Username</label>
                            <input type="text" class="form-control mb-2 mt-2" placeholder="" name="newUname" id="newUname" required>
                            <span id="result"></span>
                            <p class="" style="font-size: 14px;">
                                <strong>Username Requirements:</strong><br>
                                1. Username may consists of alphanumeric characters, lowercase, or uppercase.<br>
                                2. Username allowed of the dot (.), underscore (_), and hyphen (-).<br>
                                3. The dot (.), underscore (_), or hyphen (-) must not be the first or last character.<br>
                                4. The dot (.), underscore (_), or hyphen (-) does not appear consecutively.<br>
                                5. The number of characters must be between 5 to 32.<br>

                            </p>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" id="btnCU" form="frmNewUname" class="btn btn-primary">Change Username</button>
                    </div>
                </div>
            </div>
        </div>


        <!-- Modal5-->
        <div class="modal fade" id="modalUP" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Update Profile</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p id="frmMessage4"></p>
                        <form action="update-profile.php" method="POST" id="frmUP">
                            <div class="col-12">
                                <label for="fname" class="form-label">First Name</label>
                                <input type="text" class="form-control mb-2" placeholder="" value="<?= $fname ?>" name="fname" id="fname" required>
                            </div>
                            <div class="col-12">
                                <label for="mname" class="form-label">Middle Name</label>
                                <input type="text" class="form-control mb-2" placeholder="" name="mname" id="mname" value="<?= $mname ?>">
                            </div>
                            <div class="col-12">
                                <label for="lname" class="form-label">Last Name</label>
                                <input type="text" class="form-control mb-2" placeholder="" name="lname" id="lname" value="<?= $lname ?>" required>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" id="btnUP" form="frmUP" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </div>
        </div>
        <br><br><br><br><br>
        <?= template_footer() ?>
        
        <script>
            $(document).ready(function() {
                $('#btnUnderstood').click(function() {
                    $.ajax({
                        url: "suspend.php",
                        success: function(response) {
                            $("#getDetails").html(response);
                            $('#modalSuspend').modal('toggle');
                        }
                    });
                });

                $('#modalCE, #modalCP, #modalCU, #modalUP').on('hidden.bs.modal', function() {
                    //$(this).find('form').trigger('reset');
                    $(this).find('.alert').remove();
                    location.reload();
                });

                $('#newUname').keyup(function() {
                    var newUname = $('#newUname').val();
                    var unameRegex = /^[a-zA-Z]([._-](?![._-])|[a-zA-Z0-9]){3,30}[a-zA-Z0-9]$/;
                    var isValid = newUname.match(unameRegex);
                    if (isValid && newUname.length > 0) {
                        $('#result').html("<span class=\"text-success\"><i class=\"fa fa-check fs-6 me-2\"></i><small>Valid Username</small></span>");
                        $('#btnCU').prop('disabled', false);
                    } else if (newUname.length == 0) {
                        $('#result').html("");
                    } else {
                        $('#result').html("<span class=\"text-danger\"><i class=\"fa fa-times fs-6 me-2\"></i><small>Invalid Username</small></span>");
                        $('#btnCU').prop('disabled', true);
                    }
                });

            });

            $('#frmUP').validate({
                rules: {
                    fname: {
                        required: true,
                        validateName: true
                    },
                    lname: {
                        required: true,
                        validateName: true
                    },
                    email: {
                        required: true,
                        validateEmail: true
                    },
                    mname: {
                        validateName: true
                    }
                },
                messages: {
                    fname: {
                        required: "Please enter your firstname",
                        validateName: "Please enter a valid first name"
                    },
                    lname: {
                        required: "Please enter your lastname",
                        validateName: "Please enter a valid last name"
                    },
                    mname: {
                        validateName: "Please enter a valid middle name"
                    },
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass("is-invalid").removeClass("is-valid");
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).addClass("is-valid").removeClass("is-invalid");
                },
                submitHandler: function() {
                    var fname = $('#fname').val().trim();
                    var mname = $('#mname').val().trim();
                    var lname = $('#lname').val().trim();
                    var submit = $('#btnUP').val();
                    var adminID = '<?= ($id) ?>';
                    $('#frmMessage4').load("update-profile.php", {
                        fname: fname,
                        mname: mname,
                        lname: lname,
                        submit: submit,
                        adminID: adminID
                    });
                }
            });

            $('#frmNewUname').validate({
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass("is-invalid").removeClass("is-valid");
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).addClass("is-valid").removeClass("is-invalid");
                },
                submitHandler: function() {
                    var newUname = $('#newUname').val();
                    var submit = $('#btnCU').val();
                    var adminID = '<?= ($id) ?>';
                    $('#frmMessage3').load("change-uname.php", {
                        newUname: newUname,
                        submit: submit,
                        adminID: adminID
                    });
                }
            });
            $('#frmNewPass').validate({
                rules: {
                    curPass: "required",
                    newPass: "required",
                    rnewPass: {
                        required: true,
                        equalTo: "#newPass"
                    }
                },
                messages: {
                    rnewPass: {
                        equalTo: "Retype new password not matched!",
                    }
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass("is-invalid").removeClass("is-valid");
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).addClass("is-valid").removeClass("is-invalid");
                },
                submitHandler: function() {
                    var curPass = $('#curPass').val().trim();
                    var newPass = $('#newPass').val().trim();
                    var rnewPass = $('#rnewPass').val().trim();
                    var submit = $('#btnCP').val();
                    var adminID = '<?= ($id) ?>';
                    $('#frmMessage2').load("change-pass.php", {
                        curPass: curPass,
                        newPass: newPass,
                        rnewPass: rnewPass,
                        submit: submit,
                        adminID: adminID
                    });
                }
            });
            $('#frmNewEmail').validate({
                rules: {
                    newEmail: {
                        validateEmail: true
                    },
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass("is-invalid").removeClass("is-valid");
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).addClass("is-valid").removeClass("is-invalid");
                },
                submitHandler: function() {
                    var newEmail = $('#newEmail').val().trim();
                    var submit = $('#btnCE').val();
                    var adminID = '<?= ($id) ?>';
                    $('#frmMessage1').load("change-email.php", {
                        newEmail: newEmail,
                        submit: submit,
                        adminID: adminID
                    });
                }
            });
            $.validator.addMethod("validateEmail", function(value, element) {
                const regexEmail = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                return regexEmail.test(value);
            }, "Please enter a valid email address.");
            $.validator.addMethod("validateName", function(value, element) {
                const regexName = /^[a-zA-Z]+(([',. -][a-zA-Z ])?[a-zA-Z]*)*$/;
                return this.optional(element) || regexName.test(value);
            });
        </script>
    </body>

    </html>
<?php
} else {
    header("Location: ../index.php");
}
?>