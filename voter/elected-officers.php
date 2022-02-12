<?php
session_start();
include '../functions.php';
$conn = MYSQL_DB_Connection();
$org_id = $_SESSION['org_id'];
$output = '
<div class="text-center py-3">
    <h3>CONGRATULATIONS!</h3>
    <h4 class="fst-italic fs-6">on your successful win in this election</h4>
    <h3 class="ms-5 mt-5 text-start fs-5">Elected Officers:</h3>
</div>
';



echo $output;
