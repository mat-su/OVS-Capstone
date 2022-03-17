<?php
include '../functions.php';
$conn = MYSQL_DB_Connection();

if (isset($_POST['course_id']))
$id = $_POST['course_id'];
$course = $conn->query("SELECT c.course AS CourseName FROM tbl_course c WHERE c.id = $id")->fetch(PDO::FETCH_ASSOC);


    $stmt = "SELECT COUNT(enr_course) AS NumberOfEnrolledStud FROM tbl_enr_stud WHERE enr_course = '$course[CourseName]'";
    $conn = MYSQL_DB_Connection();
    $enr = $conn->query($stmt)->fetch(PDO::FETCH_ASSOC);
    
    $stmt = "SELECT COUNT(enr_course) AS NumberOfEnrolledStud FROM tbl_enr_stud WHERE enr_course = '$course[CourseName]' AND enr_yrlevel = 'first year'";
    $conn = MYSQL_DB_Connection();
    $enr1 = $conn->query($stmt)->fetch(PDO::FETCH_ASSOC);

    $stmt = "SELECT COUNT(enr_course) AS NumberOfEnrolledStud FROM tbl_enr_stud WHERE enr_course = '$course[CourseName]' AND enr_yrlevel = 'second year'";
    $conn = MYSQL_DB_Connection();
    $enr2 = $conn->query($stmt)->fetch(PDO::FETCH_ASSOC);

    $stmt = "SELECT COUNT(enr_course) AS NumberOfEnrolledStud FROM tbl_enr_stud WHERE enr_course = '$course[CourseName]' AND enr_yrlevel = 'third year'";
    $conn = MYSQL_DB_Connection();
    $enr3 = $conn->query($stmt)->fetch(PDO::FETCH_ASSOC);

    $stmt = "SELECT COUNT(enr_course) AS NumberOfEnrolledStud FROM tbl_enr_stud WHERE enr_course = '$course[CourseName]' AND enr_yrlevel = 'fourth year'";
    $conn = MYSQL_DB_Connection();
    $enr4 = $conn->query($stmt)->fetch(PDO::FETCH_ASSOC);


    $stmt = "SELECT COUNT(v_course) AS NumberOfRegisteredStud FROM tbl_voter WHERE v_course = '$course[CourseName]'";
    $conn = MYSQL_DB_Connection();
    $reg = $conn->query($stmt)->fetch(PDO::FETCH_ASSOC);

    $stmt = "SELECT COUNT(V.v_studnum) AS NumberOfRegisteredStud FROM tbl_voter V LEFT JOIN tbl_enr_stud E ON V.v_studnum = E.enr_studnum WHERE E.enr_yrlevel = 'FIRST YEAR' AND E.enr_course = '$course[CourseName]'";
    $conn = MYSQL_DB_Connection();
    $reg1 = $conn->query($stmt)->fetch(PDO::FETCH_ASSOC);

    
    $stmt = "SELECT COUNT(V.v_studnum) AS NumberOfRegisteredStud FROM tbl_voter V LEFT JOIN tbl_enr_stud E ON V.v_studnum = E.enr_studnum WHERE E.enr_yrlevel = 'SECOND YEAR' AND E.enr_course = '$course[CourseName]'";
    $conn = MYSQL_DB_Connection();
    $reg2 = $conn->query($stmt)->fetch(PDO::FETCH_ASSOC);

    
    $stmt = "SELECT COUNT(V.v_studnum) AS NumberOfRegisteredStud FROM tbl_voter V LEFT JOIN tbl_enr_stud E ON V.v_studnum = E.enr_studnum WHERE E.enr_yrlevel = 'THIRD YEAR' AND E.enr_course = '$course[CourseName]'";
    $conn = MYSQL_DB_Connection();
    $reg3 = $conn->query($stmt)->fetch(PDO::FETCH_ASSOC);

    
    $stmt = "SELECT COUNT(V.v_studnum) AS NumberOfRegisteredStud FROM tbl_voter V LEFT JOIN tbl_enr_stud E ON V.v_studnum = E.enr_studnum WHERE E.enr_yrlevel = 'FOURTH YEAR' AND E.enr_course = '$course[CourseName]'";
    $conn = MYSQL_DB_Connection();
    $reg4 = $conn->query($stmt)->fetch(PDO::FETCH_ASSOC);

    

    $output = '<strong>' .$course['CourseName'] . '</strong>';
    $output .= '<br><br>Total Number of Enrolled Students: ' .$enr['NumberOfEnrolledStud'];
    $output .= '<br>First Year: ' .$enr1['NumberOfEnrolledStud'];
    $output .= '<br>Second Year: ' .$enr2['NumberOfEnrolledStud'];
    $output .= '<br>Third Year: ' .$enr3['NumberOfEnrolledStud'];
    $output .= '<br>Fourth Year: ' .$enr4['NumberOfEnrolledStud'];
    $output .= '<br><br>Total Number of Registered Students: ' .$reg['NumberOfRegisteredStud'];
    $output .= '<br>First Year: ' .$reg1['NumberOfRegisteredStud'];
    $output .= '<br>Second Year: ' .$reg2['NumberOfRegisteredStud'];
    $output .= '<br>Third Year: ' .$reg3['NumberOfRegisteredStud'];
    $output .= '<br>Fourth Year: ' .$reg4['NumberOfRegisteredStud'];
    echo "$output";
    

