<?php
require '../functions.php';
session_start();
$conn = MYSQL_DB_Connection();
if (isset($_SESSION['v_id']) && isset($_SESSION['v_email'])) {
    $orgs = $conn->query("SELECT CONCAT(org_name,' (', org_acronym, ')') AS org, org_id FROM tbl_stud_orgs");
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic">
        <link rel="stylesheet" href="../assets/fonts/font-awesome.min.css">
        <!--FontAwesome Kit-->
        <script src="https://kit.fontawesome.com/8acebfc2d4.js" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

        <title>Select Student Org</title>
    </head>

    <body>
        <!--Contacts Section-->
        <nav class="navbar navbar-expand text-white py-2" style="background-color: #000000;">
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
        <div class="container gap-5 mt-5">
            <div class="row">
                <div class="col col-md-6 offset-md-3">
                    <div class="card shadow rounded">
                        <h4 class="card-header text-center display-6 fs-4 fw-bolder">PAMANTASAN NG LUNGSOD NG MARIKINA</h4>
                        <div class="card-body">
                            <div class="card">
                                <span class="card-header card-title text-center text-white bg-dark">PLEASE SELECT YOUR ORGANIZATION</span>
                                <div class="card-body">
                                    <?php if (isset($_GET['error'])) { ?>
                                        <div class="alert alert-danger" role="alert">
                                            <i class="fa fa-times-circle fs-4 me-3"></i><small><?= $_GET['error'] ?></small>
                                        </div>
                                    <?php } ?>
                                    <form action="validate.php" method="post" id="frmSO">
                                        <p class="card-text">
                                            <select class="form-select" name="org" id="org" form="frmSO" required>
                                                <option value="">Select an Organization</option>
                                                <?php foreach ($orgs as $o) : ?>
                                                    <option value="<?= $o['org_id'] ?>"><?= $o['org'] ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </p>
                                        <button type="button" class="btn btn-danger" id="btn_back">Go back</button>
                                        <button type="submit" class="btn btn-primary float-end" id="btn_ok">Okay</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            document.getElementById("btn_back").onclick = function() {
                location.href = "../logout.php";
            };
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    </body>

    </html>
<?php
} else {
    header("Location: ../index.php");
}
?>