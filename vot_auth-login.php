<?php
include 'functions.php';
session_start();
$conn = MYSQL_DB_Connection();

if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM tbl_voter WHERE v_email = :email");
    $stmt->bindParam(':email', $email, pdo::PARAM_STR);
    $stmt->execute();

    $e = $stmt->rowCount();

    if ($stmt->rowCount() == 1) {
        $voter = $stmt->fetch();
        $voter_id = $voter['v_id'];
        $voter_fname = $voter['v_fname'];
        $voter_mname = $voter['v_mname'];
        $voter_lname = $voter['v_lname'];
        $voter_studnum = $voter['v_studnum'];
        $voter_email = $voter['v_email'];
        $voter_password = $voter['v_password'];

        if (password_verify($password, $voter_password)) {
            $_SESSION['v_id'] = $voter_id;
            $_SESSION['v_fname'] = $voter_fname;
            $_SESSION['v_mname'] = $voter_mname;
            $_SESSION['v_lname'] = $voter_lname;
            $_SESSION['v_studnum'] = $voter_studnum;
            $_SESSION['v_email'] = $voter_email;
            $_SESSION['v_password'] = $voter_password;

            header("Location: voter/select-org.php");
        } else {
            if ($_SESSION['index']) {
                header("Location: index.php?error=Incorrect Email or Password");
            } else {
                header("Location: signup.php?error=Incorrect Email or Password");
            }
        }
    } else {
        if ($_SESSION['index']) {
            header("Location: index.php?error=Incorrect Email or Password");
        } else {
            header("Location: signup.php?error=Incorrect Email or Password");
        }
    }
}
