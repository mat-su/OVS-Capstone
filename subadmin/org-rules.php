<?php
include '../functions.php';
session_start();
$conn = MYSQL_DB_Connection();
if (isset($_POST['submit'])) {
    $rules = htmlspecialchars($_POST['rules-and-reg']);
    $stmt = $conn->prepare("SELECT * FROM tbl_org_rules WHERE org_id = :org_id");
    $stmt->bindParam(':org_id', $_SESSION['sa_org_id'], PDO::PARAM_STR);
    $stmt->execute();

    if ($stmt->rowCount() == 0) {
        $sql = "INSERT INTO tbl_org_rules (rules, org_id) VALUES (:rules, :org_id)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':rules', $rules, PDO::PARAM_STR);
        $stmt->bindParam(':org_id', $_SESSION['sa_org_id'], PDO::PARAM_STR);
    } else {
        $sql = "UPDATE tbl_org_rules SET rules = :rules WHERE org_id = :org_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':rules', $rules, PDO::PARAM_STR);
        $stmt->bindParam(':org_id', $_SESSION['sa_org_id'], PDO::PARAM_STR);
    }

    $stmt->execute();
    header("Location: rules_regulations.php?info=Rules and Regulations detail saved successfully!");
}
