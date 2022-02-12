<?php
require_once '../functions.php';
session_start();
$conn = MYSQL_DB_Connection();
extract($_POST);

if (isset($partylist) && isset($id) && isset($_SESSION['sa_org_id'])) {
    $sa_orgid = $_SESSION['sa_org_id'];
    $stmt = $conn->prepare("SELECT * FROM tbl_partylist WHERE id = :id");
    $stmt->bindParam(':id', $id, pdo::PARAM_INT);
    $stmt->execute();
    $party = $stmt->fetch(PDO::FETCH_ASSOC);
    $origParty = $party['pname'];
    $stmt = $conn->prepare("SELECT * FROM tbl_partylist WHERE pname = :pname AND p_orgid = :org_id");
    $stmt->bindParam(":pname", $partylist, pdo::PARAM_STR);
    $stmt->bindParam(":org_id", $sa_orgid, pdo::PARAM_INT);
    $stmt->execute();
    
    if ($origParty == $partylist || $stmt->rowCount() == 0){
        $stmt = $conn->prepare("UPDATE tbl_partylist SET pname = :pname WHERE id = :id AND p_orgid = :org_id");
        $stmt->bindParam(':pname', $partylist, pdo::PARAM_STR);
        $stmt->bindParam(':id', $id, pdo::PARAM_INT);
        $stmt->bindParam(':org_id', $sa_orgid, pdo::PARAM_INT);
        $stmt->execute();
        $resp['status'] = 'success';
    } else {
        $resp['status'] = 'failed';
        $resp['msg'] = "The partylist already existed";
    }
} else {
    $resp['status'] = 'failed';
    $resp['msg'] = "An error occured while processing the request!";
}
echo json_encode($resp);