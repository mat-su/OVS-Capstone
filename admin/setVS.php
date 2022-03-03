<?php
include '../functions.php';
$conn = MYSQL_DB_Connection();
date_default_timezone_set('Asia/Hong_Kong');
$current_date = date('Y-m-d H:i:s', time());

if (isset($_POST["id"])) {
    $stmt = $conn->prepare("SELECT * FROM tbl_vote_sched WHERE vs_org_id = ?");
    $stmt->execute([$_POST["id"]]);
    if (strtotime($_POST['startdate']) > strtotime($_POST['enddate'])) { 
        $resp['status'] = 'failed';
        $resp['msg'] = "Start date is ahead on End date!";
    } elseif(strtotime($_POST['startdate']) == strtotime($_POST['enddate'])){
        $resp['status'] = 'failed';
        $resp['msg'] = "Start date and End date cannot be the same!";
    } elseif($_POST['startdate'] < $current_date) {
        $resp['status'] = 'failed';
        $resp['msg'] = "Start date have already passed!!!";
    }
     else{
        if ($stmt->rowCount() == 0) {
            $stmt = $conn->prepare("INSERT INTO tbl_vote_sched (vs_org_id, vs_start_date, vs_end_date) VALUES (?,?,?)");
            $stmt->execute([$_POST["id"], $_POST["startdate"], $_POST["enddate"]]);
        } else {
            $stmt = $conn->prepare("UPDATE tbl_vote_sched SET vs_org_id = ?, vs_start_date = ?, vs_end_date = ?
                WHERE vs_org_id = ?");
            $stmt->execute([$_POST["id"], $_POST["startdate"], $_POST["enddate"], $_POST["id"]]);
        }
        $resp['status'] = 'success';
    }

} else {
    $resp['status'] = 'failed';
    $resp['msg'] = "An error occured while processing the request!";
}
echo json_encode($resp);