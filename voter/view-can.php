<?php

include '../functions.php';
$conn = MYSQL_DB_Connection();
$can = SelectAll_CandidateWithInfo($_POST['can_id']);

$candidate_img = (!empty($can['Profile Image'])) ? './img-uploads/'.$can['Profile Image'] : '../assets/img/default_candi.png';
$candidate_platform = (!empty($can['Platform'])) ? $can['Platform'] : '<p style="text-align:center;">Nothing to show.</p>';
$output = '
<div class="container">

    <!--Candidate 1-->

    <div class="row bg-whitem m-2 p-3 shadow-lg justify-content-around align-items-center rounded border border-primary border-3">
        <div class="col-md-6 text-center">
            <img class="rounded-circle img-fluid my-3 border" src="'.$candidate_img.'" alt="" style="width: auto; height:10rem;">
        </div>
        <div class="col-md-6">
            <h3 class="fs-2">'.$can['Name'].'</h3>
            <h5 class="fs-3">for '.$can['Position'].'</h5>
            <p class="fs-5">Get to know me!</p>
        </div>

        <div class="divider div-transparent"></div>

        <div class="col-md-12 mb-3">
            <div class="text-center">
                <i class="fas fa-bullhorn fs-1 primary-text secondary-bg p-4"></i>
            </div>
            
            <div style="word-wrap: break-word;" class="container">
            <h3 class="fs-3 text-center">Platform</h3>
            <p class="fs-6">'.html_entity_decode($candidate_platform).'</p>
            </div>
            
        </div>
        <div class="divider div-transparent"></div>

        <div class="col-md-6 text-center">


            <i class="fas fa-id-card-alt fs-1 primary-text  secondary-bg p-4"></i>
            <h3 class="fs-3 ">Info</h3>

            <p class="fs-6">'.$can['Name'].' </p>
            <p class="fs-6">'.$can['Course'].'</p>
            <p class="fs-6">'.$can['Year Level'].'</p>
            <p class="fs-6">'.$can['Partylist'].' </p>

        </div>




    </div>


    <!--End Candidate 1-->



';
echo $output;
