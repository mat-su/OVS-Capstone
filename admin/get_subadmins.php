<?php
require_once '../functions.php';
$conn =  MYSQL_DB_Connection();
extract($_POST);
$totalCount = $conn->query("SELECT s.sa_id AS id, CONCAT(s.sa_fname, ' ', s.sa_lname) AS 'Name', s.sa_email AS Email, CONCAT(o.org_name, ' (', o.org_acronym, ')') AS Org_Name FROM tbl_subadmin s LEFT JOIN tbl_stud_orgs o ON s.sa_org_id = o.org_id")->rowCount();
$search_where = "";
if (!empty($search)) {
    $search_where = " where ";
    $search_where .= " sa_fname LIKE '%{$search['value']}%' ";
    $search_where .= " OR sa_lname LIKE '%{$search['value']}%' ";
    $search_where .= " OR sa_email LIKE '%{$search['value']}%' ";
    $search_where .= " OR org_name LIKE '%{$search['value']}%' ";
    $search_where .= " OR org_acronym LIKE '%{$search['value']}%' ";
}
$columns_arr = array(
    "Name",
    "Email",
    "Org_Name",
    "id"
);

if ($length == -1) {
    $query = $conn->query("SELECT s.sa_id AS id, CONCAT(s.sa_fname, ' ', s.sa_lname) AS 'Name', s.sa_email AS Email, CONCAT(o.org_name, ' (', o.org_acronym, ')') AS Org_Name FROM tbl_subadmin s LEFT JOIN tbl_stud_orgs o ON s.sa_org_id = o.org_id {$search_where} ORDER BY {$columns_arr[$order[0]['column']]} {$order[0]['dir']} ");
} else{
    $query = $conn->query("SELECT s.sa_id AS id, CONCAT(s.sa_fname, ' ', s.sa_lname) AS 'Name', s.sa_email AS Email, CONCAT(o.org_name, ' (', o.org_acronym, ')') AS Org_Name FROM tbl_subadmin s LEFT JOIN tbl_stud_orgs o ON s.sa_org_id = o.org_id {$search_where} ORDER BY {$columns_arr[$order[0]['column']]} {$order[0]['dir']} limit {$length} offset {$start} ");
}

$recordsFilterCount = $conn->query("SELECT s.sa_id AS id, CONCAT(s.sa_fname, ' ', s.sa_lname) AS 'Name', s.sa_email AS Email, CONCAT(o.org_name, ' (', o.org_acronym, ')') AS Org_Name FROM tbl_subadmin s LEFT JOIN tbl_stud_orgs o ON s.sa_org_id = o.org_id {$search_where} ")->rowCount();

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
