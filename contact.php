<?php 
    include 'session.php';
	include 'includes/mail.php';


// define variables and set to empty values
$cfnameErr = $clnameErr = $cemailErr = $csubjectErr = $cmessageErr = "";
$name = $email = $gender = $comment = $website = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["cfname"])) {
    $cfnameErr = "First Name is required";
  } 
  else if (!preg_match("/^[a-zA-Z ]*$/",$_POST["cfname"])) {
	$cfnameErr = "Only letters and white space allowed"; 
  }
  else {
    $cfname = test_input($_POST["cfname"]);
  }
  if (empty($_POST["clname"])) {
    $clnameErr = "Last Name is required";
  } 
  else if (!preg_match("/^[a-zA-Z ]*$/",$_POST["clname"])) {
	$clnameErr = "Only letters and white space allowed"; 
  } 
  else {
    $clname = test_input($_POST["clname"]);
  }  
  if (empty($_POST["cemail"])) {
    $cemailErr = "Email is required";
  } 
  else if (!filter_var($_POST["cemail"], FILTER_VALIDATE_EMAIL)) {
	$cemailErr = "Invalid email format"; 
  }
  else {
    $cemail = test_input($_POST["cemail"]);
  }
    
  if (empty($_POST["csubject"])) {
    $csubjectErr = "Subject is required";
  } else {
    $csubject = test_input($_POST["csubject"]);
  }

  if (empty($_POST["cmessage"])) {
    $cmessageErr = "Message is required";
  } else {
    $cmessage = test_input($_POST["cmessage"]);
  }
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

	

	
?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>Contact</title>
		<script src="js/validation.js" type="text/javascript"></script>
		<script src="js/showpass.js" type="text/javascript"></script>
		<script src="js/passmeter.js" type="text/javascript"></script>
		<?php include 'header.php'; ?>

							<!-- Content -->
								<section>
									<header class="main">
										<h1>Contact</h1>
									</header>
									
									<div class="row">
											<div class="col-md-8 col-md-offset-2">
																							
													<p>Leave us a message and we'll get in touch as soon as possible!</p>      
													<form id="contactform" name="contactform" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
														<div class="field-wrap">
															First Name:<span class="error">* <?php echo $cfnameErr;?></span> 
															<input type="text" name="cfname" id="cfname"/>	
														</div> 														
														<div class="field-wrap">
															Last Name:<span class="error">* <?php echo $clnameErr;?></span>
															<input type="text" name="clname" id="clname"/>													
														</div>  
														<div class="field-wrap">
															Email:<span class="error">* <?php echo $cemailErr;?></span> 
															<input type="text" name="cemail" id="cemail"/>
														</div> 
														<div class="field-wrap">
															Subject:<span class="error">* <?php echo $csubjectErr;?></span>
															<input type="text" name="csubject" id="csubject"/>														
														</div> 														
														<div class="field-wrap">
															Message:<span class="error">* <?php echo $cmessageErr;?></span>
															<textarea class="form-control" name="cmessage" id="cmessage" rows="8"></textarea>															
														</div>
														<div class="field-wrap">					
															<div class="g-recaptcha" align="center" data-sitekey="6LfkJ08UAAAAAMlS-2HXGELlUTlwjt7Eh6NNpWMp"></div>
														</div>
														<span id="contact_message"></span>
														<button type="submit" class="button button-block" name="sendmessage" id="sendmessage"/>Send message</button>       
													</form>
												       
											</div>
											
									</div>
									
									
								</section>
								<?php include 'last_posts.php'; ?>
						</div>
					</div>

				<?php include 'footer.php'; ?>