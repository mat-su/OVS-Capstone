<?php 
include '../functions.php';
$conn = MYSQL_DB_Connection();
if (isset($_POST["id"])) {
    $stmt = $conn->prepare("DELETE FROM tbl_vote_sched
    WHERE vs_org_id = :id");
    $stmt->bindParam(':id', $_POST["id"], pdo::PARAM_STR);
    $stmt->execute();
    $resp['status'] = "success";
} else {
    $resp['status'] = 'failed';
    $resp['msg'] = 'An error occured while clearing the data. Error: '.$conn->error;
}

echo json_encode($resp);