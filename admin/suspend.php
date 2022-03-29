<?php
session_start();
include '../functions.php';
$conn = MYSQL_DB_Connection();
$stmt = $conn->query("SELECT * FROM tbl_admin");
if ($stmt->rowCount() == 1) {
    $output = '
    <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
        <strong>Can\'t Perform the Action!</strong> You should setup first your successor.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
} else {
    $stmt = $conn->prepare("DELETE FROM tbl_admin WHERE a_id = ?");
    $stmt->execute([$_SESSION['a_id']]);
    $output = '<div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
    <b>Success..!</b> You will be logout automatically. 
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div> 
    <script>
        setTimeout(function(){
            location = \'../logout.php\'
          },3000)
    </script> 
    ';
}
$output .= "<script>$('.alert').delay(4000).slideUp(200, function() {
    $(this).alert('close');
});</script>";

echo $output;
?>
