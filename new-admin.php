<?php
include 'functions.php';
$conn = MYSQL_DB_Connection();
if (isset($_GET['continue'])) {
    $id = $_GET['continue'];
    $c = strlen($id) - 7;
    $realID = substr($id, 0, $c);
    $stmt = $conn->prepare("SELECT * FROM tbl_pending_newadmin WHERE id = :id");
    $stmt->bindParam(':id', $realID, PDO::PARAM_STR);
    $stmt->execute();
    if ($stmt->rowCount() == 1) {
        $pending_admin = $stmt->fetch(PDO::FETCH_ASSOC);
        $fname = $pending_admin['fname'];
        $mname = $pending_admin['mname'];
        $lname = $pending_admin['lname'];
        $email = $pending_admin['email'];
    } else {
        $fname = "";
        $mname = "";
        $lname = "";
        $email = "";
    }
} else {
    $fname = "";
    $mname = "";
    $lname = "";
    $email = "";
    $realID = "";
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--Tab Logo-->
    <link rel="shortcut icon" type="image/jpg" href="https://ik.imagekit.io/nwlfpk0xpdg/img/tr:w-50,h-50/ovs_logo_x6ne_tPjZ7.jpg?ik-sdk-version=javascript-1.4.3&updatedAt=1648299575563" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic">
    <!--FontAwesome Kit-->
    <script src="https://kit.fontawesome.com/8acebfc2d4.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Create Admin Account</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <!--JQuery Validation PlugIn-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.js"></script>
    <script>
        $(document).ready(function() {
            $.validator.addMethod("validateUsername", function(value, element) {
                const unameRegex = /^[a-zA-Z]([._-](?![._-])|[a-zA-Z0-9]){3,30}[a-zA-Z0-9]$/;
                return unameRegex.test(value);
            }, "Invalid username");

            $('#frmNA').validate({
                rules: {
                    uname: {
                        required: true,
                        validateUsername: true
                    },
                    pass1: "required",
                    pass2: {
                        required: true,
                        equalTo: '#pass1'
                    }
                },
                messages: {
                    pass2: {
                        equalTo: "Retype password not matched!",
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
                    var uname = $('#uname').val().trim();
                    var pass1 = $('#pass1').val().trim();
                    var pass2 = $('#pass2').val().trim();
                    var fname = '<?= ($fname) ?>';
                    var mname = '<?= ($mname) ?>';
                    var lname = '<?= ($lname) ?>';
                    var email = '<?= ($email) ?>';
                    var adminID = '<?= ($realID) ?>';
                    var submit = $('#btnProceed').val();
                    $('#frmMessage').load("verify-new-admin.php", {
                        uname: uname,
                        pass1: pass1,
                        pass2: pass2,
                        fname: fname,
                        mname: mname,
                        lname: lname,
                        email: email,
                        adminID: adminID,
                        submit: submit
                    });
                }
            });
        });
    </script>
</head>

<body>
    <style>
        #uname-error,
        #pass1-error,
        #pass2-error {
            color: red;
            font-style: italic;
            font-size: 15px;
        }
    </style>

    <div class="container gap-5 mt-5">
        <div class="row">
            <div class="col col-md-6 offset-md-3">
                <div class="card shadow rounded">
                    <h4 class="card-header" id="ch1">Process Admin Account <i id="fa_check" class="fa fa-check fs-3 me-5 text-success" hidden></i></h4>
                    <div class="card-body">
                        <p id="frmMessage"></p>
                        <form action="verify-new-admin.php" method="POST" id="frmNA">
                            <label for="uname" class="form-label mt-0">Username</label>
                            <input type="text" class="form-control mb-2" placeholder="" name="uname" id="uname" required>
                            <span id="result"></span>
                            <p class="" style="font-size: 14px;">
                                <strong>Username Requirements:</strong><br>
                                1. Username consists of alphanumeric characters, lowercase, or uppercase.<br>
                                2. Username allowed of the dot (.), underscore (_), and hyphen (-).<br>
                                3. The dot (.), underscore (_), or hyphen (-) must not be the first or last character.<br>
                                4. The dot (.), underscore (_), or hyphen (-) does not appear consecutively.<br>
                                5. The number of characters must be between 5 to 32.<br>
                            </p>
                            <label for="pass1" class="form-label">Password</label>
                            <input type="password" class="form-control mb-2" placeholder="" name="pass1" id="pass1" required>
                            <label for="pass2" class="form-label">Re-type Password</label>
                            <input type="password" class="form-control mb-2" placeholder="" name="pass2" id="pass2" required>
                            <span id="result2"></span>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="btnProceed" form="frmNA" class="btn btn-primary">Proceed</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>