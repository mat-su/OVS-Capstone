<?php
session_start();
require '../functions.php';
$conn =  MYSQL_DB_Connection();
$sa_orgid = $_SESSION['sa_org_id'];
extract($_POST);
$candidates = $conn->prepare("SELECT c.c_id AS id, c.c_studnum AS studnum, c_fname as fname, c.c_mname as mname, c.c_lname as lname, pa.id AS partylist, os.id AS position FROM tbl_candidates c LEFT JOIN tbl_partylist pa ON c.c_party = pa.id LEFT JOIN tbl_org_struct os ON c.c_position = os.id WHERE c.c_orgid = {$sa_orgid} = :orgid AND c.c_id = :id");
$candidates->bindParam(":orgid", $sa_orgid, pdo::PARAM_INT);
$candidates->bindParam(":id", $id, pdo::PARAM_INT);
$candidates->execute();
if($candidates){
    $resp['status'] = 'success';
    $resp['data'] = $candidates->fetchAll();
}else{
    $resp['status'] = 'success';
    $resp['error'] = 'An error occured while fetching the data. Error: '.$conn->error;
}
echo json_encode($resp);