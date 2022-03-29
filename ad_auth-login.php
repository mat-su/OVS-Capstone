<?php
include 'functions.php';
session_start();
$conn = MYSQL_DB_Connection();

if (isset($_POST['access']) && isset($_POST['username']) && isset($_POST['password'])) {
    $access = $_POST['access'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    //admin access level
    if ($access == 1) {
        $stmt = $conn->prepare("SELECT a_id, a_fname, a_mname, a_lname, a_email, a_username, a_password, DATE_FORMAT(a_date_created, '%m/%d/%Y') a_date FROM tbl_admin WHERE a_username = :username");
        $stmt->bindParam(':username', $username, pdo::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() == 1) {
            $admin = $stmt->fetch();
            $admin_id = $admin['a_id'];
            $admin_fname = $admin['a_fname'];
            $admin_mname = $admin['a_mname'];
            $admin_lname = $admin['a_lname'];
            $admin_email = $admin['a_email'];
            $admin_username = $admin['a_username'];
            $admin_password = $admin['a_password'];
            $admin_date = $admin['a_date'];
            if (password_verify($password, $admin_password)) {
                $_SESSION['a_id'] = $admin_id;
                $_SESSION['a_fname'] = $admin_fname;
                $_SESSION['a_mname'] = $admin_mname;
                $_SESSION['a_lname'] = $admin_lname;
                $_SESSION['a_username'] = $admin_username;
                $_SESSION['a_email'] = $admin_email;
                $_SESSION['a_password'] = $admin_password;
                $_SESSION['a_date'] = $admin_date;
                $resp['feedback'] = 'authenticated';
                $resp['action'] = 'admin/dashboard.php';
            } else {
                $resp['feedback'] = 'error';
                $resp['action'] = 'Invalid Incorrect Username or Password';;
            }
        } else {
            $resp['feedback'] = 'error';
            $resp['action'] = 'Invalid Incorrect Username or Password';;
        }
    }
    if ($access == 2) {
        $stmt = $conn->prepare("SELECT * FROM tbl_subadmin WHERE sa_username = :username");
        $stmt->bindParam(':username', $username, pdo::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() == 1) {
            $admin = $stmt->fetch();
            $admin_id = $admin['sa_id'];
            $admin_fname = $admin['sa_fname'];
            $admin_mname = $admin['sa_mname'];
            $admin_lname = $admin['sa_lname'];
            $admin_email = $admin['sa_email'];
            $admin_orgid = $admin['sa_org_id'];
            $admin_username = $admin['sa_username'];
            $admin_password = $admin['sa_password'];

            if (password_verify($password, $admin_password)) {
                $_SESSION['sa_id'] = $admin_id;
                $_SESSION['sa_fname'] = $admin_fname;
                $_SESSION['sa_mname'] = $admin_mname;
                $_SESSION['sa_lname'] = $admin_lname;
                $_SESSION['sa_email'] = $admin_email;
                $_SESSION['sa_org_id'] = $admin_orgid;
                $_SESSION['sa_username'] = $admin_username;
                $_SESSION['sa_password'] = $admin_password;
                $resp['feedback'] = 'authenticated';
                $resp['action'] = 'subadmin/dashboard.php';
            } else {
                $resp['feedback'] = 'error';
                $resp['action'] = 'Invalid Incorrect Username or Password';;
            }
        } else {
            $resp['feedback'] = 'error';
            $resp['action'] = 'Invalid Incorrect Username or Password';;
        }
    }
} else {
    $resp['feedback'] = 'error';
    $resp['action'] = 'Please contact your web developer';
}
echo json_encode($resp);
