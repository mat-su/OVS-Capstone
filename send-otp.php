<?php
session_start();
include 'functions.php';
include 'mail.php';
$conn = MYSQL_DB_Connection();
$output = '';
if (isset($_POST['email']) && !empty($_POST['email'])) {
    $email = $_POST['email'];
    $_SESSION['user_email'] = $email;
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $stmt = $conn->prepare("SELECT * FROM tbl_voter WHERE v_email = :email");
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $output = '
            <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
            <span>Sorry! this email is already taken</span>
            </div>';
        } else {
            $stmt = $conn->prepare("DELETE FROM tbl_emailotp WHERE email = :email");
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();
            //Email subject
            $mail->Subject = "Registration: One Time Password";
            //Set sender email
            $mail->setFrom('educpurponly101@gmail.com', '1VOTE 4PLMAR Online-Voting System');
            //Enable HTML
            $mail->isHTML(true);

            $otp = password_generate(6);
            $hashed_otp = password_hash($otp, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO tbl_emailotp (email, otp) VALUES (?, ?)");
            $stmt->execute([$email, $hashed_otp]);

            //Email body
            $mail->Body = "Here is your one time password: <b>$otp</b>";
            //Add recipient
            $mail->addAddress($email, 'Receiver');
            $mail->addReplyTo('educpurponly101@gmail.com', '1VOTE 4PLMAR Online-Voting System');
            //Finally send email
            if ($mail->Send()) {
                $output = '
                <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
                <span>OTP Sent!</span>
                </div>';
                $output .= "<script>$('#v_input_group').prop('hidden', false);
                </script>";
                $mail->smtpClose();
            } else {
                $output .= "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                $mail->smtpClose();
            }
        }
    }
}
$output .= "<script>$('#btn_sendOTP').prop('disabled', false);
$('.alert').delay(4000).slideUp(200, function() {
    $(this).alert('close');
});
</script>

";

echo $output;
