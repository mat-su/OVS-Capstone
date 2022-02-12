<?php
include '../functions.php';
$conn = MYSQL_DB_Connection();
$output = '';

if (isset($_POST['submit'])) {
    $newEmail = $_POST['newEmail'];
    $adminID = $_POST['adminID'];
    if (empty($newEmail)) {
        $output = '
    <div class="alert alert-danger mt-2" role="alert">
    <i class="fa fa-times fs-4 me-2"></i><strong>Fill in the field!</strong>
    </div>';
    } elseif (!filter_var($newEmail, FILTER_VALIDATE_EMAIL)) {
        $output = '
    <div class="alert alert-danger mt-2" role="alert">
    <i class="fa fa-times fs-4 me-2"></i><strong>Improper email format!</strong> Write a valid email address.
    </div>';
    } else {
        $stmt = $conn->prepare("UPDATE tbl_subadmin SET sa_email = :email WHERE sa_id = :adminID");
        $stmt->bindParam(':email', $newEmail, PDO::PARAM_STR);
        $stmt->bindParam(':adminID', $adminID, PDO::PARAM_STR);
        $stmt->execute();
   
        $output = '
    <div class="alert alert-success mt-2" role="alert">
    <i class="fa fa-check fs-4 me-2"></i><strong>Success..!</strong> Email was changed.
    </div>'."<script>$('#frmNewEmail, #btnCE').remove();</script>"; 

    
    }
} else {
    $output = '
        <div class="alert alert-danger mt-2" role="alert">
        <i class="fa fa-times fs-4 me-2"><strong>There was an error!</strong>
        </div>';
}
    
echo $output;
