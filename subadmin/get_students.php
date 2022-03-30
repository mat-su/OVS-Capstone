<?php
session_start();
require_once '../functions.php';
$conn =  MYSQL_DB_Connection();
extract($_POST);
$sa_orgid = $_SESSION['sa_org_id'];

$stmt = $conn->prepare("SELECT org_id, org_name, course FROM `tbl_stud_orgs` JOIN tbl_course on tbl_stud_orgs.org_course_id = tbl_course.id WHERE org_id = :org_id");
$stmt->bindParam(':org_id', $sa_orgid, PDO::PARAM_INT);
$stmt->execute();
$orginfo = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt = $conn->prepare("SHOW TABLES LIKE 'tbl_enr_stud'");
$stmt->execute();

if ($stmt->rowCount() == 1) {
    $stmt = "SELECT CONCAT(enr_fname, ' ', enr_mname, ' ', enr_lname) as name , enr_studnum as studnum, enr_yrlevel as ylvl, (CASE WHEN v_id IS NULL THEN 'non-voter' ELSE 'voter' END) as Class FROM tbl_enr_stud LEFT JOIN tbl_voter ON tbl_enr_stud.enr_studnum = tbl_voter.v_studnum WHERE enr_course = '{$orginfo['course']}'";
    $totalCount = $conn->query($stmt)->rowCount();

    $search_where = "";
    if (!empty($search)) {
        $search_where = "  AND ";
        $search_where .= " (enr_fname LIKE '%{$search['value']}%' ";
        $search_where .= " OR enr_mname LIKE '%{$search['value']}%' ";
        $search_where .= " OR enr_lname LIKE '%{$search['value']}%' ";
        $search_where .= " OR enr_studnum LIKE '%{$search['value']}%' ";
        $search_where .= " OR enr_yrlevel LIKE '%{$search['value']}%') ";
    }
    if ($searchByClass != '') {
        $search_where .= " HAVING (class='" . $searchByClass . "') ";
    }
    if ($searchByYrlevel != '') {
        $search_where .= " AND (enr_yrlevel='" . $searchByYrlevel . "') ";
    }

    $columns_arr = array(
        "enr_studnum",
        "name",
        "enr_yrlevel",       
    );

    $query = $conn->query($stmt . $search_where . "ORDER BY {$columns_arr[$order[0]['column']]} {$order[0]['dir']} limit {$length} offset {$start} ");

    $recordsFilterCount = $conn->query($stmt . $search_where)->rowCount();

    $recordsTotal = $totalCount;
    $recordsFiltered = $recordsFilterCount;
    $data = array();
    $i = 1 + $start;
    while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
        $data[] = $row;
    }
} else {
    $recordsFiltered = 0;
    $recordsTotal = 0;
    $data = array();
}

echo json_encode(
    array(
        'draw' => $draw,
        'recordsTotal' => $recordsTotal,
        'recordsFiltered' => $recordsFiltered,
        'data' => $data,
    )
);

