<?php
session_start();
require '../functions.php';
$conn =  MYSQL_DB_Connection();
$sa_orgid = $_SESSION['sa_org_id'];
extract($_POST);

$totalCount = $conn->query("SELECT os.id AS id, os.position AS position, os.seats AS seats FROM tbl_org_struct os LEFT JOIN tbl_stud_orgs o ON os.org_id = o.org_id 
WHERE os.org_id = {$sa_orgid}")->rowCount();
$search_where = "";
if (!empty($search)) {
    $search_where = " AND ";
    $search_where .= " position LIKE '%{$search['value']}%' ";
    $search_where .= " OR seats LIKE '%{$search['value']}%' ";
}
$columns_arr = array(
    "position",
    "seats"
);
if ($length == -1) {

    $query = $conn->query("SELECT os.id AS id, os.position AS position, os.seats AS seats FROM tbl_org_struct os LEFT JOIN tbl_stud_orgs o ON os.org_id = o.org_id 
    WHERE os.org_id = {$sa_orgid} {$search_where} ");
    
} else {

    $query = $conn->query("SELECT os.id AS id, os.position AS position, os.seats AS seats FROM tbl_org_struct os LEFT JOIN tbl_stud_orgs o ON os.org_id = o.org_id 
    WHERE os.org_id = {$sa_orgid} {$search_where} limit {$length} offset {$start} ");
    
}

$recordsFilterCount = $conn->query("SELECT os.id AS id, os.position AS position, os.seats AS seats FROM tbl_org_struct os LEFT JOIN tbl_stud_orgs o ON os.org_id = o.org_id WHERE os.org_id = {$sa_orgid} {$search_where} ")->rowCount();

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
