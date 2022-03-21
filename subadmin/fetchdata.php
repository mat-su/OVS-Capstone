<?php
session_start();
include '../functions.php';
$conn = MYSQL_DB_Connection();
$org_id = $_SESSION['sa_org_id'];
if (isset($_POST['post_btn']) && isset($_POST['studnum'])) {
    $studnum = $_POST['studnum'];
    $stmt = $conn->prepare("SELECT enr_fname AS fname, enr_mname AS mname, enr_lname AS lname, o.org_name FROM tbl_enr_stud e JOIN tbl_course c ON e.enr_course = c.course JOIN tbl_stud_orgs o ON c.id = o.org_course_id WHERE enr_studnum = :studnum and o.org_id = :org_id");
    $stmt->bindParam(':studnum', $studnum, PDO::PARAM_STR);
    $stmt->bindParam(':org_id', $org_id, PDO::PARAM_INT);
    $stmt->execute();
    $student = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($student) {
?>
    <script>$('#staticBackdropCreate button[form="frm_create"]').prop('disabled', false);</script>
        <div class="row">
            <div class="col-md-6">
                <label for="fname" class="form-label">First Name</label>
                <input type="text" class="form-control mb-2" placeholder="" name="fname" value="<?= $student['fname'] ?>" readonly>
            </div>
            <div class="col-md-6">
                <label for="mname" class="form-label">Middle Name</label>
                <input type="text" class="form-control mb-2" placeholder="" name="mname" value="<?= $student['mname'] ?>" readonly>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <label for="lname" class="form-label">Last Name</label>
                <input type="text" class="form-control mb-2" placeholder="" name="lname" value="<?= $student['lname'] ?>" readonly>
            </div>
        </div>

    <?php
    } else {
        ?>
        <script>$('#staticBackdropCreate button[form="frm_create"]').prop('disabled', true);</script>
        <div id="response"><small><em style="color: red;"><b>Retrieve nothing</b></em>: The student number you searched does not exist in this student organization.</small></div>
        <div class="row">
            <div class="col-md-6">
                <label for="fname" class="form-label">First Name</label>
                <input type="text" class="form-control mb-2" placeholder="" name="fname" readonly>
            </div>
            <div class="col-md-6">
                <label for="mname" class="form-label">Middle Name</label>
                <input type="text" class="form-control mb-2" placeholder="" name="mname" readonly>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <label for="lname" class="form-label">Last Name</label>
                <input type="text" class="form-control mb-2" placeholder="" name="lname" readonly>
            </div>
        </div>
<?php
    }
}
