<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">    <title>Registration Unsuccessful</title>

    <!--Logo-->
    <link rel="shortcut icon" type="image/jpg" href="https://ik.imagekit.io/nwlfpk0xpdg/img/ovs_logo_x6ne_tPjZ7.jpg?ik-sdk-version=javascript-1.4.3&updatedAt=1648299575563" />

    <!--Rica: I replace the stylecss into this line--><link rel="stylesheet" href="css/style_index.css">

    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,400;0,500;1,300;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/fonts/simple-line-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">


    <!--jQuery CDN for Owl Carousel-->
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <!--OWL Carousel CSS,JS-->
    <script src="https://cdn.boomcdn.com/libs/owl-carousel/2.3.4/owl.carousel.min.js"></script>
    <link rel="stylesheet" href="https://cdn.boomcdn.com/libs/owl-carousel/2.3.4/assets/owl.carousel.min.css">

    <!--FontAwesome Kit-->
    <script src="https://kit.fontawesome.com/8acebfc2d4.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">

</head>

<body>
 <!--Contacts Section-->

    <!--Main navbar-->
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg sticky-top">
        <!-- Container wrapper -->
        <div class="container" id="main-nav">

            <!-- Navbar brand -->
            <a class="navbar-brand mb-0 text-wrap" href="index.php"><img src="https://ik.imagekit.io/nwlfpk0xpdg/img/tr:w-50,h-50/ovs_logo_x6ne_tPjZ7.jpg?ik-sdk-version=javascript-1.4.3&updatedAt=1648299575563" alt="">
                <span class="brand">PLMAR Online Voting System</span></a>
            <!-- Toggle button -->
            <button id="button_toggle" class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
            </button>

            <!-- Collapsible wrapper -->
            <div class="collapse navbar-collapse" id="navbarText">
                <!-- Left links -->
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">

                    <li class="nav-item">
                        <a class="nav-link d-flex flex-column text-center" aria-current="page" href="index.php#student_org"><i class="fas fa-sitemap"></i>
                            <span class="small">Student Organizations</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link d-flex flex-column text-center" href="#VoterSignIn" data-bs-toggle="modal"><i class="fas fa-user-lock me-1"></i>
                            <span class="small">Voter Portal</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link d-flex flex-column text-center" aria-current="page" href="signup.php"><i class="fas fa-sign-in-alt"></i>
                            <span class="small">Sign Up</span></a>
                    </li>
                </ul>
                <!-- Left links -->
            </div>
            <!-- Collapsible wrapper -->

        </div>
        <!-- Container wrapper -->
    </nav>
    <!-- End Navbar -->

    <div id="response_unsuccessful" class="container gap-5 mt-5">
        <div class="row">
            <div class="col col-md-6 offset-md-3">
                <div class="card shadow rounded">
                    <h3 class="card-header">Registration Unsuccessful <i class="fa fa-times fs-3 me-5 text-danger"></i></h3>
                    <div class="card-body">
                        <h6 class="card-title fs-5">There was a problem in your registration process.</h6>
                        <p class="card-text">
                            <?php if (isset($_GET['error'])) { ?>
                                <span class="text-danger"><?= $_GET['error'] ?></span>
                            <?php } ?>
                        </p>
                        <div class="d-grid justify-content-md-end mt-5">
                            <button type="button" class="btn" id="btn_ok">OK</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        document.getElementById("btn_ok").onclick = function() {
            location.href = "index.php";
        };
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>