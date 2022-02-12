<?php
include '../functions.php';
$conn = MYSQL_DB_Connection();
if (isset($_POST["id"])) {
    $stmt = $conn->prepare("SELECT * FROM tbl_vote_sched WHERE vs_org_id = ?");
    $stmt->execute([$_POST["id"]]);

    if ($stmt->rowCount()==0) {
        $stmt = $conn->prepare("INSERT INTO tbl_vote_sched (vs_org_id, vs_start_date, vs_end_date) VALUES (?,?,?)");
        $stmt->execute([$_POST["id"], $_POST["start_dt"], $_POST["end_dt"]]);
    } else {
        $stmt = $conn->prepare("UPDATE tbl_vote_sched SET vs_org_id = ?, vs_start_date = ?, vs_end_date = ?
        WHERE vs_org_id = ?");
        $stmt->execute([$_POST["id"], $_POST["start_dt"], $_POST["end_dt"], $_POST["id"]]);
    }   
    header("Location: v_sched.php");
}
else {
    echo "nothing";
}