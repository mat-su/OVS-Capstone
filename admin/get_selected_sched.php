<?php
require_once '../functions.php';
$conn = MYSQL_DB_Connection();
extract($_POST);
$sched = Select_VotingSched($id);

if($sched){
    $resp['status'] = 'success';
    $resp['data'] = $sched;
}else{
    $resp['status'] = 'success';
    $resp['error'] = 'An error occured while fetching the data. Error: '.$conn->error;
}
echo json_encode($resp);