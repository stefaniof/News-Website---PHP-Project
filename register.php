<?php
    use PHPMailer\PHPMailer\PHPMailer;
    require "includes/contactconfig.php"; //include config file
    require 'vendor/autoload.php';
	
	$_SESSION['email'] = $_POST['remail'];
    $_SESSION['first_name'] = $_POST['firstname'];
    $_SESSION['last_name'] = $_POST['lastname'];

    $first_name = $mysqli->escape_string($_POST['firstname']);
    $last_name = $mysqli->escape_string($_POST['lastname']);
    $email = $mysqli->escape_string($_POST['remail']);
    $password = $mysqli->escape_string(password_hash($_POST['rpassword'], PASSWORD_BCRYPT));
    $hash = $mysqli->escape_string(md5(rand(0,1000)));
      
    $result = $mysqli->query("SELECT * FROM users WHERE email='$email'") or die($mysqli->error());

    if ($result->num_rows > 0)
    {
        $_SESSION['message'] = '<div class="info-alert">User with this email already exists!</div>';
        header("location: error.php");
    }
    else
    {
        $sql = "INSERT INTO users (first_name, last_name, email, password, hash, user_type)" 
            ."VALUES ('$first_name','$last_name','$email','$password', '$hash', 'regular')";

        if ($mysqli->query($sql))
        {
            $result = $mysqli->query("SELECT * FROM users WHERE email='$email'");
            $user = $result->fetch_assoc();

            $id = $user['user_id'];
            
            $_SESSION['active'] = 0;
            $_SESSION['logged_in'] = true;

            if ($_SESSION['email'] == 'ion246662@gmail.com')
            {
                header("location: admin.php");
            }

            else
            {
                $_SESSION['message'] =
                    "<div class='info-success'>Confirmation link has been sent to $email, please verify
                    your account by clicking on the link in the message!</div>";

 
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
                $subject = 'Account Verification';
                $message = 'Hello '.$first_name.',

							Thank you for signing up!

							Please click this link to activate your account:

							<a href="http://localhost/proiecte/editorial/verify.php?id='.$id.'&hash='.$hash.'">http://localhost/proiecte/editorial/verify.php?id='.$id.'&hash='.$hash.'</a>';
               
		
                //compose mail
                $mail->SetFrom($senderEmail, 'Revista online');
                $mail->Subject = "Please verify your account";      // Subject (which isn't required)  
                $mail->MsgHTML($message);

                // Send To  
                $mail->AddAddress($to, $last_name); // Where to send it - Recipient
                $result = $mail->Send();        // Send!  
                $message = $result ? '<div class="alert alert-success" role="alert">Message Sent Successfully!</div>' : '<div class="info-alert">Error! The message has not been sent.</div>';
                unset($mail);
                header("location: success.php");
            }
        }
        else
        {
            $_SESSION['message'] = '<div class="info-alert">Registration failed!</div>';
            header("location: error.php");
        }
    }

?>