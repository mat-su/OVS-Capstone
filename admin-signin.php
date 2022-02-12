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
        <link rel="shortcut icon" type="image/jpg" href="https://ik.imagekit.io/nwlfpk0xpdg/img/tr:w-50,h-50/logo-png_Xt7bTS_7o.png?ik-sdk-version=javascript-1.4.3&updatedAt=1636213481504" />
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

        <!--FontAwesome Kit-->
        <script src="https://kit.fontawesome.com/8acebfc2d4.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
        <link rel="stylesheet" href="assets/bootstrap/css/style.css">
        <title>Admin Signin</title>
    </head>

    <body>
        <!--Contacts Section-->
        <nav class="navbar navbar-expand text-white py-0" style="background-color: #000000;">
            <div class="container">
                <ul class="navbar-nav ">
                    <li class="nav-item" style="margin-right: 10px;">
                        <small>Call (02) 392-0455</small>
                    </li>
                    <li class="list-inline-item"></li><a style="color:#ffffff" target="_blank" href="https://www.facebook.com/cpaips/"><i class="fa fa-facebook"></i></a>
                    </li>
                    <li class="list-inline-item"></li><a style="color:#ffffff" target="_blank" href="mailto:educpurponly101@gmail.com"><i class="fa fa-envelope"></i></a>
                    </li>
                    <li class="list-inline-item"></li><a style="color:#ffffff" target="_blank" href="https://www.youtube.com/channel/UCz7GtBK1hzFv7eEyZD2Y7hw"><i class="fab fa-youtube"></i></a>
                    </li>
                </ul>
                <ul class="navbar-nav collapse navbar-collapse justify-content-end">
                    <li class="nav-item"><span class="text-white">|</span></li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="index.php"><small>Home</small></a>
                    </li>
                </ul>
            </div>
        </nav>

        <!---Form Login-->
        <section class="vote-photo">
            <div class="form-container shadow-lg p-3 bg-body rounded">
                <div class="image-holder"></div>

                <form method="post" action="ad_auth-login.php" id="ad_logform">
                    <h2 class="text-center display-6"><strong>Administrator Login</strong></h2>
                    <h5 class="text-center display-6">Keep Connected</h5>
                    <div class="mb-3 mt-5">
                        <?php if (isset($_GET['error'])) { ?>
                            <div class="alert alert-danger" role="alert">
                                <i class="fa fa-times-circle fs-4 me-3"></i><small><?= $_GET['error'] ?></small>
                            </div>
                        <?php } ?>
                        <select class="form-select" aria-label="Default select example" form="ad_logform" name="access" required>
                            <option value="">--Select Access Level--</option>
                            <option value="1">Main Admin</option>
                            <option value="2">Sub Admin</option>
                        </select>
                    </div>
                    <div class="mb-3"><input class="form-control" type="text" name="username" placeholder="Username" required></div>
                    <div class="mb-3"><input class="form-control" type="password" name="password" placeholder="Password" required></div>

                    <div class="mb-5"><button class="btn btn-primary d-block w-100" type="submit">Sign In</button></div>

                </form>
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