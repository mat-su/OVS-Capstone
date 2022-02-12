<?php
session_start();
require_once '../functions.php';
$conn = MYSQL_DB_Connection();
extract($_POST);
if (isset($partylist) && isset($_SESSION['sa_org_id'])) {
    $sa_orgid = $_SESSION['sa_org_id'];
    $stmt = $conn->prepare("SELECT * FROM tbl_partylist WHERE pname = :pname AND p_orgid = :org_id");
    $stmt->bindParam(":pname", $partylist, pdo::PARAM_STR);
    $stmt->bindParam(":org_id", $sa_orgid, pdo::PARAM_INT);
    $stmt->execute();
    if (!$stmt->rowCount() > 0) {
        $stmt = $conn->prepare("INSERT INTO tbl_partylist (pname, p_orgid) VALUES (?,?)");
        $stmt->execute([$partylist, $sa_orgid]);
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
