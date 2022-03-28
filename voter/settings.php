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

    $stmt = $conn->prepare("SELECT v_fname, v_mname, v_lname FROM tbl_voter WHERE v_id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $voter = $stmt->fetch(PDO::FETCH_ASSOC);
    $fname = $voter['v_fname'];
    $mname = $voter['v_mname'];
    $lname = $voter['v_lname'];
?>
    <!doctype html>
    <html lang="en">

    <head>
        <meta charset="utf-8" />
        <title>Settings</title>
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js" type="text/javascript"></script>
        <script type="text/javascript">
            WebFont.load({
                google: {
                    families: [
                        "Montserrat:100,100italic,200,200italic,300,300italic,400,400italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic"
                    ]
                }
            });
        </script>
        <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
        <!--Tab Logo-->
        <link rel="shortcut icon" type="image/jpg" href="https://ik.imagekit.io/nwlfpk0xpdg/img/ovs_logo_x6ne_tPjZ7.jpg?ik-sdk-version=javascript-1.4.3&updatedAt=1648299575563"/>
        <!--Boostrap5 CSS CDN-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <!--JQuery Link-->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <!--Boostrap5 JS CDN-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <!--JQuery Validation PlugIn-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.js"></script>
        <!--Font Awesome CSS CDN-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />

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
                font-weight: normal;
            }
            #lbl-name,
            #lbl-email,
            #lbl-password {
                -ms-grid-column: span 1;
                grid-column-start: span 1;
                -ms-grid-column-span: 1;
                grid-column-end: span 1;
                -ms-grid-row: span 1;
                grid-row-start: span 1;
                -ms-grid-row-span: 1;
                grid-row-end: span 1;
                -ms-grid-row-align: center;
                align-self: center;
                -ms-grid-column-align: start;
                justify-self: start;
            }

            #lbl-name-value,
            #lbl-email-value,
            #lbl-password-value {
                -ms-grid-column: span 1;
                grid-column-start: span 1;
                -ms-grid-column-span: 1;
                grid-column-end: span 1;
                -ms-grid-row: span 1;
                grid-row-start: span 1;
                -ms-grid-row-span: 1;
                grid-row-end: span 1;
                -ms-grid-row-align: center;
                align-self: center;
            }

            #btn-name,
            #btn-email,
            #btn-password {
                -ms-grid-column: span 1;
                grid-column-start: span 1;
                -ms-grid-column-span: 1;
                grid-column-end: span 1;
                -ms-grid-row: span 1;
                grid-row-start: span 1;
                -ms-grid-row-span: 1;
                grid-row-end: span 1;
            }

            form {
                display: block;
                margin-top: 0em;
            }

            .container {
                background-color: transparent;
            }

            .div-block-4 {
                box-shadow: 0 1px 11px -5px #131010;
            }



            .w-form {
                margin: 0 0 15px
            }

            .form-2 {
                font-family: Montserrat, sans-serif;
            }

            .field-label-7 {
                display: block;
                padding-top: 50px;
                padding-left: 50px;
                -webkit-box-pack: start;
                -webkit-justify-content: flex-start;
                -ms-flex-pack: start;
                justify-content: flex-start;
                -webkit-box-align: center;
                -webkit-align-items: center;
                -ms-flex-align: center;
                align-items: center;
                font-weight: 600;
                text-align: left;
                font-size: 18px;
                margin-bottom: 2rem;
            }

            .div-main-block {
                display: -webkit-box;
                display: -webkit-flex;
                display: -ms-flexbox;
                display: flex;
                overflow: visible;
                margin-right: 60px;
                margin-left: 60px;
                padding-right: 0px;
                padding-bottom: 40px;
                padding-left: 0px;
                -webkit-justify-content: space-around;
                -ms-flex-pack: distribute;
                justify-content: space-around;
                -webkit-box-align: center;
                -webkit-align-items: center;
                -ms-flex-align: center;
                align-items: center;
            }

            .lottie-animation-2 {
                display: -webkit-box;
                display: -webkit-flex;
                display: -ms-flexbox;
                display: flex;
                width: 300px;
                height: 200px;
                margin-left: 0px;
                padding-left: 0px;
                clear: none;
                -webkit-box-align: baseline;
                -webkit-align-items: baseline;
                -ms-flex-align: baseline;
                align-items: baseline;
            }

            .w-layout-grid {
                display: -ms-grid;
                display: grid;
                grid-auto-columns: 1fr;
                -ms-grid-columns: 1fr 1fr;
                grid-template-columns: 1fr 1fr;
                -ms-grid-rows: auto auto;
                grid-template-rows: auto auto;
                grid-row-gap: 16px;
                grid-column-gap: 16px;
            }

            .grid-3 {
                display: -ms-grid;
                display: grid;
                width: 100%;
                -webkit-justify-content: space-around;
                -ms-flex-pack: distribute;
                justify-content: space-around;
                -webkit-align-content: center;
                -ms-flex-line-pack: center;
                align-content: center;
                -ms-grid-row-align: center;
                align-self: center;
                grid-auto-columns: 1fr;
                grid-column-gap: 16px;
                grid-row-gap: 16px;
                grid-template-areas: ".";
                -ms-grid-columns: 0.5fr 16px 1.25fr 16px 1fr;
                grid-template-columns: 0.5fr 1.25fr 1fr;
                -ms-grid-rows: auto 16px auto 16px auto;
                grid-template-rows: auto auto auto;
            }

            .button {
                position: static;
                width: 70px;
                border-radius: 20px !important;
                box-shadow: 1px 1px 3px 0 #5e5353;
                text-align: center;
                font-size: 14px;
                padding-top: 10px;
            }

            .w-button {
                display: inline-block;
                /* padding: 9px 15px; */
                background-color: #3898EC;
                color: white;
                border: 0;
                line-height: inherit;
                text-decoration: none;
                cursor: pointer;
                border-radius: 0;
                width: 90px;
                height: 40px;
            }

            input.w-button {
                -webkit-appearance: button
            }

            label {
                font-size: 14px;
            }

            @media screen and (max-width:991px) {
                .w-container {
                    max-width: 728px
                }
            }

            @media screen and (max-width:767px) {
                .form-2 {
                    display: block;
                    padding-top: 11px;
                    padding-bottom: 20px;
                }

                .field-label-7 {
                    padding-left: 0px;
                    text-align: center;
                    font-size: 18px;
                }

                .div-main-block {
                    display: block;
                    margin-right: 0px;
                    margin-left: 0px;
                    padding-right: 40px;
                    padding-left: 40px;
                }

                .lottie-animation-2 {
                    display: block;
                    width: 200px;
                    height: 150px;
                    margin-right: auto;
                    margin-left: auto;
                    text-align: left;
                }

                .grid-3 {
                    margin-right: 0px;
                    margin-left: auto;
                    padding-right: 0px;
                    -ms-grid-columns: 0.25fr 0.25fr 0.25fr;
                    grid-template-columns: 0.25fr 0.25fr 0.25fr;
                    font-size: 12px;
                    text-align: left;
                }

                .button {
                    max-width: 100px;
                    min-width: 10px;
                    font-size: 14px;
                }

                .w-button {
                    width: 90px;
                    height: 40px;
                }

                label {
                    font-size: 14px;
                }
            }

            @media screen and (max-width:479px) {
                .w-container {
                    max-width: none
                }

                .form-2 {
                    display: block;
                }

                .field-label-7 {
                    display: block;
                    padding-left: 0px;
                    font-size: 14px;
                    text-align: center;
                }

                .field-label-9 {
                    margin-top: 16px;
                }

                .field-label-10 {
                    margin-top: 16px;
                    padding-top: 0px;
                }

                .div-main-block {
                    display: block;
                    margin-right: 0px;
                }

                .lottie-animation-2 {
                    display: -webkit-box;
                    display: -webkit-flex;
                    display: -ms-flexbox;
                    display: flex;
                    width: auto;
                    margin-bottom: -35px;
                    margin-left: 0px;
                    padding-bottom: 0px;
                    -webkit-box-pack: start;
                    -webkit-justify-content: flex-start;
                    -ms-flex-pack: start;
                    justify-content: flex-start;
                }

                .grid-3 {
                    display: inline-block;
                    grid-auto-columns: 1fr;
                    -ms-grid-columns: 1.25fr 0.75fr 0.5fr;
                    grid-template-columns: 1.25fr 0.75fr 0.5fr;
                    -ms-grid-rows: auto auto auto;
                    grid-template-rows: auto auto auto;
                    font-size: 10px;
                    text-align: center;
                    margin-top: 20px
                }

                .button {
                    font-size: 12px;
                    padding-top: 5px;
                }

                .w-button {
                    width: 70px;
                    height: 30px;
                }

                label {
                    font-size: 12px;
                }

                .float-end.btn.btn-secondary {
                    font-size: 12px;
                }

            }

            .form-block-2 {
                margin-top: 62px;
                margin-bottom: 62px;
                padding-top: 0px;
                font-family: Montserrat, sans-serif;
            }

            .w-container {
                margin-left: auto;
                margin-right: auto;
                max-width: 940px
            }

            body {
                font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif;
                color: #333;
                font-size: 14px;
                line-height: 20px;
            }

            body {
                margin: 0;
                min-height: 100%;
                background-color: #fff;
                font-family: Montserrat, sans-serif;
                font-size: 14px;
                line-height: 20px;
                color: #333;
            }

            label {
                display: block;
                margin-bottom: 5px;
                font-weight: bold;
            }
        </style>
        <div class="">
            <div class="container w-container">
                <div class="div-block-4">
                    <div><a class="float-end btn btn-secondary" style="margin:10px;" href="dashboard.php">Back</a></div>
                
                    <div class="form-block-2 w-form">
                        <form id="" name="" data-name="" method="" class="form-2">
                            <label for="" class="field-label-7">Voter Account Settings</label>
                            <div class="div-main-block">
                                <div data-w-id="ef6d9ca5-233b-149c-ea4c-4d909f32e039" class="lottie-animation-2">
                                    <lottie-player src="https://assets1.lottiefiles.com/packages/lf20_wcdzldes.json" background="transparent" speed="1" loop autoplay></lottie-player>
                                </div>
                                <div class="w-layout-grid grid-3">
                                    <label id="lbl-name" class="field-label-9">Name:  </label>
                                    <label id="lbl-name-value"><?= $fname ?> <?= $mname ?> <?= $lname ?></label>
                                    <a id="btn-name" data-bs-toggle="modal" href="#modalUP" role="button" class="button w-button" style="visibility:hidden">Update</a>
                                    <label id="lbl-email" class="field-label-9">Email: </label>
                                    <label id="lbl-email-value"><?= $email ?></label>
                                    <a id="btn-email" data-bs-toggle="modal" href="#modalCE" role="button" class="button w-button">Change</a>
                                    <label id="lbl-password" class="field-label-10">Password: </label>
                                    <label id="lbl-password-value">***********</label>
                                    <a id="btn-password" data-bs-toggle="modal" href="#modalCP" role="button" class="button w-button">Change</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        </div>
        <br><br><br><br><br><br><br><br><br><br><br>
        <?=template_footer()?>
        
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