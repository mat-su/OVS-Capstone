<?php
session_start();
require '../functions.php';
$conn =  MYSQL_DB_Connection();
$sa_orgid = $_SESSION['sa_org_id'];
extract($_POST);

$totalCount = $conn->query("SELECT p.id AS id, p.pname AS pname, p.p_orgid as org_id FROM tbl_partylist p LEFT JOIN tbl_stud_orgs o ON p.p_orgid = o.org_id WHERE p.p_orgid = {$sa_orgid}")->rowCount();
$search_where = "";
if (!empty($search)) {
    $search_where = " AND ";
    $search_where .= " pname LIKE '%{$search['value']}%' ";
}
$columns_arr = array(
    "pname",
);
if ($length == -1) {

    $query = $conn->query("SELECT p.id AS id, p.pname AS pname FROM tbl_partylist p LEFT JOIN tbl_stud_orgs o ON p.p_orgid = o.org_id WHERE p.p_orgid = {$sa_orgid} {$search_where} ORDER BY {$columns_arr[$order[0]['column']]} {$order[0]['dir']}");
    
} else {

    $query = $conn->query("SELECT p.id AS id, p.pname AS pname FROM tbl_partylist p LEFT JOIN tbl_stud_orgs o ON p.p_orgid = o.org_id WHERE p.p_orgid = {$sa_orgid} {$search_where} ORDER BY {$columns_arr[$order[0]['column']]} {$order[0]['dir']} limit {$length} offset {$start} ");
    
}

$recordsFilterCount = $conn->query("SELECT p.id AS id, p.pname AS pname FROM tbl_partylist p LEFT JOIN tbl_stud_orgs o ON p.p_orgid = o.org_id WHERE p.p_orgid = {$sa_orgid} {$search_where} ")->rowCount();

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
