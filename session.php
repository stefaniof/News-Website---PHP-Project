<?php 
    require 'includes/dbcon.php';
    session_start();

    /*if (isset($_SESSION['logged_in']) == 1)
    {
        header("location: profile.php");
    }  */

    if (isset($_COOKIE['email']))
    {
        $_SESSION['email'] = $_COOKIE['email'];
        $_SESSION['logged_in'] = 1;        
    }

	
	
	
    if (isset($_POST['login']) || isset($_POST['register']))
		
		{
			require "includes/contactconfig.php";
			$userIP = $_SERVER["REMOTE_ADDR"];
			$recaptchaResponse = $_POST['g-recaptcha-response'];
			$secretKey = $mysecretkey;
			$request = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$secretKey}&response={$recaptchaResponse}&remoteip={$userIP}");
			
			if(!strstr($request, "true")){
			  $_SESSION['message'] = '<div class="info-alert">Error! There was a problem with the Captcha. You are either a robot, or you did not click it!</div>';
			  header("location: error.php");
			}
			elseif (isset($_POST['login']) && $_POST['email'] != "" && $_POST['password'] != "") {
				require 'login.php';
			}
			elseif (isset($_POST['register']) && $_POST['firstname'] != "" && $_POST['lastname'] != "" && $_POST['remail'] != "" && $_POST['rpassword'] != "")
			{
				require 'register.php';
			}
			
		}

	
	
	
	
    
        
?>