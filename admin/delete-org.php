<?php

if (isset($_POST["org_id"])) {
    $output = '<form id="trash" method="post" action="trash-org.php"> <p> Are you sure you want to delete this sub admin? </p><input type="text" class="form-control mb-2" placeholder="" name="id" value="'.$_POST["org_id"].'" hidden></form>';
    echo "$output";
}
