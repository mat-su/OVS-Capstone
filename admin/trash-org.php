<?php 
include '../functions.php';
$conn = MYSQL_DB_Connection();
if (isset($_POST["id"])) {
    $stmt = $conn->prepare("DELETE FROM tbl_stud_orgs
    WHERE org_id = :id");
    $stmt->bindParam(':id', $_POST["id"], pdo::PARAM_STR);
    $stmt->execute();
    header("Location: stud_org.php");
}

