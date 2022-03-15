<?php
include 'functions.php';
include 'mail.php';

$conn = MYSQL_DB_Connection();

if (isset($_POST['fname']) && isset($_POST['mname']) && isset($_POST['lname']) && isset($_POST['studnum']) && isset($_POST['course']) && isset($_POST['email'])) {
    $fname = $_POST['fname'];
    $mname = $_POST['mname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $course = $_POST['course'];
    $studnum = $_POST['studnum'];

    if (!empty($fname) && !empty($mname) && !empty($lname) && !empty($studnum) && !empty($course) && !empty($email)) {

        $stmt = $conn->prepare("SELECT * FROM tbl_emailotp WHERE email = ? AND stats = ?");
        $stmt->execute([$email, "verified"]);

        if ($stmt->rowCount() == 1) {
            $stmt = $conn->prepare("SELECT * FROM tbl_enr_stud WHERE enr_studnum = :studnum && enr_fname = :fname && enr_mname = :mname && enr_lname = :lname && enr_course = :course");
            $stmt->execute([$studnum, $fname, $mname, $lname, $course]);
            $stud = $stmt->fetch(PDO::FETCH_ASSOC);
            $fullname = $stud['enr_fname'] . " " . $stud['enr_mname'] . " " . $stud['enr_lname'];
            if ($stmt->rowCount() == 1) {

                $stmt = $conn->prepare("SELECT * FROM tbl_voter WHERE v_studnum = :studnum");
                $stmt->execute([$studnum]);

                if ($stmt->rowCount() == 0) {
                    $stmt = $conn->prepare("DELETE FROM tbl_emailotp WHERE email = ?");
                    $stmt->execute([$email]);
                        

                    $stmt = $conn->prepare("INSERT INTO tbl_voter (v_fname, v_mname, v_lname, v_studnum, v_course, v_email, v_password) VALUES (?, ?, ?, ?, ?, ?, ?)");

                    $temp_pass = password_generate(8);
                    $hashed_password = password_hash($temp_pass, PASSWORD_DEFAULT);

                    $stmt->execute([$stud['enr_fname'], $stud['enr_mname'], $stud['enr_lname'], $studnum, $course, $email, $hashed_password]);

                    //Email subject
                    $mail->Subject = "Successfully Registered";
                    //Set sender email
                    $mail->setFrom('educpurponly101@gmail.com', '1VOTE 4PLMAR Online-Voting System');
                    //Enable HTML
                    $mail->isHTML(true);
                    //Email body
                    $mail->Body = "Hi <b>$fullname</b>, <br>Your Registration is <b>APPROVED!!</b> <br> You can now login to your account.<br>Just use your email and your temporary password. <br> Here is your temporary password: <b>$temp_pass</b> <br><br><b>Note</b>: Change your password immediately once you logged in!";
                    //Add recipient
                    $mail->addAddress($email, 'Receiver');
                    $mail->addReplyTo('educpurponly101@gmail.com', '1VOTE 4PLMAR Online-Voting System');
                    //Finally send email
                    if ($mail->Send()) {
                        header("Location: success.php");
                        $mail->smtpClose();
                    } else {
                        header("Location: response.php?error=Mailer Error!!");
                        $mail->smtpClose();
                    }
                } else {
                    header("Location: response.php?error=Sorry you were already registered!!");
                }
            } else {
                header("Location: response.php?error=Sorry you were not on the list of enrolled students of Pamantasan ng Lungsod ng Marikina!!");
            }
        } else {
            header("Location: response.php?error=Email registered was not verified..! Please try to register again.");
        }
    } else {
        header("Location: response.php?error=Error please fill-in all fields!!");
    }
} else {
    header("Location: response.php?error=Error!!");
}
