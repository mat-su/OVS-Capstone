<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Successfully Registered</title>
    <!--Logo-->
    <link rel="shortcut icon" type="image/jpg" href="https://ik.imagekit.io/nwlfpk0xpdg/img/ovs_logo_x6ne_tPjZ7.jpg?ik-sdk-version=javascript-1.4.3&updatedAt=1648299575563" />

    <!--Rica: I replace the stylecss into this line-->
    <link rel="stylesheet" href="css/style_index.css">

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
    <div class="container gap-5 mt-5">
        <div class="row">
            <div class="col col-md-6 offset-md-3">
                <div class="card shadow rounded">
                    <h3 class="card-header">Successfully Registered<i class="fa fa-check fs-3 me-5 text-success"></i></h3>
                    <div class="card-body">
                        <h6 class="card-title"></h6>
                        <h6 class="card-text">Kindly check your email for the details sent and provided by the system to access your voter account. Thank you!</h6>
                        <div class="d-grid justify-content-md-end">
                            <button type="button" class="btn btn-primary" id="btn_ok">Okay</button>
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