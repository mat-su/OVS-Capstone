<?php
require_once '../functions.php';
$conn = MYSQL_DB_Connection();
extract($_POST);

if (!empty($org_name) && !empty($org_acronym) && !empty($course_id)) {


    $stmt = $conn->prepare("SELECT org_id, org_name FROM tbl_stud_orgs WHERE org_id = :org_id");
    $stmt->bindParam(':org_id', $org_id, PDO::PARAM_STR);
    $stmt->execute();
    $ORG = $stmt->fetch(PDO::FETCH_ASSOC);
    
    $stmt = $conn->prepare("SELECT org_id, org_name FROM tbl_stud_orgs WHERE org_name = :org_name");
    $stmt->bindParam(':org_name', $org_name, PDO::PARAM_STR);
    $stmt->execute();

    if ($stmt->rowCount() == 0 || strtolower($ORG['org_name']) == strtolower($org_name)) {
        $stmt = $conn->prepare("UPDATE tbl_stud_orgs SET org_name = :org_name, org_acronym = :org_acronym, org_course_id = :course_id WHERE org_id = :id");
        $stmt->bindParam(':org_name', $org_name, PDO::PARAM_STR);
        $stmt->bindParam(':org_acronym', $org_acronym, PDO::PARAM_STR);
        $stmt->bindParam(':course_id', $course_id, PDO::PARAM_INT);
        $stmt->bindParam(':id', $org_id, PDO::PARAM_INT);
        $stmt->execute();
        $resp['status'] = 'success';
    } else {
        $resp['status'] = 'success';
        $resp['msg'] = 'Organization Name Already Exists!';
    }
} else {
    $resp['status'] = 'failed';
    $resp['msg'] = 'An error occured while processing the request!!';
}
echo json_encode($resp);
