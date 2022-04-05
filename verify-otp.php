<?php
session_start();
include 'functions.php';
$conn = MYSQL_DB_Connection();

$output = '';
if (isset($_POST['otp']) && !empty($_POST['otp']) && !empty($_SESSION['user_email'])) {
    $otp = $_POST['otp'];
    $stmt = $conn->prepare("SELECT * FROM tbl_emailotp WHERE email = ?");
    $stmt->execute([$_SESSION['user_email']]);

    if ($stmt->rowCount() == 1) {
        $u = $stmt->fetch();
        $u_otp = $u['otp'];

        if (password_verify($otp, $u_otp)) {
            $stmt = $conn->prepare("UPDATE tbl_emailotp SET stats = ? WHERE email = ?");
            $stmt->execute(["verified", $_SESSION['user_email']]);
            $output = '<b class="text-success">Verified!!</b>' . "<script>$('#btn_sendOTP, #getdetails').remove();
            $('#v_input_group').css('display','none');
            </script>";
            session_unset();
            session_destroy();
        } else {
            $output = '
            <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
            <span>Wrong OTP!</span>
            </div>';
        
        }
    }
}
$output .= "<script>
$('.alert').delay(2000).slideUp(200, function() {
    $(this).alert('close');
});
</script>

";

echo $output;
