<?php
session_start();

if (isset($_SESSION['a_id']) && isset($_SESSION['a_email'])) {
    include '../functions.php';
    $conn = MYSQL_DB_Connection();
    $id = $_SESSION['a_id'];

    template_header("Create Successor");
?>

    <body>
        <div class="container col col-md-6 offset-md-3 mt-3">
            <a class="float-end text-dark" href="dashboard.php">Back</a>
        </div>
        <div class="mt-5" style="visibility: hidden;">null</div>
        <div class="container col col-md-12 text-center"><b class="fs-3">Create Successor</b>
            
        </div>

        <div class="container mt-3 mb-5">
            <div class="col col-md-6 offset-md-3 mb-4">
                <div class="card rounded shadow mt-3">
                    <div class="card-body mt-2 p-4">
                        <div class="d-flex justify-content-center" id="loader_section">
                            <div class="lds-ellipsis" id="loader">
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                            </div>
                        </div>
                        <div id="getDetails"></div>
                        <form action="mail_new_admin.php" method="POST" id="frmCA">
                            <label for="fname" class="form-label">First Name</label>
                            <input type="text" class="form-control mb-2" placeholder="" name="fname" id="fname" required>
                            <label for="mname" class="form-label">Middle Name</label>
                            <input type="text" class="form-control mb-2" placeholder="" name="mname" id="mname">
                            <label for="lname" class="form-label">Last Name</label>
                            <input type="text" class="form-control mb-2" placeholder="" name="lname" id="lname" required>
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control mb-2" placeholder="" name="email" id="email" value="" required>
                        </form>
                    </div>
                    <div class="card-footer p-3">
                        <button type="submit" id="btnCA" form="frmCA" class="btn btn-primary float-end">Create Successor</button>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <script>
            $(document).ready(function() {
                $('#loader').fadeOut(400);

                $('#frmCA').validate({
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
                            validateName: "Please enter a valid firstname"
                        },
                        lname: {
                            required: "Please enter your lastname",
                            validateName: "Please enter a valid lastname"
                        },
                        mname: {
                            validateName: "Please enter a valid middlename"
                        },
                        email: {
                            required: "Please enter your valid email address"
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
                        var fname = $('#fname').val().trim();
                        var mname = $('#mname').val().trim();
                        var lname = $('#lname').val().trim();
                        var email = $('#email').val().trim();
                        var submit = $('#btnCA').val();
                        $('#btnCA').text('').prop('disabled', true).append('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Creating...');;
                        $('#loader').show();

                        $('#getDetails').load("mail_new_admin.php", {
                            fname: fname,
                            mname: mname,
                            lname: lname,
                            email: email,
                            submit: submit
                        });
                    }
                });
                $.validator.addMethod("validateEmail", function(value, element) {
                    const regexEmail = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                    return regexEmail.test(value);
                }, "Please enter a valid email address.");

                $.validator.addMethod("validateName", function(value, element) {
                    const regexName = /^[a-zA-ZÑñ ]+(([',. -][a-zA-Z Ññ])?[a-zA-ZÑñ]*)*$/;
                    return this.optional(element) || regexName.test(value);
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