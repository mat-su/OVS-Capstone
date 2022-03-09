<?php
include '../functions.php';
$conn = MYSQL_DB_Connection();
$output = '';

if (isset($_POST['submit'])) {
    $newEmail = $_POST['newEmail'];
    $emailRegex = '/^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/';
    $adminID = $_POST['adminID'];
    if (empty($newEmail)) {
        $output = '
    <div class="alert alert-danger mt-2" role="alert">
    <i class="fa fa-times fs-4 me-2"></i><strong>Fill in the field!</strong>
    </div>
    $("#newEmail").removeClass("is-valid").addClass("is-invalid");
    </script>';
    } elseif (!filter_var($newEmail, FILTER_VALIDATE_EMAIL) || !preg_match($emailRegex, $newEmail)) {
        $output = '
            <div class="alert alert-danger mt-2" role="alert">
            <i class="fa fa-times fs-4 me-2"></i><strong>Improper email format!</strong> Enter a valid email address.
            </div>
            <script>
            $("#newEmail").removeClass("is-valid").addClass("is-invalid");
            </script>';
    } else {
        $stmt = $conn->prepare("UPDATE tbl_admin SET a_email = :email WHERE a_id = :adminID");
        $stmt->bindParam(':email', $newEmail, PDO::PARAM_STR);
        $stmt->bindParam(':adminID', $adminID, PDO::PARAM_STR);
        $stmt->execute();

        $output = '
    <div class="alert alert-success mt-2" role="alert">
    <i class="fa fa-check fs-4 me-2"></i><strong>Success..!</strong> Email was changed.
    </div>' . "<script>$('#frmNewEmail, #btnCE').remove();</script>";
    }
} else {
    $output = '
        <div class="alert alert-danger mt-2" role="alert">
        <i class="fa fa-times fs-4 me-2"><strong>There was an error!</strong>
        </div>';
}

echo $output;
