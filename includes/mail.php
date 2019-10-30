<?php
use PHPMailer\PHPMailer\PHPMailer;
require "includes/contactconfig.php"; //include config file

// Google captcha
  ini_set('display_errors',1);  error_reporting(E_ALL);
  if(isset($_POST['sendmessage'])){
      $userIP = $_SERVER["REMOTE_ADDR"];
      $recaptchaResponse = $_POST['g-recaptcha-response'];
      $secretKey = $mysecretkey;
      $request = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$secretKey}&response={$recaptchaResponse}&remoteip={$userIP}");

      if(!strstr($request, "true")){
          $errormsg = '<div class="alert alert-danger" role="alert"><strong>Error!</strong>You are either a robot, or you forgot about the captcha!</div>';
      }
      else if(isset($_POST['sendmessage'])) 
        {

        $message=
        'Full Name: '.$_POST['cfname'].' '.$_POST['clname'].'<br />
        Subject:    '.$_POST['csubject'].'<br />
        Email:  '.$_POST['cemail'].'<br />
        Message:   '.$_POST['cmessage'].'
        ';
            
            
            require 'vendor/autoload.php';
            
              
            // Instantiate Class  
            $mail = new PHPMailer();  
              
            // Set up SMTP  
            $mail->IsSMTP(); // Sets up a SMTP connection  
            
            $mail->SMTPAuth = true;         // Connection with the SMTP does require authorization    
            $mail->SMTPSecure = "tls";      // Connect using a TLS connection  
            $mail->Host = "smtp.gmail.com";  //Gmail SMTP server address
            $mail->Port = 587;  //Gmail SMTP port
            $mail->Encoding = '7bit';
            
            // Authentication  
            $mail->Username   = $senderEmail; // Your full Gmail address
            $mail->Password   = $senderPassword; // Your Gmail password
              
            // Compose
            $mail->SetFrom($_POST['cemail'], $_POST['cfname'].' '.$_POST['clname']);
            $mail->AddReplyTo($_POST['cemail'], $_POST['clname']);
            $mail->Subject = $_POST['csubject'];      // Subject (which isn't required)  
            $mail->MsgHTML($message);
         
            // Send To  
            $mail->AddAddress($receiverEmail, $receiverName); // Where to send it - Recipient
            $result = $mail->Send();        // Send!  
            $message = $result ? 1 : 0;
            unset($mail);
		  if ($result == 0)
		  {
			$_SESSION['message'] = "<div class='info-alert'>Error! The message has not been sent.</div>";
			header("location: error.php"); 
		  }
		  else{
			$_SESSION['message'] = "<div class='info-success'>Message Sent Successfully!</div>";
			header("location: success.php"); 
		  }
        }

  }

?>
