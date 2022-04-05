<?php
include 'functions.php';
$conn = MYSQL_DB_Connection();
if (isset($_POST['submit'])) {
    if (empty($_POST['fname']) || empty($_POST['mname']) || empty($_POST['lname']) || empty($_POST['email'])) {
        $output = '
        <div class="alert alert-danger role="alert">
        <i class="fa fa-times fs-4 me-2"></i><strong>Error!</strong> The link was broken.
        <script>$("#frmNA, .modal-footer").remove(); setTimeout(function(){
            location = \'index.php\'
        },2000)</script>
        </div>';
    } else {
        if (empty($_POST['uname']) || empty($_POST['pass1']) || empty($_POST['pass2'])) {
            $output = '
            <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
            <i class="fa fa-times fs-4 me-2"></i><strong>Fill in all the fields!</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        } else {
            $unameRegex = "/^[a-zA-Z]([._-](?![._-])|[a-zA-Z0-9]){3,30}[a-zA-Z0-9]$/";
            $uname = $_POST['uname'];
            $validUname = preg_match($unameRegex, $uname);
            $adminID = $_POST['adminID'];
            $fname = $_POST['fname'];
            $mname = $_POST['mname'];
            $lname = $_POST['lname'];
            $email = $_POST['email'];
            $pass1 = $_POST['pass1'];
            $pass2 = $_POST['pass2'];
            $passMatch = $pass1 == $pass2;
            if ($validUname && $pass1 == $pass2) {

                $stmt = $conn->prepare("SELECT a_username as uname FROM tbl_admin");
                $stmt->execute();
                $unames = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $isTaken = false;
                foreach ($unames as $u) :
                    if ($u['uname'] == $uname) {
                        $isTaken = true;
                    }
                endforeach;

                if (!$isTaken) {
                    $stmt = $conn->prepare("SELECT * FROM tbl_pending_newadmin WHERE id = :id");
                    $stmt->bindParam(':id', $adminID, PDO::PARAM_STR);
                    $stmt->execute();
                    $c = $stmt->rowCount();

                    if ($c == 1) {
                        $stmt = $conn->prepare("DELETE from tbl_pending_newadmin WHERE id = :id");
                        $stmt->bindParam(':id', $adminID, PDO::PARAM_STR);
                        $stmt->execute();

                        $hashPass = password_hash($pass1, PASSWORD_DEFAULT);

                        $stmt = $conn->prepare("SELECT * FROM tbl_admin ORDER BY id DESC LIMIT 1");
                        $stmt->execute();
                        $adminGet = $stmt->fetch(PDO::FETCH_ASSOC);
                        $count = $adminGet['id'];
                        $id = 'MA';
                        $id .=  $count + 1 . '-' . date("Y");
                        date_default_timezone_set('Asia/Hong_Kong');
                        $currentdate = date('Y-m-d H:i:s', time());
                        $stmt = $conn->prepare("INSERT INTO tbl_admin (a_id, a_fname, a_mname, a_lname, a_username, a_email, a_password, a_date_created) VALUES (:id, :fname, :mname, :lname, :username, :email, :password, :currentdate)");
                        $stmt->bindParam(':id', $id, PDO::PARAM_STR);
                        $stmt->bindParam(':fname', $fname, PDO::PARAM_STR);
                        $stmt->bindParam(':mname', $mname, PDO::PARAM_STR);
                        $stmt->bindParam(':lname', $lname, PDO::PARAM_STR);
                        $stmt->bindParam(':username', $uname, PDO::PARAM_STR);
                        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                        $stmt->bindParam(':password', $hashPass, PDO::PARAM_STR);
                        $stmt->bindParam(':currentdate', $currentdate, PDO::PARAM_STR);
                        $stmt->execute();
                        $output = 'Redirecting to homepage...' . 
                        "<script>$('#frmNA, .modal-footer').remove();
                        document.getElementById(\"ch1\").innerHTML = \"Admin Successfully Created\";
                        setTimeout(function(){
                            location = 'index.php'
                        },2000)
                        $('#fa_check').removeAttr('hidden');
                        </script>";
                        
                    } else {
                        $output = '<div class="alert alert-danger alert-dismissible fade show mt-2"    role="alert">
                        <i class="fa fa-times fs-4 me-2"></i><strong>There was an error!</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <script>$("#frmNA, .modal-footer").remove();
                        setTimeout(function(){
                            location = \'index.php\'
                        },2000)
                        </script>
                        ';
                    }
                } else {
                    $output = '
                        <div class="alert alert-danger mt-2" role="alert">
                        <i class="fa fa-times fs-4 me-2"></i><strong>Username was already taken!</strong>
                        </div>
                    ';
                }
            } else {
                $errUname = !$validUname ? "Invalid username format " : "";
                $and = (!$validUname && !$passMatch) ? "and " : "";
                $errPass = !$passMatch ? "Re-type password not matched" : "";
                $output = '
                <div class="alert alert-danger" role="alert">
                <i class="fa fa-times fs-4 me-2"></i><strong>' . $errUname . $and . $errPass . ' </strong>
                </div>';
            }
        }
    }
} else {
    $output = '
        <div class="alert alert-danger" role="alert">
        <i class="fa fa-times fs-4 me-2"></i><strong>There was an error!</strong>
        <script>$("#frmNA, .modal-footer").remove();</script>
        </div>';
}

echo $output;
