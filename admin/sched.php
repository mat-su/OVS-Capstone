<?php 
include '../functions.php';
$conn = MYSQL_DB_Connection();
$sched = Select_VotingSched($_POST["org_id"]);
$valStart = !empty($sched) ? date('Y-m-d\TH:i', strtotime($sched["vs_start_date"])) : "";
$valEnd = !empty($sched) ? date('Y-m-d\TH:i', strtotime($sched["vs_end_date"])) : "";
$output = '<form action="setVS.php" method="POST" id="sched">
    <div class="mb-3">
        <label for="">Starts on </label>
        <input type="datetime-local" name="start_dt" value="'. $valStart
        .'" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="">Ends on</label>
        <input type="datetime-local" name="end_dt" value="'. $valEnd .'" class="form-control" required>
    </div>
    <input type="text" class="form-control mb-2" placeholder="" name="id" value="'.$_POST["org_id"].'" hidden></form>
</form>';

echo $output;
