<?php
include '../functions.php';
session_start();
$conn = MYSQL_DB_Connection();
if (isset($_POST['submit']) && !empty($_POST['platform'])) {
    $platform = htmlspecialchars($_POST['platform']);
    $stmt = $conn->prepare("SELECT * FROM tbl_can_info WHERE ci_id = :can_id");
    $stmt->bindParam(':can_id', $_SESSION['c_id'], PDO::PARAM_STR);
    $stmt->execute();

    if ($stmt->rowCount() == 0) {
        $sql = "INSERT INTO tbl_can_info (ci_id, ci_platform) VALUES (:can_id, :platform)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':can_id', $_SESSION['c_id'], PDO::PARAM_STR);
        $stmt->bindParam(':platform', $platform, PDO::PARAM_STR);
    } else {
        $sql = "UPDATE tbl_can_info SET ci_platform = :platform WHERE ci_id = :can_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':platform', $platform, PDO::PARAM_STR);
        $stmt->bindParam(':can_id', $_SESSION['c_id'], PDO::PARAM_STR);
    }

    $stmt->execute();
    header("Location: im-a-candidate.php?info=Platform info saved successfully!");
} else {
    header("Location: im-a-candidate.php?err=Failed to save platform info!!!");
}
