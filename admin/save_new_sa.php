<?php
require_once '../functions.php';
include '../mail.php';

$conn = MYSQL_DB_Connection();
extract($_POST);
$stmt = $conn->query("set autocommit = 0;"); //to have access on disregarding the recent changes in sql [rollback]
$stmt = $conn->prepare("SELECT * FROM tbl_subadmin WHERE sa_org_id = :org_id");
$stmt->bindParam(':org_id', $org, PDO::PARAM_INT);
$stmt->execute();

$emailRegex = '/^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/';
$nameRegex = "/^[a-zA-Z]+(([',. -][a-zA-Z ])?[a-zA-Z]*)*$/";

if (isset($fname) && isset($lname) && isset($email) && isset($org) && preg_match($nameRegex, $fname) && preg_match($nameRegex, $lname)) {

    if ($stmt->rowCount() == 0) { //check if subadmin already existed in the selected org
        if (!empty($mname) && !preg_match($nameRegex, $mname)) {
            $resp['status'] = 'failed';
            $resp['msg'] = "An error occured while processing the request!";
        } else {
            if (filter_var($email, FILTER_VALIDATE_EMAIL) && preg_match($emailRegex, $email)) {
                $username = strtolower(substr($fname, 0, 1) . substr($mname, 0, 1) . $lname . $org);

                $stmt = $conn->prepare("SELECT org_name FROM tbl_stud_orgs WHERE org_id = :org_id");
                $stmt->bindParam(':org_id', $org, PDO::PARAM_STR);
                $stmt->execute();
                $o = $stmt->fetch(PDO::FETCH_ASSOC);
                $organization = $o['org_name'];

                $temp_pass = password_generate(8);
                $hashed_password = password_hash($temp_pass, PASSWORD_DEFAULT);

                $stmt = $conn->prepare("INSERT INTO tbl_subadmin (sa_fname, sa_mname, sa_lname, sa_email, sa_org_id, sa_username, sa_password) VALUES (?, ?, ?, ?, ?, ?, ?)");
                $stmt->execute([$fname, $mname, $lname, $email, $org, $username, $hashed_password]);

                //Email subject
                $mail->Subject = "OVS Subadmin Account Details";
                //Set sender email
                $mail->setFrom('educpurponly101@gmail.com', '1VOTE 4PLMAR Online-Voting System');
                //Enable HTML
                $mail->isHTML(true);
                //Email body
                $mail->Body = "OVS welcomes you as a subadmin/adviser to <b>$organization</b>. 
            <br> You can now login to your account. Just use the given username and your temporary password. <br> Here is your username: <b>$username</b> and temporary password: <b>$temp_pass</b>";
                //Add recipient
                $mail->addAddress($email, 'Receiver');
                $mail->addReplyTo('educpurponly101@gmail.com', '1VOTE 4PLMAR Online-Voting System');

                //Finally send email
                if ($mail->Send()) {
                    $mail->smtpClose();
                    if ($stmt) {
                        $resp['status'] = 'success';
                        $resp['feedback'] = "An email containing Sub Admin account was sent successfully!";
                    }
                } else {
                    $resp['status'] = 'failed';
                    $stmt = $conn->query("Rollback;");
                    $resp['msg'] = "Error! Message containing Sub Admin details could not be sent. Mailer Error: {$mail->ErrorInfo}";
                    $mail->smtpClose();
                }
            } else {
                $resp['status'] = 'failed';
                $resp['msg'] = "Invalid email!... Please enter a valid email";
            }
        }
    } else {
        $resp['status'] = 'failed';
        $resp['msg'] = "Sub Admin ALREADY EXISTED in the selected Student Organization!";
    }
} else {
    $resp['status'] = 'failed';
    $resp['msg'] = "An error occured while processing the request!";
}
echo json_encode($resp);
$stmt = $conn->query("set autocommit = 1;"); //to disallow rollback functionality