<?php
session_start();

if (!isset($_SESSION['a_id']) && !isset($_SESSION['a_email'])) {
?>

    <!doctype html>
    <html lang="en">

    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Admin Login</title>
        <!--Logo-->
        <link rel="shortcut icon" type="image/jpg" href="https://ik.imagekit.io/nwlfpk0xpdg/img/tr:w-50,h-50/ovs_logo_x6ne_tPjZ7.jpg?ik-sdk-version=javascript-1.4.3&updatedAt=1648299575563" />
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

        <!--Font-->
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,400;0,500;1,300;1,400&display=swap" rel="stylesheet">

        <!--FontAwesome Kit-->
        <script src="https://kit.fontawesome.com/8acebfc2d4.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">

        <!--CSS-->
        <link rel="stylesheet" href="assets/bootstrap/css/style.css">
        
        <!-- Jquery -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

        <!--JQuery Validation PlugIn-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.js"></script>
        <script>
            $(document).ready(function() {
                const msg = document.querySelector('#msg');
                $('#ad_logform').validate({
                    rules: {
                        access: {
                            required: true,
                        },
                        username: {
                            required: true,
                        },
                        password: {
                            required: true,
                        }
                    },
                    messages: {
                        access: {
                            required: "Please select an access level",
                        },
                        username: {
                            required: "Please enter your username",
                        },
                        password: {
                            required: "Please enter your password",
                        }
                    },
                    highlight: function(element, errorClass, validClass) {
                        $(element).addClass("is-invalid").removeClass("is-valid");
                    },
                    unhighlight: function(element, errorClass, validClass) {
                        $(element).addClass("is-valid").removeClass("is-invalid");
                    },
                    submitHandler: function() {
                        let form = $('#ad_logform');
                        let actionUrl = form.attr('action');
                        $.ajax({
                            type: "POST",
                            url: actionUrl,
                            dataType: "JSON",
                            data: form.serialize(), // serializes the form's elements.
                            success: function(resp) {
                                if (resp.feedback == 'authenticated') {
                                    window.location.href = resp.action;
                                } else {
                                    msg.classList.add('alert');
                                    msg.classList.add('alert-danger');
                                    msg.setAttribute('role', 'alert');
                                    $(msg).html(`<i class="fa fa-times-circle fs-4 me-3"></i><small>${resp.action}</small>`);
                                    
                                    $('select[name=access]').addClass("is-invalid").removeClass("is-valid");
                                    $('input[name=username]').addClass("is-invalid").removeClass("is-valid");
                                    $('input[name=password]').addClass("is-invalid").removeClass("is-valid").val("");
                                }
                            }
                        });
                    }
                });
            });
        </script>
    </head>

    <body>

        <!---Form Login-->
        <section class="vote-photo">

            <div class="form-container shadow-lg bg-body rounded ">
                <div id="div-button-back">
                    <a href="index.php" id="button-back">Back</a>
                </div>
                <div class="d-flex">
                    <div class="image-holder">
                        <img src="https://ik.imagekit.io/nwlfpk0xpdg/img/tr:w-500/Man_sitting_at_desk_and_unlocking_computer_nvo-dQYzc.jpg?ik-sdk-version=javascript-1.4.3&updatedAt=1648468199469" alt="">
                    </div>

                    <form method="post" action="ad_auth-login.php" id="ad_logform" class="p-5">

                        <h4 class="text-center"><strong>Administrator Login</strong></h4>
                        <h6 class="text-center">Keep Connected</h6>
                        <div class="mb-3 mt-5">
                            <div id="msg"></div>
                            <select class="form-select" aria-label="Default select example" form="ad_logform" name="access" required>
                                <option value="">--Select Access Level--</option>
                                <option value="1">Main Admin</option>
                                <option value="2">Sub Admin</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="username">Username</label>
                            <input class="form-control" type="text" name="username" placeholder="admin_plmar2022" required>
                        </div>
                        <div class="mb-3">
                            <label for="password">Password</label>
                            <input class="form-control" type="password" name="password" placeholder="********" required>
                        </div>

                        <div class="mb-5"><button id="button-red" class="btn d-block w-100" type="submit">Sign In</button></div>

                    </form>
                </div>

            </div>
        </section>

        <!-- Option 1: Bootstrap Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    </body>

    </html>
<?php
} else {
    header("Location: admin/dashboard.php");
}
?>