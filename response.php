<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/fonts/simple-line-icons.min.css">

    <!--FontAwesome Kit-->
    <script src="https://kit.fontawesome.com/8acebfc2d4.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <title>Registration Unsuccessful</title>
</head>

<body>
    <nav class="navbar navbar-expand text-white" style="background-color: #000000;">
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
        </div>
    </nav>

    <!--Main navbar-->
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white">
        <!-- Container wrapper -->
        <div class="container-fluid" id="main-nav">
            <!-- Navbar brand -->
            <div class="container col-12">
                <a class="navbar-brand lead mb-0 text-wrap" href="#"><img src="../assets/img/ovslogov2-ns.png" alt="" width="auto" height="40px"> PLMAR Online Voting System</a>
            </div>
        </div>
        <!-- Container wrapper -->
    </nav>
    <!-- End Navbar -->
    <div class="container gap-5 mt-5">
        <div class="row">
            <div class="col col-md-6 offset-md-3">
                <div class="card shadow rounded">
                    <h4 class="card-header">Registration Unsuccessful <i class="fa fa-times fs-3 me-5 text-danger"></i></h4>
                    <div class="card-body">
                        <h5 class="card-title fs-5">There was a problem in your registration process.</h5>
                        <p class="card-text">
                            <?php if (isset($_GET['error'])) { ?>
                                <span class="text-danger"><?= $_GET['error'] ?></span>
                            <?php } ?>
                        </p>
                        <div class="d-grid justify-content-md-end mt-5">
                            <button type="button" class="btn btn-primary" id="btn_ok">OK</button>
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