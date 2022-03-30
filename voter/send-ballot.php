<?php
session_start();
include '../mail.php';
require '../functions.php';
$conn = MYSQL_DB_Connection();
if (isset($_SESSION['v_id']) && isset($_SESSION['v_email']) && isset($_SESSION['org_id']) && isset($_SESSION['org_name'])) {
    $voter_id = $_SESSION['v_id'];
    $stmt = $conn->prepare("SELECT v_id, v_status FROM tbl_voter_status WHERE v_id = :v_id");
    $stmt->bindParam(':v_id', $voter_id, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount() == 0) {
        if (isset($_POST['submit'])) {
            $voter_email = $_SESSION['v_email'];
            $org_id = $_SESSION['org_id'];
            $orgs = fetchAll_OrgStructure($org_id);
            $isValid = true;
            foreach ($orgs as $o) { //first for loop to check ballot (multiple seats) is valid and criteria was met 
                $cleanIndex = str_replace(" ", "_", $o['position']);
                if (!empty($_POST[$cleanIndex])) { //check whether a candidate for that position is empty
                    if (is_array($_POST[$cleanIndex])) {
                        $c = count($_POST[$cleanIndex]);
                        if ($c > $o['seats']) {
                            $isValid = false;
                            break;
                        }
                    }
                }
            }
            if (!$isValid) {
                //there was an error in selecting a number of candidate
                header("Location: ballot-form.php?err=There was an error in selecting a number of candidates. Please select a candidate accordingly!");
            } else if ($isValid) {
                $receipt = '
            
            ';




                $receipt .= '<h1>VOTING RECEIPT</h1><h2>' . $_SESSION['org_name'] . '</h2>';
                foreach ($orgs as $o) { //second loop to process ballot
                    $cleanIndex = str_replace(" ", "_", $o['position']);
                    if (!empty($_POST[$cleanIndex])) { //check whether a candidate for that position is empty
                        if (!is_array($_POST[$cleanIndex])) { //single seat
                            $can = SelectAll_CandidateWithInfo($_POST[$cleanIndex]);
                            $receipt .= $o['position'] . ': ' . $can['Name'] . '<br />';

                            $stmt = $conn->prepare("INSERT INTO tbl_tally (v_id, can_id) VALUES (?, ?)");
                            $stmt->bindParam(1, $voter_id, PDO::PARAM_INT);
                            $stmt->bindParam(2, $_POST[$cleanIndex], PDO::PARAM_INT);
                            $stmt->execute();
                        } else {
                            $c = count($_POST[$cleanIndex]);
                            for ($i = 0; $i < $c; $i++) {  //multiple seats
                                $can = SelectAll_CandidateWithInfo($_POST[$cleanIndex][$i]);
                                $receipt .= $o['position'] . ' ' . ($i + 1) . ': ' . $can['Name'] . '<br />';

                                $stmt = $conn->prepare("INSERT INTO tbl_tally (v_id, can_id) VALUES (?, ?)");
                                $stmt->bindParam(1, $voter_id, PDO::PARAM_INT);
                                $stmt->bindParam(2, $_POST[$cleanIndex][$i], PDO::PARAM_INT);
                                $stmt->execute();
                            }
                        }
                    } else {
                        //need for receipt even the voter has not selected a candidate
                        $receipt .= $o['position'] . ': -----<br />';
                    }
                }
                //update status of voter to already voted
                $stmt = $conn->prepare("INSERT INTO tbl_voter_status (v_id, v_status) VALUES (?,?)");
                $stmt->execute([$voter_id, 'voted']);

                //mail the voting receipt    
                //Email subject
                $mail->Subject = "VOTING RECEIPT";
                //Set sender email
                $mail->setFrom('educpurponly101@gmail.com', '1VOTE 4PLMAR Online-Voting System');
                //Enable HTML
                $mail->isHTML(true);

                //Email body
                $mail->Body = $receipt;
                //Add recipient
                $mail->addAddress($voter_email, 'Receiver');
                $mail->addReplyTo('educpurponly101@gmail.com', '1VOTE 4PLMAR Online-Voting System');
                //Finally send email
                if ($mail->Send()) {
                    //success
                } else {
                    //mailer error
                }
                $mail->smtpClose();
                header("Location: voting_success.php");
            }
        } else {
            echo "There was an error";
            echo '<script>
        setTimeout(function(){
            location = \'dashboard.php\'
        },3000)
        </script>';
        }
    } else {
        echo "Sorry you already cast a vote!";
        echo '<script>
        setTimeout(function(){
            location = \'dashboard.php\'
        },3000)
        </script>';
    }
} else {
    header("Location: ../index.php");
}
