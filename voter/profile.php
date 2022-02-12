<?php
session_start();
include '../functions.php';
$conn = MYSQL_DB_Connection();
$id = $_SESSION['v_id'];
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
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Profile</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic">
    <link rel="stylesheet" href="../assets/fonts/font-awesome.min.css">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

</head>

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
    <div class="container col col-md-6 offset-md-3 mt-3"><span class="fs-3">Voter Account</span>
    </div>
    <div class="container mt-3 mb-5">
        <div class="row">
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
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>

</html>