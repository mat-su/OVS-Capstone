<?php
require_once '../functions.php';
$conn =  MYSQL_DB_Connection();
extract($_POST);

$sql = ("SELECT o.org_id AS org_id, CONCAT(o.org_name, ' (', o.org_acronym, ')') AS Org_Name, CONCAT(s.sa_fname, ' ', s.sa_lname) AS 'Adviser', c.id, CONCAT(c.course, ' (', c.acronym, ')') AS Course FROM tbl_stud_orgs o LEFT JOIN tbl_subadmin s ON org_id = s.sa_org_id LEFT JOIN tbl_course c ON o.org_course_id = c.id");

$totalCount = $conn->query($sql)->rowCount();
$search_where = "";
if (!empty($search)) {
    $search_where = " HAVING";
    $search_where .= " Org_Name LIKE '%{$search['value']}%' ";
    $search_where .= " OR Adviser LIKE '%{$search['value']}%' ";
    $search_where .= " OR Course LIKE '%{$search['value']}%' ";
}
$columns_arr = array(
    "Org_Name",
    "Course",
    "Adviser"
);

if ($length == -1) {
    $query = $conn->query($sql . " {$search_where} ORDER BY {$columns_arr[$order[0]['column']]} {$order[0]['dir']} ");
} else{
    $query = $conn->query($sql . "{$search_where} ORDER BY {$columns_arr[$order[0]['column']]} {$order[0]['dir']} limit {$length} offset {$start} ");
}

$recordsFilterCount = $conn->query($sql . " {$search_where} ")->rowCount();

$recordsTotal = $totalCount;
$recordsFiltered = $recordsFilterCount;
$data = array();
$i = 1 + $start;
while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
    $data[] = $row;
}
echo json_encode(
    array(
        'draw' => $draw,
        'recordsTotal' => $recordsTotal,
        'recordsFiltered' => $recordsFiltered,
        'data' => $data,
    )
);
