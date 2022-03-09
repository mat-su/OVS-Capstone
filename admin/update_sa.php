<?php
require_once '../functions.php';
$conn = MYSQL_DB_Connection();
extract($_POST);

$organizations = $conn->prepare("SELECT * FROM tbl_subadmin WHERE sa_org_id = :org_id");
$organizations->bindParam('org_id', $org, PDO::PARAM_INT);
$organizations->execute();

$nameRegex = "/^[a-zA-Z]+(([',. -][a-zA-Z ])?[a-zA-Z]*)*$/";

if (isset($fname) && isset($lname) && isset($email) && isset($org) && preg_match($nameRegex, $fname) && preg_match($nameRegex, $lname)) {
    
    $subadmins = $conn->prepare("SELECT s.sa_id AS id, s.sa_fname AS fname, s.sa_mname AS mname, s.sa_lname AS lname, s.sa_email AS email, o.org_id AS org_id, CONCAT(o.org_name, ' (', o.org_acronym, ')') AS Org_Name FROM tbl_subadmin s LEFT JOIN tbl_stud_orgs o ON s.sa_org_id = o.org_id WHERE s.sa_id = :sa_id");
    $subadmins->bindParam(':sa_id', $sa_id, PDO::PARAM_INT);
    $subadmins->execute();

    $subadmin = $subadmins->fetch(PDO::FETCH_ASSOC);
    $orig_email = $subadmin['email'];
    $orig_studorgID = $subadmin['org_id'];
    if ($orig_studorgID == $org || $organizations->rowCount() == 0) {
        if ($email != $orig_email) {
            $resp['status'] = 'failed';
            $resp['msg'] = "An error occured while processing the request! Please reload the page.";
        } else {
            if (!empty($mname) && !preg_match($nameRegex, $mname)) {
                $resp['status'] = 'failed';
                $resp['msg'] = "Input a valid middle name!";
            } else {
                    $resp['status'] = 'success';
                    $stmt = $conn->prepare("UPDATE tbl_subadmin SET sa_fname = :fname, sa_mname = :mname, sa_lname = :lname, sa_org_id = :org WHERE sa_id = :id");
                    $stmt->bindParam(':fname', $fname, pdo::PARAM_STR);
                    $stmt->bindParam(':mname', $mname, pdo::PARAM_STR);
                    $stmt->bindParam(':lname', $lname, pdo::PARAM_STR);
                    $stmt->bindParam(':org', $org, pdo::PARAM_INT);
                    $stmt->bindParam(':id', $sa_id, pdo::PARAM_INT);
                    $stmt->execute();
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
