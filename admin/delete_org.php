<?php
require '../functions.php';
$conn = MYSQL_DB_Connection();
$stmt = $conn->prepare("DELETE FROM tbl_stud_orgs
    WHERE org_id = :id");
$stmt->bindParam(':id', $_POST["org_id"], pdo::PARAM_STR);
$stmt->execute();
if ($stmt) {
    $resp['status'] = "success";
} else {
    $resp['status'] = 'failed';
    $resp['msg'] = 'An error occured while deleting the data. Error: ' . $conn->error;
}

echo json_encode($resp);
