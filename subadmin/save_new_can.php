<?php
session_start();
require_once '../functions.php';
$conn = MYSQL_DB_Connection();
extract($_POST);
if (isset($_SESSION['sa_org_id']) && !empty($party) && !empty($position) && !empty($studnum)) {

    if (!empty($fname) && !empty($mname) && !empty($lname)) {
        $sa_orgid = $_SESSION['sa_org_id'];
        $stmt = $conn->prepare("SELECT * FROM tbl_enr_stud WHERE enr_studnum = ?");
        $stmt->execute([$studnum]);
        $stud = $stmt->fetch(pdo::FETCH_ASSOC);
        $studFname = $stud['enr_fname'];
        $studMname = $stud['enr_mname'];
        $studLname = $stud['enr_lname'];
        //check if student number and name is correct and was not altered
        if ($studFname === $fname && $studMname === $mname && $studLname === $lname) {
            $stmt = $conn->prepare("SELECT * FROM tbl_candidates WHERE c_studnum = ? and c_orgid = ?");
            $stmt->execute([$studnum, $sa_orgid]);
            //check if student is never a candidate 
            if ($stmt->rowCount() == 0) {
                $stmt = $conn->prepare("SELECT COUNT(c_position) AS seated FROM tbl_candidates WHERE c_orgid = ? AND c_position = ? AND c_party = ?");
                $stmt->execute([$sa_orgid, $position, $party]);
                $can = $stmt->fetch(PDO::FETCH_ASSOC);
                $seated = $can['seated'];

                $stmt = $conn->prepare("SELECT seats FROM tbl_org_struct WHERE org_id = ? AND id = ?");
                $stmt->execute([$sa_orgid, $position]);
                $org = $stmt->fetch(PDO::FETCH_ASSOC);
                $seats = $org['seats'];

                //check if a seat is available in a party
                if ($seated < $seats) {
                    $stmt = $conn->prepare("INSERT INTO tbl_candidates (c_studnum, c_fname, c_mname, c_lname, c_party, c_position, c_orgid) VALUES (?, ?, ?, ?, ?, ?, ?)");
                    $stmt->execute([$studnum, $fname, $mname, $lname, $party, $position, $sa_orgid]);
                    $resp['status'] = 'success';
                } else {
                    $resp['status'] = 'failed';
                    $resp['msg'] = "SORRY! There is no available seats for that position.";
                }
            } else {
                $resp['status'] = 'failed';
                $resp['msg'] = "SORRY! The student selected is already a candidate.";
            }
        } else {
            $resp['status'] = 'failed';
            $resp['msg'] = "An error occured while processing the request!";
        }
    } else {
        $resp['status'] = 'failed';
        $resp['msg'] = "Select a student through searching its student number!";
    }
} else {
    $resp['status'] = 'failed';
    $resp['msg'] = "An error occured while processing the request!";
}
echo json_encode($resp);
