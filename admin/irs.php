<?php
include '../functions.php';
$conn = MYSQL_DB_Connection();
if (isset($_POST['import']) && !empty($_FILES)) {

    $filename = $_FILES['sqlFile']['name'];
    $extension = pathinfo($filename, PATHINFO_EXTENSION);
    $randomno = rand(0, 1000000);
    $clean_filename = trim(preg_replace(['/[^-\w]/', '/-{2,}/'], '-', pathinfo($filename, PATHINFO_FILENAME)), '-');
    $clean_filename .= date('Ymd') . $randomno;
    $newfilename = $clean_filename . '.' . $extension;
    $destination = 'enrolment-data-query/' . $newfilename;
    $file = $_FILES['sqlFile']['tmp_name'];

    if (!in_array($extension, ['sql'])) {
        header("Location: import_file.php?err=Invalid file extension. Must be valid sql file extension");
    } else {
        // move the uploaded (temporary) file to the specified destination
        if (move_uploaded_file($file, $destination)) {
            $query = file_get_contents($destination);

            try {
                $conn->exec($query);
                header("Location: import_file.php?success=Enrollment table successfully uploaded and imported!");
            } catch (PDOException $e) {
                $data = $newfilename;
                $dir = "enrolment-data-query";
                $dirHandle = opendir($dir);
                while ($file = readdir($dirHandle)) {
                    if ($file == $data) {
                        unlink($dir . '/' . $file);
                    }
                }
                closedir($dirHandle);
                echo $e->getMessage(); //Remove or change message in production code
            }
        } else {
            header("Location: import_file.php?err=Failed to upload file!!!");
        }
    }
}
