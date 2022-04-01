<?php
require_once '../functions.php';
$conn = MYSQL_DB_Connection();
extract($_POST);
$orgs = $conn->prepare("SELECT o.org_id AS org_id, o.org_name AS org_name, o.org_acronym AS org_acronym, CONCAT(s.sa_fname, ' ', s.sa_lname) AS 'Adviser', c.id AS cID, CONCAT(c.course, ' (', c.acronym, ')') AS CourseName FROM tbl_stud_orgs o LEFT JOIN tbl_subadmin s ON org_id = s.sa_org_id LEFT JOIN tbl_course c ON o.org_course_id = c.id WHERE org_id = :id");
$orgs->bindParam(':id', $id, pdo::PARAM_INT);
$orgs->execute();

if($orgs){
    $resp['status'] = 'success';
    $resp['data'] = $orgs->fetchAll();
}else{
    $resp['status'] = 'success';
    $resp['error'] = 'An error occured while fetching the data. Error: '.$conn->error;
}
echo json_encode($resp);