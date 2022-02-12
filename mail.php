<?php


/*##########Script Information#########
  # Purpose: Send mail Using PHPMailer#
  #          & Gmail SMTP Server 	  #
  #####################################*/

//Define name spaces
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
//Include required PHPMailer files
require 'phpmailer/includes/PHPMailer.php';
require 'phpmailer/includes/SMTP.php';
require 'phpmailer/includes/Exception.php';
//Create instance of PHPMailer
$mail = new PHPMailer();
//[FIX for this issue] PHP has implemented stricter SSL behaviour which makes SMTP Error: Could Not Connect To SMTP Host 
$mail->SMTPOptions = array(
    'ssl' => array(
    'verify_peer' => false,
    'verify_peer_name' => false,
    'allow_self_signed' => true
    )
    );

//Set mailer to use smtp
$mail->isSMTP();
//Define smtp host
$mail->Host = "smtp.gmail.com";
//Enable smtp authentication
$mail->SMTPAuth = true;
//Set smtp encryption type (ssl/tls)
$mail->SMTPSecure = "tls";
//Port to connect smtp
$mail->Port = "587";
//Set gmail username
$mail->Username = "educpurponly101@gmail.com";
//Set gmail password
$mail->Password = "SuperSimplePassword";

