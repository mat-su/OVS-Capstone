<?php
include '../functions.php';
$conn = MYSQL_DB_Connection();
$output = '';

if (isset($_POST['submit'])) {
    $fname = $_POST['fname'];
    $mname = $_POST['mname'];
    $lname = $_POST['lname'];
    $adminID = $_POST['adminID'];
    $nameRegex = "/^[a-zA-Z]+(([',. -][a-zA-Z ])?[a-zA-Z]*)*$/";    

    if (empty($fname) || empty($lname)) {
        $output = '
        <div class="alert alert-danger mt-2" role="alert">
        <i class="fa fa-times fs-4 me-2"></i><strong>Fill in all the required fields!</strong>
        </div>';
    } else {
        $validFname = (preg_match($nameRegex, $fname));
        $validMname = (preg_match($nameRegex, $mname));
        if (empty($mname)) {$validMname = true;}
        
        $validLname = (preg_match($nameRegex, $lname));

        if ($validFname && $validMname && $validLname) {
            $stmt = $conn->prepare("UPDATE tbl_admin SET a_fname = :fname, a_mname = :mname, a_lname = :lname WHERE a_id = :id");
            $stmt->bindParam(':fname', $fname, PDO::PARAM_STR);
            $stmt->bindParam(':mname', $mname, PDO::PARAM_STR);
            $stmt->bindParam(':lname', $lname, PDO::PARAM_STR);
            $stmt->bindParam(':id', $adminID, PDO::PARAM_STR);
            $stmt->execute();
            $output = '
            <div class="alert alert-success mt-2" role="alert">
            <i class="fa fa-check fs-4 me-2"></i><strong>Success!</strong> Basic information was updated.
            </div>'."<script>$('#frmUP, #btnUP').remove();</script>"; 
        } else {
            $errFname = (!$validFname ? "first name" : "");
            $errMname = (!$validMname ? ", middle name" : "");
            $errLname = (!$validLname ? ", last name" : "");

            $output = '
            <div class="alert alert-danger mt-2" role="alert">
            <i class="fa fa-times fs-4 me-2"></i><strong>Invalid '.$errFname.$errMname.$errLname.' format!</strong>
            </div>';
        }
    }
} else {
    $output = '
        <div class="alert alert-danger mt-2" role="alert">
        <i class="fa fa-times fs-4 me-2"><strong>There was an error!</strong>
        </div>';
}
echo $output;