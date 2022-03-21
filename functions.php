<?php
function MYSQL_DB_Connection()
{
  $HOSTNAME = "localhost";
  $USERNAME = "root";
  $PASSWORD = "";
  $DB_NAME = "db_ovs";

  $dsn = "mysql:host=$HOSTNAME; dbname=$DB_NAME; charset=utf8mb4";
  $options = [
    PDO::ATTR_EMULATE_PREPARES   => false, // turn off emulation mode for "real" prepared statements
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, //turn on errors in the form of exceptions
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, //make the default fetch be an associative array
  ];
  try {
    return new PDO($dsn, $USERNAME, $PASSWORD, $options);
  } catch (Exception $e) {
    error_log($e->getMessage());
    exit("Failed to connect to database! <br>Error: $e");
  }
}

//for temporary password
function password_generate($chars)
{
  $data = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcefghijklmnopqrstuvwxyz';
  return substr(str_shuffle($data), 0, $chars);
}
function template_header($title)
{
  echo <<<EOT
  <!DOCTYPE html>
  <html lang="en">
  
  <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>$title</title>

      <!--Tab Logo-->
      <link rel="shortcut icon" type="image/jpg" href="https://ik.imagekit.io/nwlfpk0xpdg/img/tr:w-50,h-50/logo-png_Xt7bTS_7o.png?ik-sdk-version=javascript-1.4.3&updatedAt=1636213481504"/>
      <!--Boostrap5 CSS CDN-->
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
      <!--Font Awesome CSS CDN-->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
      <!--minified DataTables CSS CDN-->
      <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css" />
      <!--Assets-->
      <link rel="stylesheet" href="../assets/bootstrap/css/style.css">
      <!--JQuery Link-->
      <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
      <!--Boostrap5 JS CDN-->
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
      <!--minified DataTables JS CDN-->
      <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
      <!--minified DataTables bootstrap CDN-->
      <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.min.js"></script>
      <!--JQuery Validation PlugIn-->
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.js"></script>
  
      <style>
          #fname-error,
          #mname-error,
          #lname-error,
          #email-error,
          #org-error, 
          #curPass-error,
          #newPass-error,
          #rnewPass-error,
          #newEmail-error,
          #newUname-error,
          #position-error,
          #partylist-error,
          #party-error,
          #studnum-error, 
          #startdate-error,
          #enddate-error {
              color: red;
              font-style: italic;
              font-size: 15px;
          }
      </style>
  </head>
  EOT;
}


function template_footer()
{
  echo <<<EOT
    <!--Footer-->
    <footer class="text-white text-center bg-dark">
    <!-- Grid container -->
    <div class="container p-4 ">
      <!--Grid row-->
      <div class="row mt-4">
        <!--Grid column-->
        <div class="col-lg-8 col-md-12 mb-4 mb-md-0">
          <h5 class="text-uppercase mb-4">About PLMAR</h5>

          <p>The Pamantasan ng Lungsod ng Marikina (simply known as PLMar) is the first city government-funded university in Marikina City, Philippines. It was established to provide quality but affordable tertiary education to the residents of Marikina through Ordinance No. 015 Series of 2003.</p>
          <p>The university provides a wide range of undergraduate and graduate programs. Aside from tertiary level courses, the school also has a Senior High School (SHS) program featuring strands under the Academic track.</p>
          <p>As an academic institution, PLMar has been consistently equipping its students with affordable and high-quality education and molding them into well-rounded and service-oriented graduates who will contribute to the development of their respective communities.</p>

          <div class="mt-4">
            <!-- Facebook -->
            <a type="button" class="btn btn-floating btn-light btn-lg" target="_blank" href="https://www.facebook.com/cpaips/"><i class="fab fa-facebook"></i></a>
            <!-- Twitter -->
            <a type="button" class="btn btn-floating btn-light btn-lg" target="_blank" href="https://twitter.com/cpaipsplmar"><i class="fab fa-twitter"></i></a>
            <!-- Youtube -->
            <a type="button" class="btn btn-floating btn-light btn-lg " target="_blank" href="https://www.youtube.com/channel/UCz7GtBK1hzFv7eEyZD2Y7hw"><i class="fab fa-youtube"></i></a>

          </div>
        </div>
        <!--Grid column-->  
        <!--Grid column-->
        <div class="col-lg-4 col-md-6 mb-4 ">            

          <ul class="fa-ul" style="margin-left: 2em;">
            <li class="mb-3">
              <span class="fa-li" ><i class="fas fa-home"></i></span><span>No. 2 Brazil Street, Greenheights Subdivision Concepcion Uno, Marikina City 1807, Metro Manila</span>
            </li>
            <li class="mb-3">
              <span class="fa-li " ><i class="fas fa-envelope"></i></span><span>educpurponly101@gmail.com</span>
            </li>
            <li class="mb-3">
              <span class="fa-li"><i class="fas fa-phone"></i></span><span>(02) 392-0455</span>
            </li>
          </ul>
        </div>
        <!--Grid column-->  
        
      </div>
      <!--Grid row-->
    </div>
    <!-- Grid container -->

    <!-- Copyright -->
    <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
      © 2022 Copyright: OVS | 4BSIT7C
     
    </div>
    <!-- Copyright -->
  </footer>

</div>
<!-- End of .container -->
EOT;
}

function SelectAll_Partylists($org_id)
{
  $conn = MYSQL_DB_Connection();
  $stmt = $conn->prepare("SELECT p.id AS id, p.pname AS pname FROM tbl_partylist p LEFT JOIN tbl_stud_orgs o ON p.p_orgid = o.org_id WHERE p.p_orgid = :id");
  $stmt->bindParam(':id', $org_id, PDO::PARAM_INT);
  $stmt->execute();
  $partylist = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return $partylist;
}

function SelectAll_Candidates($org_id, $partyName)
{
  $conn = MYSQL_DB_Connection();
  $stmt = $conn->prepare(
    "SELECT c.c_id AS cid, c.c_studnum AS studnum, CONCAT(c.c_fname, ' ', c.c_lname) as cname, pa.pname AS party, os.position AS position, os.id AS positionID, i.ci_img AS 'Profile Image' 
    FROM tbl_candidates c 
    LEFT JOIN tbl_partylist pa ON c.c_party = pa.id 
    LEFT JOIN tbl_org_struct os ON c.c_position = os.id 
    LEFT JOIN tbl_can_info i ON c.c_id = i.ci_id 
    WHERE c.c_orgid = :id AND pa.pname = :party ORDER BY `positionID` ASC"
  );
  $stmt->bindParam(':id', $org_id, PDO::PARAM_INT);
  $stmt->bindParam(':party', $partyName, PDO::PARAM_INT);
  $stmt->execute();
  $candidates = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return $candidates;
}

function Select_VotingSched($org_id)
{
  $conn = MYSQL_DB_Connection();
  $stmt = $conn->prepare("SELECT s.vs_start_date AS startdate, s.vs_end_date enddate, o.org_id AS id, DATE_FORMAT(vs_start_date, '%a') as strt_dw, DATE_FORMAT(vs_start_date, '%e') as strt_dm, DATE_FORMAT(vs_start_date, '%b') as strt_sd1, DATE_FORMAT(vs_start_date, '%Y') as strt_sd2, DATE_FORMAT(vs_start_date, '%r') as strt_r, DATE_FORMAT(vs_end_date, '%a') as end_dw, DATE_FORMAT(vs_end_date, '%e') as end_dm, DATE_FORMAT(vs_end_date, '%b') as end_sd1, DATE_FORMAT(vs_end_date, '%Y') as end_sd2, DATE_FORMAT(vs_end_date, '%r') as end_r FROM tbl_stud_orgs o LEFT JOIN tbl_vote_sched s ON o.org_id = s.vs_org_id WHERE o.org_id = :id");
  $stmt->bindParam(':id', $org_id, PDO::PARAM_INT);
  $stmt->execute();
  return $sched = $stmt->fetch(PDO::FETCH_ASSOC);
}


function SelectAll_CandidateWithInfo($can_id)
{
  $conn = MYSQL_DB_Connection();
  $stmt = $conn->prepare("SELECT 
  CONCAT(c.c_fname, ' ', c.c_lname) AS Name, e.enr_course as Course, e.enr_yrlevel as 'Year Level', p.pname AS Partylist, i.ci_img as 'Profile Image', i.ci_platform AS Platform, o.position AS Position
  FROM tbl_candidates c 
  LEFT JOIN tbl_can_info i ON c.c_id = i.ci_id 
  LEFT JOIN tbl_enr_stud e ON c.c_studnum = e.enr_studnum 
  LEFT JOIN tbl_partylist p ON c.c_party = p.id
  LEFT JOIN tbl_org_struct o ON c.c_position = o.id WHERE c.c_id = :id");
  $stmt->bindParam(':id', $can_id, PDO::PARAM_STR);
  $stmt->execute();
  return $can = $stmt->fetch(PDO::FETCH_ASSOC);
}

function fetchAll_CandidatesforBallot($org_id, $pos_id)
{
  $conn = MYSQL_DB_Connection();
  $stmt = $conn->prepare(
    "SELECT c.c_id AS cid, CONCAT(c.c_fname, ' ', c.c_lname) as cname, os.position AS position, os.id AS positionID, os.seats AS seats, c_info.ci_img AS img FROM tbl_candidates c 
    LEFT JOIN tbl_org_struct os ON c.c_position = os.id 
    LEFT JOIN tbl_can_info c_info ON c.c_id = c_info.ci_id 
    WHERE c.c_orgid = :org_id AND os.id = :pos_id ORDER BY cid ASC;"
  );
  $stmt->bindParam(':org_id', $org_id, PDO::PARAM_INT);
  $stmt->bindParam(':pos_id', $pos_id, PDO::PARAM_INT);
  $stmt->execute();

  $candidates = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return $candidates;
}

function fetchAll_OrgStructure($org_id)
{
  $conn = MYSQL_DB_Connection();
  $stmt = $conn->prepare(
    "SELECT os.id AS id, os.position AS position, os.seats AS seats 
    FROM tbl_org_struct os 
    LEFT JOIN tbl_stud_orgs o ON os.org_id = o.org_id 
    WHERE os.org_id = :id"
  );
  $stmt->bindParam(':id', $org_id, PDO::PARAM_INT);
  $stmt->execute();
  $org_related = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return $org_related;
}

function Count_Voters($org_id)
{
  $conn = MYSQL_DB_Connection();
  $stmt = $conn->prepare(
    "SELECT COUNT(*) totalVoters, COUNT(s.v_status) whoVoted FROM tbl_course c 
    LEFT JOIN tbl_stud_orgs o
    ON c.id = o.org_course_id
    LEFT JOIN tbl_voter v
    ON c.course = v.v_course
    LEFT JOIN tbl_voter_status s
    ON v.v_id = s.v_id
    WHERE o.org_id = :id;"
  );
  $stmt->bindParam(':id', $org_id, PDO::PARAM_INT);
  $stmt->execute();
  $voters = $stmt->fetch(PDO::FETCH_ASSOC);
  return $voters;
}

function ChartTally($org_id, $pos_id)
{
  $conn = MYSQL_DB_Connection();
  $stmt = $conn->prepare(
    "SELECT c.c_orgid, c.c_id, CONCAT(c.c_fname, ' ', c.c_mname, ' ', c.c_lname) AS fullname, CONCAT(o.org_name, ' (', o.org_acronym, ')')AS org, pa.pname, p.position, p.id AS pos_id, COUNT(t.can_id) AS tallies 
    FROM tbl_candidates c 
    LEFT JOIN tbl_tally t ON c.c_id = t.can_id
    LEFT JOIN tbl_stud_orgs o ON o.org_id = c.c_orgid
    LEFT JOIN tbl_org_struct p ON p.id = c.c_position
    LEFT JOIN tbl_partylist pa ON pa.id = c.c_party
    GROUP BY c.c_id
    HAVING c.c_orgid = $org_id AND p.id = $pos_id
    ORDER BY c.c_position ASC;"
  );
  $stmt->bindParam(':id', $org_id, PDO::PARAM_INT);
  $stmt->bindParam(':posID', $pos_id, PDO::PARAM_INT);
  $stmt->execute();
  $candidates = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return $candidates;
}
