<?php
session_start();
require '../functions.php';
$conn =  MYSQL_DB_Connection();
$sa_orgid = $_SESSION['sa_org_id'];
extract($_POST);

$totalCount = $conn->query("SELECT c.c_id AS cid, c.c_studnum AS studnum, CONCAT(c.c_fname, ' ', c.c_lname) as cname, pa.pname AS partylist, os.position AS position FROM tbl_candidates c LEFT JOIN tbl_partylist pa ON c.c_party = pa.id LEFT JOIN tbl_org_struct os ON c.c_position = os.id WHERE c.c_orgid = {$sa_orgid}")->rowCount();
$search_where = "";
if (!empty($search)) {
    $search_where = " AND ";
    $search_where .= " c_studnum LIKE '%{$search['value']}%' ";
    $search_where .= " OR c_fname LIKE '%{$search['value']}%' ";
    $search_where .= " OR c_lname LIKE '%{$search['value']}%' ";
    $search_where .= " OR pname LIKE '%{$search['value']}%' ";
    $search_where .= " OR position LIKE '%{$search['value']}%' ";

}
$columns_arr = array(
    "studnum", "cname", "partylist", "position"
);
if ($length == -1) {

    $query = $conn->query("SELECT c.c_id AS id, c.c_studnum AS studnum, CONCAT(c.c_fname, ' ', c.c_lname) as cname, pa.pname AS partylist, os.position AS position FROM tbl_candidates c LEFT JOIN tbl_partylist pa ON c.c_party = pa.id LEFT JOIN tbl_org_struct os ON c.c_position = os.id WHERE c.c_orgid = {$sa_orgid} {$search_where} ORDER BY {$columns_arr[$order[0]['column']]} {$order[0]['dir']}");
    
} else {

    $query = $conn->query("SELECT c.c_id AS id, c.c_studnum AS studnum, CONCAT(c.c_fname, ' ', c.c_lname) as cname, pa.pname AS partylist, os.position AS position FROM tbl_candidates c LEFT JOIN tbl_partylist pa ON c.c_party = pa.id LEFT JOIN tbl_org_struct os ON c.c_position = os.id WHERE c.c_orgid = {$sa_orgid} {$search_where} ORDER BY {$columns_arr[$order[0]['column']]} {$order[0]['dir']} limit {$length} offset {$start} ");
    
}

$recordsFilterCount = $conn->query("SELECT c.c_id AS cid, c.c_studnum AS studnum, CONCAT(c.c_fname, ' ', c.c_lname) as cname, pa.pname AS partylist, os.position AS position FROM tbl_candidates c LEFT JOIN tbl_partylist pa ON c.c_party = pa.id LEFT JOIN tbl_org_struct os ON c.c_position = os.id WHERE c.c_orgid = {$sa_orgid} {$search_where} ")->rowCount();

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
