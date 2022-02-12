<?php
require_once '../functions.php';
session_start();
$conn = MYSQL_DB_Connection();
extract($_POST);

if (isset($id) && isset($_SESSION['sa_org_id']) && !empty($party) && !empty($position) && !empty($studnum) && !empty($fname) && !empty($mname) && !empty($lname)) {
    $sa_orgid = $_SESSION['sa_org_id'];

    $stmt = $conn->prepare("SELECT * FROM tbl_candidates WHERE c_id = ?");
    $stmt->execute([$id]);
    $candi = $stmt->fetch(PDO::FETCH_ASSOC);
    //check if readonly were not altered
    if ($candi['c_studnum'] == $studnum && $candi['c_fname'] == $fname && $candi['c_mname'] == $mname && $candi['c_lname'] == $lname) {

        $stmt = $conn->prepare("SELECT COUNT(c_position) AS seated FROM tbl_candidates WHERE c_orgid = ? AND c_position = ? AND c_party = ?");
        $stmt->execute([$sa_orgid, $position, $party]);
        $can = $stmt->fetch(PDO::FETCH_ASSOC);
        $seated = $can['seated'];

        $stmt = $conn->prepare("SELECT seats FROM tbl_org_struct WHERE org_id = ? AND id = ?");
        $stmt->execute([$sa_orgid, $position]);
        $org = $stmt->fetch(PDO::FETCH_ASSOC);
        $seats = $org['seats'];

        //check if a seat is available in a party
        if ($seated < $seats || $candi['c_position'] == $position && $candi['c_party'] == $party) {
            $stmt = $conn->prepare("UPDATE tbl_candidates SET c_party = ?, c_position = ? WHERE c_studnum = ?");
            $stmt->execute([$party, $position, $studnum]);
            $resp['status'] = "success";
        } else {
            $resp['status'] = 'failed';
            $resp['msg'] = "SORRY! There is no available seats for that position.";
        }
    } else {
        $resp['status'] = 'failed';
        $resp['msg'] = "An error occured while processing the request!";
    }
} else {
    $resp['status'] = 'failed';
    $resp['msg'] = "An error occured while processing the request!";
}
echo json_encode($resp);
