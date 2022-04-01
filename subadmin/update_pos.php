<?php
require_once '../functions.php';
session_start();
$conn = MYSQL_DB_Connection();
extract($_POST);

if (isset($position) && isset($seats) && isset($pos_id) && isset($_SESSION['sa_org_id'])) {
    $sa_orgid = $_SESSION['sa_org_id'];
    $stmt = $conn->prepare("SELECT * FROM tbl_org_struct WHERE id = :id");
    $stmt->bindParam(':id', $pos_id, pdo::PARAM_INT);
    $stmt->execute();
    $pos = $stmt->fetch(PDO::FETCH_ASSOC);
    $origPos = $pos['position'];
    $stmt = $conn->prepare("SELECT * FROM tbl_org_struct WHERE position = :position AND org_id = :org_id");
    $stmt->bindParam(":position", $position, pdo::PARAM_STR);
    $stmt->bindParam(":org_id", $sa_orgid, pdo::PARAM_INT);
    $stmt->execute();
    
    if (strtolower($origPos) == strtolower($position) || $stmt->rowCount() == 0){
        $stmt = $conn->prepare("UPDATE tbl_org_struct SET position = :pos, seats = :seats WHERE id = :id AND org_id = :org_id");
        $stmt->bindParam(':pos', $position, pdo::PARAM_STR);
        $stmt->bindParam(':seats', $seats, pdo::PARAM_INT);
        $stmt->bindParam(':id', $pos_id, pdo::PARAM_INT);
        $stmt->bindParam(':org_id', $sa_orgid, pdo::PARAM_INT);
        $stmt->execute();
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