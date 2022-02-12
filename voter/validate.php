<?php
session_start();
include '../functions.php';
$conn = MYSQL_DB_Connection();

if (isset($_POST['org'])) {
    $selectedOrg = $_POST['org'];
    
    if (!empty($selectedOrg)) {
        $stmt = $conn->prepare("SELECT * FROM tbl_voter WHERE v_id = :id");
        $stmt->bindParam(':id', $_SESSION['v_id'], PDO::PARAM_STR);
        $stmt->execute();
        $voter = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt = $conn->prepare("SELECT * FROM tbl_stud_orgs o LEFT JOIN tbl_course c ON o.org_course_id = c.id WHERE o.org_id = :id");
        $stmt->bindParam(':id', $selectedOrg, PDO::PARAM_STR);
        $stmt->execute();
        $org = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($voter['v_course'] === $org['course']) {
            $_SESSION['org_id'] = $selectedOrg;
            $_SESSION['org_name'] = $org['org_name'] . ' (' . $org['org_acronym'] . ')';
            $_SESSION['org_acr'] = $org['org_acronym'];
            header("Location: dashboard.php");
        } else {
            header("Location: select-org.php?error=Your not a member of that organization");
        }

    } else {
        header("Location: select-org.php?error=You haven't select an organization");
    }
} else {
    header("Location: select-org.php?error=You haven't select an organization");
}