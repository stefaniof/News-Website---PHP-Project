<?php 
    
	
	use PHPMailer\PHPMailer\PHPMailer;
    require "includes/contactconfig.php"; //include config file
    require 'vendor/autoload.php';
	include 'session.php';
	require 'includes/dbcon.php';
    

    if (isset($_POST['reset']) && $_POST['email'] != "") 
    {   
        $email = $mysqli->escape_string($_POST['email']);
        $result = $mysqli->query("SELECT * FROM users WHERE email='$email'");

        if ($result->num_rows == 0)
        { 
            $_SESSION['message'] = "<div class='info-alert'>User with that email doesn't exist! Please make sure that you wrote the correct email, or that you are already a registered user. </div>";
            header("location: error.php");
        }
        else
        {
			$user = $result->fetch_assoc();
            $email = $user['email'];
            $hash = $user['hash'];
            $first_name = $user['first_name'];
			$id = $user['user_id'];
			
			// Instantiate Class  
                $mail = new PHPMailer();  
                $mail->SMTPDebug = 0;  
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
			
                $to = $email;
                $headers = 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                $message = 'Hello '.$first_name.',

							Please click this link to reset your password:

							http://localhost/proiecte/editorial/reset.php?id='.$id.'&hash='.$hash;
               
		
                //compose mail
                $mail->SetFrom($senderEmail, 'Revista online');
                $mail->Subject = "Password reset";      // Subject (which isn't required)  
                $mail->MsgHTML($message);

                // Send To  
                $mail->AddAddress($to, $last_name); // Where to send it - Recipient
                $result = $mail->Send();        // Send!  
                $_SESSION['message'] = $result ? '<div class="info-success" role="alert">Password reset link has been sent to your email!</div>' : '<div class="info-alert">Error! The message has not been sent.</div>';
                unset($mail);
                header("location: success.php");            
			
			
			
	
        }
    }
?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>Password reset</title>
		<script src="js/validation.js" type="text/javascript"></script>
		<?php include 'header.php'; ?>

							<!-- Content -->
								<section>
									<header class="main">
										<h1>Reset Your Password</h1>
										<h5 align="center">In order to reset your password, please write your email below:</h5>
									</header>
									
									<div align="center">
									<div class="6u$ 12u$(medium)">
									<div class="form">
										
										<form id="emailform" name="emailform" action="forgot.php" onsubmit="return email_validation();" method="post">
											<div class="field-wrap">
												<label>
													Email Address<span class="req">*</span>
												</label>
												<input type="text" autocomplete="off" name="email" id="email"/>
											</div>
											<span id="reset_message"></span>
											<button class="button button-block" name="reset" id="reset"/>Reset</button>
										</form>
									</div>
									</div> </div>
								</section>
								<?php include 'last_posts.php'; ?>
						</div>
					</div>

				<?php include 'footer.php'; ?>