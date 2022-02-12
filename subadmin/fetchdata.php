<?php

include '../functions.php';
$conn = MYSQL_DB_Connection();

if (isset($_POST['post_btn']) && isset($_POST['studnum'])) {
    $studnum = $_POST['studnum'];
    $stmt = $conn->prepare("SELECT enr_fname AS fname, enr_mname AS mname, enr_lname AS lname FROM tbl_enr_stud WHERE enr_studnum = :studnum");
    $stmt->bindParam(':studnum', $studnum, PDO::PARAM_STR);
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
        <div id="response"><em style="color: red;">Retrieve nothing</em></div>
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
