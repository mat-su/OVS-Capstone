<?php
require_once '../functions.php';
$conn =  MYSQL_DB_Connection();
extract($_POST);

$orgs_with_sched = $conn->query("SELECT o.org_id AS id, CONCAT(o.org_name, ' (', o.org_acronym, ')') AS organization, s.vs_org_id, CONCAT(DATE_FORMAT(s.vs_start_date, '%a %b %e, %Y'), ' ', DATE_FORMAT(s.vs_start_date, '%h:%i %p')) AS startdate, CONCAT(DATE_FORMAT(s.vs_end_date, '%a %b %e, %Y'),' ', DATE_FORMAT(s.vs_end_date, '%h:%i %p')) AS enddate FROM tbl_stud_orgs o LEFT JOIN tbl_vote_sched s ON o.org_id = s.vs_org_id");

$totalCount = $orgs_with_sched->rowCount();
$search_where = "";
if (!empty($search)) {
    $search_where = " HAVING ";
    $search_where .= " organization LIKE '%{$search['value']}%' ";
    $search_where .= " OR startdate LIKE '%{$search['value']}%' ";
    $search_where .= " OR enddate LIKE '%{$search['value']}%' ";
}
$columns_arr = array(
    "organization",
    "startdate",
    "enddate",
    "id"
);

if ($length == -1) {
    $query = $conn->query("SELECT o.org_id AS id, CONCAT(o.org_name, ' (', o.org_acronym, ')') AS organization, s.vs_org_id, CONCAT(DATE_FORMAT(s.vs_start_date, '%a %b %e, %Y'), ' ', DATE_FORMAT(s.vs_start_date, '%h:%i %p')) AS startdate, CONCAT(DATE_FORMAT(s.vs_end_date, '%a %b %e, %Y'),' ', DATE_FORMAT(s.vs_end_date, '%h:%i %p')) AS enddate FROM tbl_stud_orgs o LEFT JOIN tbl_vote_sched s ON o.org_id = s.vs_org_id {$search_where}");
} else{
    $query = $conn->query("SELECT o.org_id AS id, CONCAT(o.org_name, ' (', o.org_acronym, ')') AS organization, s.vs_org_id, CONCAT(DATE_FORMAT(s.vs_start_date, '%a %b %e, %Y'), ' ', DATE_FORMAT(s.vs_start_date, '%h:%i %p')) AS startdate, CONCAT(DATE_FORMAT(s.vs_end_date, '%a %b %e, %Y'),' ', DATE_FORMAT(s.vs_end_date, '%h:%i %p')) AS enddate FROM tbl_stud_orgs o LEFT JOIN tbl_vote_sched s ON o.org_id = s.vs_org_id {$search_where} LIMIT {$length} OFFSET {$start}");
}

$recordsFilterCount = $conn->query("SELECT o.org_id AS id, CONCAT(o.org_name, ' (', o.org_acronym, ')') AS organization, s.vs_org_id, CONCAT(DATE_FORMAT(s.vs_start_date, '%a %b %e, %Y'), ' ', DATE_FORMAT(s.vs_start_date, '%h:%i %p')) AS startdate, CONCAT(DATE_FORMAT(s.vs_end_date, '%a %b %e, %Y'),' ', DATE_FORMAT(s.vs_end_date, '%h:%i %p')) AS enddate FROM tbl_stud_orgs o LEFT JOIN tbl_vote_sched s ON o.org_id = s.vs_org_id {$search_where}")->rowCount();


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