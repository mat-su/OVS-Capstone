<?php
include '../functions.php';
template_header('Voted Successfully');

?>

<body>

    <!--Main navbar-->
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white">
        <!-- Container wrapper -->
        <div class="container-fluid" id="main-nav">
            <!-- Navbar brand -->
            <div class="container col-12">
                <a class="navbar-brand mb-0 text-wrap" href="index.php"><img src="https://ik.imagekit.io/nwlfpk0xpdg/img/tr:w-50,h-50/ovs_logo_x6ne_tPjZ7.jpg?ik-sdk-version=javascript-1.4.3&updatedAt=1648299575563" alt="">
                    <span class="brand">PLMAR Online Voting System</span></a>
            </div>
        </div>
        <!-- Container wrapper -->
    </nav>
    <!-- End Navbar -->
    <div class="container gap-5 mt-5">
        <div class="row">
            <div class="col col-md-6 offset-md-3">
                <div class="card shadow rounded">
                    <h4 class="card-header">Successfully Voted<i class="fa fa-check fs-3 me-5 text-success"></i></h4>
                    <div class="card-body">
                        <h5 class="card-title"></h5>
                        <p class="card-text">You have successfully cast your vote!</p>
                        <div class="d-grid justify-content-md-end">
                            <button type="button" class="btn btn-primary" id="btn_ok">OK</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        document.getElementById("btn_ok").onclick = function() {
            location.href = "dashboard.php";
        };
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>