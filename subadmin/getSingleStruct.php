<?php
session_start();
require '../functions.php';
$conn =  MYSQL_DB_Connection();
$sa_orgid = $_SESSION['sa_org_id'];
extract($_POST);
$positions = $conn->prepare("SELECT os.id AS id, os.position AS position, os.seats AS seats FROM tbl_org_struct os LEFT JOIN tbl_stud_orgs o ON os.org_id = o.org_id 
WHERE os.org_id = :orgid AND os.id = :id");
$positions->bindParam(":orgid", $sa_orgid, pdo::PARAM_INT);
$positions->bindParam(":id", $id, pdo::PARAM_INT);
$positions->execute();
if($positions){
    $resp['status'] = 'success';
    $resp['data'] = $positions->fetchAll();
}else{
    $resp['status'] = 'success';
    $resp['error'] = 'An error occured while fetching the data. Error: '.$conn->error;
}
echo json_encode($resp);