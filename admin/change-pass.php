<?php
include '../functions.php';
$conn = MYSQL_DB_Connection();
$output = '';
if (isset($_POST['submit'])) {
    $currentPass = $_POST['curPass'];
    $newPass = $_POST['newPass'];
    $retypePass = $_POST['rnewPass'];
    $adminID = $_POST['adminID'];
    if (empty($currentPass) || empty($newPass) || empty($retypePass)) {
        $output = '
    <div class="alert alert-danger mt-2" role="alert">
        <strong>Fill in all fields!</strong>
    </div>';
    } else {
        $stmt = $conn->prepare("SELECT a_password FROM tbl_admin WHERE a_id = :id");
        $stmt->bindParam(':id', $adminID, PDO::PARAM_STR);
        $stmt->execute();
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);
        $pass = $admin['a_password'];
        if (!password_verify($currentPass, $pass)) {
            $output = '
            <div class="alert alert-danger mt-2" role="alert">
            <i class="fa fa-times fs-4 me-2"></i><strong>Current password is incorrect!</strong>
            </div>
            <script>
            $("#curPass").removeClass("is-valid").addClass("is-invalid");
            </script>'; 
        } else {
            if (!password_verify($newPass, $pass)) {
                if ($newPass <> $retypePass) {
                    $output = '
                    <div class="alert alert-danger mt-2" role="alert">
                    <i class="fa fa-times fs-4 me-2"></i><strong>Your new password does not matched!</strong>
                    </div>
                    <script>
                    $("#rnewPass").removeClass("is-valid").addClass("is-invalid");
                    </script>';
                } elseif ($newPass == $retypePass) {
                    $hashpass = password_hash($newPass, PASSWORD_DEFAULT);
                    $stmt = $conn->prepare("UPDATE tbl_admin SET a_password = :newpass WHERE a_id = :adminID");
                    $stmt->bindParam(':newpass', $hashpass, PDO::PARAM_STR);
                    $stmt->bindParam(':adminID', $adminID, PDO::PARAM_STR);
                    $stmt->execute();
                    
                    $output = '
                    <div class="alert alert-success mt-2" role="alert">
                    <i class="fa fa-check fs-4 me-2"></i><strong>Success!</strong> Password was changed.
                    </div>'."<script>$('#frmNewPass, #btnCP').remove();"; 
                }
            } else {
                $output = '
                <div class="alert alert-danger mt-2" role="alert">
                <i class="fa fa-times fs-4 me-2"></i><strong>Your new password must be different from your current password.</strong>
                </div>
                <script>
                $("#newPass").removeClass("is-valid").addClass("is-invalid");
                </script>'
                ;
            }
        }
    }
} else {
    $output = '
        <div class="alert alert-danger mt-2" role="alert">
        <i class="fa fa-times fs-4 me-2"><strong>There was an error!</strong>
        </div>';
}
echo $output;
