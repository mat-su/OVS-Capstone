<?php
session_start();
include_once '../functions.php';
// connect to the database
$conn = MYSQL_DB_Connection();

// Uploads files
if (isset($_POST['upload']) && !empty($_FILES)) { // if save button on the form is clicked and file is not empty
    // name of the uploaded file
    $filename = $_FILES['profile-img']['name'];

    // get the file extension
    $extension = pathinfo($filename, PATHINFO_EXTENSION);
    $randomno = rand(0, 1000000);
    // clean the filename
    $clean_filename = trim(preg_replace(['/[^-\w]/', '/-{2,}/'], '-', pathinfo($filename, PATHINFO_FILENAME)), '-');

    $clean_filename .= date('Ymd') . $randomno;

    $newfilename = $clean_filename . '.' . $extension;

    // destination of the file on the server
    $destination = 'img-uploads/' . $newfilename;

    // the physical file on a temporary uploads directory on the server
    $file = $_FILES['profile-img']['tmp_name'];

    if (!in_array($extension, ['jpeg', 'jpg', 'png', 'gif'])) {
        header("Location: im-a-candidate.php?err=Invalid file extension. Must be valid image file extension");
    } elseif ($_FILES['profile-img']['size'] > 1572864) {
        // file shouldn't be larger than 1.5Megabyte
        /* define('KB', 1024);
        define('MB', 1048576);
        define('GB', 1073741824);
        define('TB', 1099511627776); */
        //echo filesize($file);
        header("Location: im-a-candidate.php?err=File too large!!!");
    } else {
        // move the uploaded (temporary) file to the specified destination
        if (move_uploaded_file($file, $destination)) {
            $stmt = $conn->prepare("SELECT * FROM tbl_can_info WHERE ci_id = :can_id");
            $stmt->bindParam(':can_id', $_SESSION['c_id'], PDO::PARAM_STR);
            $stmt->execute();

            if ($stmt->rowCount() == 0) {

                $sql = "INSERT INTO tbl_can_info (ci_id, ci_img) VALUES (:can_id, :img_file)";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':can_id', $_SESSION['c_id'], PDO::PARAM_STR);
                $stmt->bindParam(':img_file', $newfilename, PDO::PARAM_STR);

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
                $stmt->bindParam(':img_file', $newfilename, PDO::PARAM_STR);
                $stmt->bindParam(':can_id', $_SESSION['c_id'], PDO::PARAM_STR); 
            }
            $stmt->execute();    
            header("Location: im-a-candidate.php?info=File uploaded successfully!");
        } else {
            header("Location: im-a-candidate.php?err=Failed to upload file!!!");
        }
    }
} else {
    header("Location: im-a-candidate.php?err=Failed to upload file!!!");
}
