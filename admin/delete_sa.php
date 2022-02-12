<?php
require_once '../functions.php';
$conn = MYSQL_DB_Connection();
extract($_POST);
 
$stmt = $conn->prepare("DELETE FROM tbl_subadmin
    WHERE sa_id = :id");
    $stmt->bindParam(':id', $sa_id, pdo::PARAM_STR);
    $stmt->execute();
if($stmt){
    $resp['status'] = "success";
}else{
    $resp['status'] = 'failed';
    $resp['msg'] = 'An error occured while deleting the data. Error: '.$conn->error;
}
 
echo json_encode($resp);

