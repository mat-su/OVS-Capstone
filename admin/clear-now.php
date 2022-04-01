<?php 
include '../functions.php';
$conn = MYSQL_DB_Connection();
if (isset($_POST["id"])) {
    $stmt = $conn->prepare("DELETE FROM tbl_vote_sched
    WHERE vs_org_id = :id");
    $stmt->bindParam(':id', $_POST["id"], pdo::PARAM_STR);
    $stmt->execute();
    $stmt = 
        $conn->prepare("DELETE tbl_tally, tbl_voter_status FROM tbl_voter_status
            LEFT JOIN tbl_voter ON tbl_voter_status.v_id = tbl_voter.v_id
            LEFT JOIN tbl_enr_stud ON tbl_voter.v_studnum = tbl_enr_stud.enr_studnum 
            LEFT JOIN tbl_course ON tbl_course.course = tbl_voter.v_course
            LEFT JOIN tbl_stud_orgs ON tbl_course.id = tbl_stud_orgs.org_course_id
            LEFT JOIN tbl_tally ON tbl_tally.v_id = tbl_voter.v_id 
            WHERE tbl_stud_orgs.org_id = :id");
    $stmt->bindParam(':id', $_POST["id"], pdo::PARAM_STR);
    $stmt->execute();
    $resp['status'] = "success";
} else {
    $resp['status'] = 'failed';
    $resp['msg'] = 'An error occured while clearing the data. Error: '.$conn->error;
}

echo json_encode($resp);