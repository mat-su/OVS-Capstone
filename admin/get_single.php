<?php
require_once '../functions.php';
$conn = MYSQL_DB_Connection();
extract($_POST);
$subadmins = $conn->prepare("SELECT s.sa_id AS id, s.sa_fname AS fname, s.sa_mname AS mname, s.sa_lname AS lname, s.sa_email AS email, o.org_id AS org_id, CONCAT(o.org_name, ' (', o.org_acronym, ')') AS Org_Name FROM tbl_subadmin s LEFT JOIN tbl_stud_orgs o ON s.sa_org_id = o.org_id WHERE s.sa_id = :id");
$subadmins->bindParam(':id', $id, pdo::PARAM_STR);
$subadmins->execute();

if($subadmins){
    $resp['status'] = 'success';
    $resp['data'] = $subadmins->fetchAll();
}else{
    $resp['status'] = 'success';
    $resp['error'] = 'An error occured while fetching the data. Error: '.$conn->error;
}
echo json_encode($resp);