<?php
session_start();
require_once '../functions.php';
$conn = MYSQL_DB_Connection();
extract($_POST);
if (isset($position) && isset($seats) && isset($_SESSION['sa_org_id'])) {
    $sa_orgid = $_SESSION['sa_org_id'];
    $stmt = $conn->prepare("SELECT * FROM tbl_org_struct WHERE position = :position AND org_id = :org_id");
    $stmt->bindParam(":position", $position, pdo::PARAM_STR);
    $stmt->bindParam(":org_id", $sa_orgid, pdo::PARAM_INT);
    $stmt->execute();
    if (!$stmt->rowCount() > 0) {
        $stmt = $conn->prepare("INSERT INTO tbl_org_struct (org_id, position, seats) VALUES (?, ?, ?)");
        $stmt->execute([$sa_orgid, $position, $seats]);
        $resp['status'] = 'success';
    } else {
        $resp['status'] = 'failed';
        $resp['msg'] = "The position already existed";
    }
} else {
    $resp['status'] = 'failed';
    $resp['msg'] = "An error occured while processing the request!";
}
echo json_encode($resp);
