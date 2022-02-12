<?php
include '../functions.php';
$conn = MYSQL_DB_Connection();

if (isset($_POST['org_name']) && isset($_POST['org_acronym']) && isset($_POST['course_id'])) {
    $org_name = $_POST['org_name'];
    $org_acronym = $_POST['org_acronym'];
    $course_id = $_POST['course_id'];

    $stmt = $conn->prepare("INSERT INTO tbl_stud_orgs (org_name, org_acronym, org_course_id) VALUES (?, ?, ?)");
    $stmt->execute([$org_name, $org_acronym, $course_id]);
    
    header("Location: stud_org.php");
}
