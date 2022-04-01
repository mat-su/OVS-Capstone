<?php
require '../functions.php';
$conn = MYSQL_DB_Connection();
extract($_POST);

if (!empty($org_name) && !empty($org_acronym) && !empty($course_id)) {

    $stmt = $conn->prepare("SELECT org_id, org_name FROM tbl_stud_orgs WHERE org_name = :org_name");
    $stmt->bindParam(':org_name', $org_name, PDO::PARAM_STR);
    $stmt->execute();

    if($stmt->rowCount() == 0) {
        $stmt = $conn->prepare("INSERT INTO tbl_stud_orgs (org_name, org_acronym, org_course_id) VALUES (?, ?, ?)");
        $stmt->execute([$org_name, $org_acronym, $course_id]);
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
