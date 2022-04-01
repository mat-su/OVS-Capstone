<?php
session_start();
include_once '../functions.php';
// connect to the database
$conn = MYSQL_DB_Connection();

$folderPath = 'img-uploads/';

$image_parts = explode(";base64,", $_POST['image']);
$image_type_aux = explode("image/", $image_parts[0]);
$image_type = $image_type_aux[1];
$image_base64 = base64_decode($image_parts[1]);
$filename =  $_SESSION['v_studnum'] . '_' . date('Ymd') . uniqid() . '.png';

if (file_put_contents($folderPath . $filename, $image_base64)) {
    $stmt = $conn->prepare("SELECT * FROM tbl_can_info WHERE ci_id = :can_id");
    $stmt->bindParam(':can_id', $_SESSION['c_id'], PDO::PARAM_STR);
    $stmt->execute();

    if ($stmt->rowCount() == 0) {

        $sql = "INSERT INTO tbl_can_info (ci_id, ci_img) VALUES (:can_id, :img_file)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':can_id', $_SESSION['c_id'], PDO::PARAM_STR);
        $stmt->bindParam(':img_file', $filename, PDO::PARAM_STR);
    } else {
        $existingFile = $stmt->fetch(PDO::FETCH_ASSOC);
        //delete existing file
        $data = $existingFile['ci_img'];
        $dir = "img-uploads";
        $dirHandle = opendir($dir);
        while ($file = readdir($dirHandle)) {
            if ($file == $data) {
                unlink($dir . '/' . $file);
            }
        }
        closedir($dirHandle);

        $sql = "UPDATE tbl_can_info SET ci_img = :img_file WHERE ci_id = :can_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':img_file', $filename, PDO::PARAM_STR);
        $stmt->bindParam(':can_id', $_SESSION['c_id'], PDO::PARAM_STR);
    }
    $stmt->execute();
    $resp['success'] = true;
    $resp['action'] = 'im-a-candidate.php';
} else {
    $resp['success'] = false;
    $resp['action'] = 'ERROR!!! There was a problem in uploading your image...';
}

echo json_encode($resp);
