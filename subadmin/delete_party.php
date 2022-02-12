<?php
require_once '../functions.php';
session_start();
$conn = MYSQL_DB_Connection();
extract($_POST);

if (isset($id) && isset($_SESSION['sa_org_id'])) {
    $sa_orgid = $_SESSION['sa_org_id'];
    $stmt = $conn->prepare("DELETE FROM tbl_partylist
    WHERE id = :id AND p_orgid = :org_id");
    $stmt->bindParam(':id', $id, pdo::PARAM_INT);
    $stmt->bindParam(':org_id', $sa_orgid, pdo::PARAM_INT);
    $stmt->execute();
    $resp['status'] = 'success';
} else {
    $resp['status'] = 'failed';
    $resp['msg'] = "An error occured while processing the request!";
}
echo json_encode($resp);