<?php
if(isset($_POST['fullname'])) {
  $fullname = $_POST['fullname'];

  $hashedpass = password_hash($fullname, PASSWORD_DEFAULT);
  $output = '
  <div class="alert alert-warning alert-dismissible fade show" role="alert">
    <strong>Holy guacamole!</strong> <b>hello '.$hashedpass.'</b>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>';
  echo $output;
}

?>

