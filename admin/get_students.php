<?php
require_once '../functions.php';
$conn =  MYSQL_DB_Connection();
extract($_POST);

$stmt = $conn->prepare("SHOW TABLES LIKE 'tbl_enr_stud'");
$stmt->execute();

if ($stmt->rowCount() == 1) {
    $stmt = "SELECT CONCAT(enr_fname, ' ', enr_mname, ' ', enr_lname) as name , enr_studnum as studnum, enr_course as course, enr_yrlevel as ylvl FROM tbl_enr_stud";
    $totalCount = $conn->query($stmt)->rowCount();

    $search_where = "";
    if (!empty($search)) {
        $search_where = "  WHERE ";
        $search_where .= " (enr_fname LIKE '%{$search['value']}%' ";
        $search_where .= " OR enr_mname LIKE '%{$search['value']}%' ";
        $search_where .= " OR enr_lname LIKE '%{$search['value']}%' ";
        $search_where .= " OR enr_studnum LIKE '%{$search['value']}%' ";
        $search_where .= " OR enr_course LIKE '%{$search['value']}%' ";
        $search_where .= " OR enr_yrlevel LIKE '%{$search['value']}%') ";
    }
    if ($searchByCourse != '') {
        $search_where .= " AND (enr_course='" . $searchByCourse . "') ";
    }
    if ($searchByYrlevel != '') {
        $search_where .= " AND (enr_yrlevel='" . $searchByYrlevel . "') ";
    }

    $columns_arr = array(
        "enr_studnum",
        "name",
        "enr_course",
        "enr_yrlevel"
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

