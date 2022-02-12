<?php
session_start();
include '../functions.php';
$org_id = $_SESSION['org_id'];
$v = Count_Voters($org_id);
$votePercentage = ($v['whoVoted'] / $v['totalVoters']) * 100;
$precise = number_format((float) $votePercentage, 2, '.', ''); 
$output = '
<div>
    <h4 class="fs-2 text-center">Voter Turnout</h4>
    <span class="text-start">Voted</span>
    <div class="progress" style="height: 30px">
        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="" aria-valuemin="0" aria-valuemax="100" style="width:' .$votePercentage. '%;"><span class="fs-4">' .$precise. '%</span></div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="p-3 d-flex justify-content-around align-items-center rounded text-center">
            <div class="card p-3" style="width: 15rem;">
                <h3 class="fs-2">' .$v["whoVoted"]. '</h3>
                <p class="fs-5">Already Voted</p>
            </div>
            <div class="card p-3" style="width: 15rem;">
                <h3 class="fs-2">' .$v["totalVoters"]. '</h3>
                <p class="fs-5">Total Voters</p>
            </div>
        </div>
    </div>
</div>
<script>
$(".progress-bar").attr("style", "width: ' .$votePercentage. '%");
$(".progress-bar .fs-4").text("'. $precise .'%");
</script>
';

echo $output;