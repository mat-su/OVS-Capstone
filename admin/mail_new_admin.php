<?php
include '../functions.php';
include '../mail.php';
$conn = MYSQL_DB_Connection();
$output = '';
if (isset($_POST['submit'])) {
    $fname = $_POST['fname'];
    $mname = $_POST['mname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $nameRegex = "/^[a-zA-Z]+(([',. -][a-zA-Z ])?[a-zA-Z]*)*$/";

    if (empty($fname) || empty($lname) ||  empty($email)) {
        $output = '
        <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
        <i class="fa fa-times fs-4 me-2"></i><strong>Fill in all the required fields!</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    } else {
        if (preg_match($nameRegex, $fname) && preg_match($nameRegex, $mname) && preg_match($nameRegex, $lname) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $stmt = $conn->query("SELECT * FROM tbl_pending_newadmin");
            $count = $stmt->rowCount();
            $id = 'PNA';
            $id .=  $count + 1 . '-' . date("Y");
            $hashID = password_hash($id, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO tbl_pending_newadmin (id, fname, mname, lname, email) VALUES (:id, :fname, :mname, :lname, :email)");
            $stmt->bindParam(':id', $hashID, PDO::PARAM_STR);
            $stmt->bindParam(':fname', $fname, PDO::PARAM_STR);
            $stmt->bindParam(':mname', $mname, PDO::PARAM_STR);
            $stmt->bindParam(':lname', $lname, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $name = "$fname $lname";
            $data = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcefghijklmnopqrstuvwxyz./';
            $salty = substr(str_shuffle($data), 0, 7);
            $stmt->execute();
            //Email subject
            $mail->Subject = "Request to be an OVS Administrator";
            //Set sender email
            $mail->setFrom('educpurponly101@gmail.com', '1VOTE 4PLMAR Online-Voting System');
            //Enable HTML
            $mail->isHTML(true);
            //Email body
            $mail->Body = "Good day! <b>" . $name . "</b> 
                <br>A request has been offered for you to become an administrator in PLMAR Online Voting System.<br><br><a href=\"https://localhost:3000/new-admin.php?continue=" . $hashID . $salty . "\">Process my account.</a>";
            //Add recipient
            $mail->addAddress($email, 'Receiver');
            $mail->addReplyTo('educpurponly101@gmail.com', '1VOTE 4PLMAR Online-Voting System');

            //Finally send email
            if ($mail->Send()) {
                $output = '<div class="alert alert-success alert-dismissible fade show mt-2" role="alert"> 
                <b>Success!</b> Account details were sent to his/her email. 
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>' . "<script>$('#fname').val('');$('#mname').val('');$('#lname').val('');
                $('#email').val('');
                $('input').removeClass('is-valid'); $('div.container.col').remove(); $('#frmCA').remove(); $('.card-footer').remove(); setTimeout(function(){
                    location = 'dashboard.php'
                },3000);</script>";
                $mail->smtpClose();
            } else {
                $output = '
                <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
                <i class="fa fa-times fs-4 me-2"></i><strong>There was an error in sending email!</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
                $mail->smtpClose();
            }
        } else if (preg_match($nameRegex, $fname) && preg_match($nameRegex, $lname) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $stmt = $conn->query("SELECT * FROM tbl_pending_newadmin");
            $count = $stmt->rowCount();
            $id = 'PNA';
            $id .=  $count + 1 . '-' . date("Y");
            $hashID = password_hash($id, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO tbl_pending_newadmin (id, fname, mname, lname, email) VALUES (:id, :fname, :mname, :lname, :email)");
            $stmt->bindParam(':id', $hashID, PDO::PARAM_STR);
            $stmt->bindParam(':fname', $fname, PDO::PARAM_STR);
            $stmt->bindParam(':mname', $mname, PDO::PARAM_STR);
            $stmt->bindParam(':lname', $lname, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $name = "$fname $lname";
            $data = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcefghijklmnopqrstuvwxyz./';
            $salty = substr(str_shuffle($data), 0, 7);
            $stmt->execute();
            //Email subject
            $mail->Subject = "Request to be an OVS Administrator";
            //Set sender email
            $mail->setFrom('educpurponly101@gmail.com', '1VOTE 4PLMAR Online-Voting System');
            //Enable HTML
            $mail->isHTML(true);
            //Email body
            $mail->Body = "Good day! <b>" . $name . "</b> 
                <br>A request has been offered for you to become an administrator in PLMAR Online Voting System.<br><br><a href=\"https://localhost:3000/new-admin.php?continue=" . $hashID . $salty . "\">Process my account.</a>";
            //Add recipient
            $mail->addAddress($email, 'Receiver');
            $mail->addReplyTo('educpurponly101@gmail.com', '1VOTE 4PLMAR Online-Voting System');

            //Finally send email
            if ($mail->Send()) {
                $output = '<div class="alert alert-success alert-dismissible fade show mt-2" role="alert"> 
                <b>Success!</b> Account details were sent to his/her email. 
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>' . "<script>$('#fname').val('');$('#mname').val('');$('#lname').val('');
                $('#email').val('');
                $('input').removeClass('is-valid'); $('div.container.col').remove(); $('#frmCA').remove(); $('.card-footer').remove(); setTimeout(function(){
                    location = 'dashboard.php'
                },3000);</script>";
                $mail->smtpClose();
            } else {
                $output = '
                <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
                <i class="fa fa-times fs-4 me-2"></i><strong>There was an error in sending email!</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
                $mail->smtpClose();
            }
        } else {
            $errFname = (!preg_match($nameRegex, $fname)) ? "firstname " : "";
            $errMname = (!preg_match($nameRegex, $mname)) ? "middlename " : "";
            $errLname = (!preg_match($nameRegex, $lname)) ? "lastname " : "";
            $errEmail = (!filter_var($email, FILTER_VALIDATE_EMAIL)) ? "email" : "";
            $errName = $errFname . $errMname . $errLname;
            $output = '
            <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
            <i class="fa fa-times fs-4 me-2"></i><strong>Invalid ' . $errName . $errEmail . ' format!</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        }
    }
} else {
    $output = '
    <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
    <i class="fa fa-times fs-4 me-2"></i><strong>There was an error!</strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
}
$output .= "<script>$('#btnCA').text('Create Account').prop('disabled', false); $('#loader').hide()


$('.alert').delay(9000).slideUp(200, function() {
    $(this).alert('close');
});

;</script>";
echo $output;
