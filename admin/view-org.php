<?php
include '../functions.php';
$conn = MYSQL_DB_Connection();
if (isset($_POST["org_id"])) {
    $id = $_POST["org_id"];

    $orgs = $conn->query("SELECT o.org_id AS org_id, o.org_name AS oName, o.org_acronym AS oAcr, CONCAT(s.sa_fname, ' ', s.sa_lname) AS 'Adviser', c.id AS cID, CONCAT(c.course, ' (', c.acronym, ')') AS CourseName FROM tbl_stud_orgs o LEFT JOIN tbl_subadmin s ON org_id = s.sa_org_id LEFT JOIN tbl_course c ON o.org_course_id = c.id WHERE org_id = $id");

    $courses = $conn->query("SELECT id, CONCAT(course, ' (', acronym, ')') AS name FROM tbl_course");

    foreach ($orgs as $o) :
        $output = '
    <div class="container-fluid">
        <form method="post" id="edit" action="update-org.php">
        <div class="row">
            <div class="col-md-12">
                <label for="org_name" class="form-label">Organization Name</label>
                <input type="text" class="form-control mb-2" placeholder="" name="org_name" value="' . $o['oName'] . '" required>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <label for="org_acronym" class="form-label">Organization Acronym</label>
                <input type="text" class="form-control mb-2" placeholder="" name="org_acronym" value="' . $o['oAcr'] . '" required>
           </div>
        </div>
        <div class="row">
            <div class=" col-md-12">
                <label for="" class="form-label">Course</label>
                <select class="form-select mb-2" aria-label="Default select example" form="edit" name="course_id">               
                ';

        if ($o['cID'] == '') {
            $output .= '<option value="" selected>--Select Course--</option>';
        } else {
            $output .= '<option value="">--Select Course--</option>';
        }

        foreach ($courses as $c) :
            if ($c['id'] == $o['cID']) {
                $output .= '<option value="' . $o['cID'] . '" selected>' . $o['CourseName'] . '</option>';
                continue;
            }

            $output .= '               
                        <option value="' . $c['id'] . '">' . $c['name'] . '</option> ';
        endforeach;
        $output .= ' 
                </select>
                <input type="text" class="form-control mb-2" placeholder="" name="id" value="' . $id . '" hidden>
            </div>
        </div>';
    endforeach;
    $output .= '
        </form>
    </div>
    ';

    echo "$output";
}
