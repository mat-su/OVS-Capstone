<?php
include '../functions.php';
$conn = MYSQL_DB_Connection();

$org_name = $_POST['org_name'];
$org_acronym = $_POST['org_acronym'];
$course_id = $_POST['course_id'];
$id = $_POST["id"];

$stmt = $conn->prepare("UPDATE tbl_stud_orgs SET org_name = :org_name, org_acronym = :org_acronym, org_course_id = :course_id WHERE org_id = :id");
$stmt->bindParam(':org_name', $org_name, pdo::PARAM_INT);
$stmt->bindParam(':org_acronym', $org_acronym, pdo::PARAM_INT);
$stmt->bindParam(':course_id', $course_id, pdo::PARAM_INT);
$stmt->bindParam(':id', $id, pdo::PARAM_INT);
$stmt->execute();
header("Location: stud_org.php");
