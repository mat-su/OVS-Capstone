<?php
session_start();
require '../functions.php';
$conn =  MYSQL_DB_Connection();
$sa_orgid = $_SESSION['sa_org_id'];
extract($_POST);
$partylists = $conn->prepare("SELECT p.id AS id, p.pname AS partylist FROM tbl_partylist p LEFT JOIN tbl_stud_orgs o ON p.p_orgid = o.org_id WHERE p.p_orgid = :orgid AND p.id = :id");
$partylists->bindParam(":orgid", $sa_orgid, pdo::PARAM_INT);
$partylists->bindParam(":id", $id, pdo::PARAM_INT);
$partylists->execute();
if($partylists){
    $resp['status'] = 'success';
    $resp['data'] = $partylists->fetchAll();
}else{
    $resp['status'] = 'success';
    $resp['error'] = 'An error occured while fetching the data. Error: '.$conn->error;
}
echo json_encode($resp);