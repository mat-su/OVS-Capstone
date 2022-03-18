<?php
include '../functions.php';
session_start();
$conn = MYSQL_DB_Connection();

if (isset($_SESSION['v_id']) && isset($_SESSION['v_email'])) {
    $id = $_SESSION['v_id'];
    $stmt = $conn->prepare("SELECT v_email, v_password FROM tbl_voter WHERE v_id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);
    $email = $admin['v_email'];
    $password = $admin['v_password'];
?>
    <!doctype html>
    <html lang="en">

    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Settings</title>

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic">
        <link rel="stylesheet" href="../assets/fonts/font-awesome.min.css">

        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <!--JQuery Validation PlugIn-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.js"></script>
        <script>
            $(document).ready(function() {
                $('#modalCE, #modalCU, #modalCP').on('hidden.bs.modal', function() {
                    //$(this).find('form').trigger('reset');
                    $(this).find('.alert').remove();
                    location.reload();
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
                        var voterID = '<?= ($id) ?>';
                        $('#frmMessage1').load("change-email.php", {
                            newEmail: newEmail,
                            submit: submit,
                            voterID: voterID
                        });
                    }
                });

                $.validator.addMethod("validateEmail", function(value, element) {
                    const regexEmail = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                    return regexEmail.test(value);
                }, "Please enter a valid email address.");

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
                    wrapper: "div",
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
                        var voterID = '<?= ($id) ?>';
                        $('#frmMessage2').load("change-pass.php", {
                            curPass: curPass,
                            newPass: newPass,
                            rnewPass: rnewPass,
                            submit: submit,
                            voterID: voterID
                        });
                    }
                });

            });
        </script>
    </head>

    <body>
        <style>
            #newEmail-error,
            #curPass-error,
            #newPass-error,
            #rnewPass-error {
                color: red;
                font-style: italic;
                font-size: 15px;
            }
        </style>
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
        <div class="container col col-md-6 offset-md-3 mt-3"><span class="fs-3">Voter Account</span>
        </div>
        <div class="container mt-3 mb-5">
            <div class="row">
                <div class="col col-md-6 offset-md-3 mb-4">
                    <div class="card rounded shadow mt-3">
                        <div class="card-body mt-2">
                            <p class="display-5 fs-5">Account Settings</p>
                            <table class="table table-bordered table-striped mt-3">
                                <colgroup>
                                    <col span="1" style="width: 30%;">
                                    <col span="1" style="width: 80%;">
                                </colgroup>
                                <tbody>
                                    <tr>
                                        <td>Email</td>
                                        <td><?= $email ?></td>
                                        <td><button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCE">Change</button></td>
                                    </tr>
                                </tbody>
                            </table>
                            <button class="btn btn-primary float-end mt-3" data-bs-toggle="modal" data-bs-target="#modalCP">Change Password</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal1-->
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

        <!-- Modal2-->
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
                            <label for="curPass" class="form-label">Current Password</label>
                            <input type="password" class="form-control mb-2" placeholder="" name="curPass" id="curPass" required>
                            <label for="newPass" class="form-label">New Password</label>
                            <input type="password" class="form-control mb-2" placeholder="" name="newPass" id="newPass" required>
                            <label for="rnewPass" class="form-label">Retype New Password</label>
                            <input type="password" class="form-control mb-2" placeholder="" name="rnewPass" id="rnewPass" required>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" id="btnCP" form="frmNewPass" class="btn btn-primary">Change Password</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Option 1: Bootstrap Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>


    </body>

    </html>
<?php
} else {
    header("Location: ../index.php");
}
?>