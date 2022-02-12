<?php
include '../functions.php';
$conn = MYSQL_DB_Connection();
$output = '';
if (isset($_POST['submit'])) {
    $newUname = $_POST['newUname'];
    $adminID = $_POST['adminID'];
    $unameRegex = "/^[a-zA-Z]([._-](?![._-])|[a-zA-Z0-9]){3,30}[a-zA-Z0-9]$/";
    if (empty($newUname)) {
        $output = '
    <div class="alert alert-danger mt-2" role="alert">
    <i class="fa fa-times fs-4 me-2"></i><strong>Fill in the field!</strong>
    </div>';
    } elseif (preg_match($unameRegex, $newUname)) {

        $stmt = $conn->prepare("SELECT sa_username as uname FROM tbl_subadmin");
        $stmt->execute();
        $unames = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $isTaken = false;
        foreach($unames as $uname) :
            if ($uname['uname'] == $newUname) {
                $isTaken = true;
            }
        endforeach;
        if (!$isTaken) {
            $stmt = $conn->prepare("UPDATE tbl_subadmin SET sa_username = :uname WHERE sa_id = :id");
            $stmt->bindParam(':uname', $newUname, PDO::PARAM_STR);
            $stmt->bindParam(':id', $adminID, PDO::PARAM_STR);
            $stmt->execute();
            $output = '
            <div class="alert alert-success mt-2" role="alert">
            <i class="fa fa-check fs-4 me-2"></i><strong>Success..!</strong> Username was changed.
            </div>'."<script>$('#frmNewUname, #btnCU').remove();</script>"; 
        } else {
            $output = '
            <div class="alert alert-danger mt-2" role="alert">
            <i class="fa fa-times fs-4 me-2"></i><strong>Username already taken!</strong>
            </div>';
        }
        
    } else {
        $output = '
    <div class="alert alert-danger mt-2" role="alert">
    <i class="fa fa-times fs-4 me-2"></i><strong>Invalid username format!</strong>
    </div>';
    }
} else {
    $output = '
        <div class="alert alert-danger mt-2" role="alert">
        <i class="fa fa-times fs-4 me-2"><strong>There was an error!</strong>
        </div>';
}
    
echo $output;