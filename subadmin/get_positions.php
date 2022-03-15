<?php
session_start();
require '../functions.php';
$conn =  MYSQL_DB_Connection();
$sa_orgid = $_SESSION['sa_org_id'];
extract($_POST);

$sql = "SELECT os.id AS id, os.position AS position, os.seats AS seats FROM tbl_org_struct os LEFT JOIN tbl_stud_orgs o ON os.org_id = o.org_id WHERE os.org_id = {$sa_orgid}";

$totalCount = $conn->query($sql)->rowCount();
$search_where = "";
if (!empty($search)) {
    $search_where .= " AND (position LIKE '%{$search['value']}%' OR seats LIKE '%{$search['value']}%')";
}

if ($length == -1) {
    $query = $conn->query($sql . $search_where);   
} else {
    $query = $conn->query($sql . $search_where . ' LIMIT ' . $length . ' OFFSET ' . $start);    
}

$recordsFilterCount = $conn->query($sql . $search_where)->rowCount();

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