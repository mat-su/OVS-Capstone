<?php

if (isset($_POST["org_id"])) {
    $output = '<form id="clrsched" method="post" action="clear-now.php"> <p> Are you sure you want to clear the voting schedule for this organization? </p><input type="text" class="form-control mb-2" placeholder="" name="id" value="'.$_POST["org_id"].'" hidden></form>';
    echo "$output";
}
