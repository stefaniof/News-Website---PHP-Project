<?php 
    require 'includes/dbcon.php';
	session_start();

    if ($_SESSION['logged_in'] != 1)
    {
        $_SESSION['message'] = "<div class='info-alert'>You must log in before viewing your profile page!</div>";
        header("location: error.php");    
    }
    else
    {
        $email = $mysqli->escape_string($_SESSION['email']);
        $result = $mysqli->query("SELECT * FROM users WHERE email='$email'");
        $user = $result->fetch_assoc();

        $first_name = $user['first_name'];
        $last_name = $user['last_name'];
        $email = $user['email'];
        $active = $user['active'];
    }
	
	
	
	//update profile
	if (isset($_POST['update']) && $_POST['new_first_name'] != "" && $_POST['new_last_name'] != "" && $_POST['current_password'] != "") 
    {
        $new_first_name = $mysqli->escape_string($_POST['new_first_name']);
        $new_last_name = $mysqli->escape_string($_POST['new_last_name']);
        $current_password = $mysqli->escape_string($_POST['current_password']);
        $email = $_SESSION['email'];

        $result = $mysqli->query("SELECT password FROM users WHERE email='$email'");

        $user = $result->fetch_assoc();
        $password = $user['password'];

        if (password_verify($_POST['current_password'], $user['password']))
        {
            $sql = ("UPDATE users SET first_name='$new_first_name', last_name='$new_last_name' WHERE email='$email'");
            
            if($mysqli->query($sql))
            {
                $_SESSION['message'] = "<div class='info-success'>Profile updated successfully</div>";
                header("location: success.php");
            }
            else
            {
                $_SESSION['message'] = "<div class='info-alert'>Profile not updated!</div>";
                header("Location: error.php");
            }
        }
        else
        {
            $_SESSION['message'] = "<div class='info-alert'>Please enter correct current password!</div>";
            header("Location: error.php");
        }
    }
	
	//change password
	if (isset($_POST['change']) && $_POST['new_password'] != "" && $_POST['confirm_new_password'] && $_POST['current_password'] != "")
    {   
        $email = $mysqli->escape_string($_SESSION['email']);
        $result = $mysqli->query("SELECT * FROM users WHERE email='$email'");
        $user = $result->fetch_assoc();

        if (password_verify($_POST['current_password'], $user['password']))
        {
            $new_password = $mysqli->escape_string(password_hash($_POST['new_password'], PASSWORD_BCRYPT));
            $hash = $mysqli->escape_string(md5(rand(0,1000)));
            $sql = "UPDATE users SET password='$new_password', hash='$hash' WHERE email='$email'";

            if ($mysqli->query($sql))
            {
                $_SESSION['message'] = "<div class='info-success'>Your password has been changed successfully!</div>";
                header("location: success.php");    
            }
        }
        else
        {
            $_SESSION['message'] = "<div class='info-alert'>Please enter correct current password!</div>";
            header("Location: error.php");
        }
    }
	
	//data scrapping
	$data_scrapped = file_get_contents('http://www.triviacafe.com/computer-trivia-questions');
	$qcut = explode('<center><h2>Computers</h2><b>Question: </b>', $data_scrapped);
	$question = explode('<BR>', $qcut[1]);
	$acut = explode('style="display:none;"><tr><td>', $data_scrapped);
	$answer = explode('</td></tr></table><HR><b>', $acut[1]);
	
?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>Profile page for <?= $first_name.' '.$last_name ?></title>
		<script src="js/validation.js" type="text/javascript"></script>
				<script language='javascript'>
				<!--

				function switchVisibility(element) {
					var ele = document.getElementById(element)

					if(ele.style.display == "none") {
						document.getElementById(element + 'minusimage').style.display = '';
						document.getElementById(element + 'plusimage').style.display = 'none';
						ele.style.display = "";
					} else {
						document.getElementById(element + 'minusimage').style.display = 'none';
						document.getElementById(element + 'plusimage').style.display = '';
						ele.style.display = "none";
					}
				}

				// -->
				</script>
		<?php include 'header.php'; ?>

							<!-- Content -->
								<section>
									<header class="main">
										<h1>Welcome <?php echo $first_name.' '.$last_name; ?></h1>
									</header>
									<hr />
									<h3> Trivia fan? (refresh for more) </h3>
									<?php echo $question[0]; ?>
									<a href='javascript:;' onclick='javascript:switchVisibility("answer1")'><div style='border:none;' id='answer1plusimage'><b>Show Answer</b></div><div style='border:none;display:none;' id='answer1minusimage'><b>Hide Answer</b></div></a><BR><table id='answer1' style="display:none;"><tr><td><?php echo $answer[0]; ?></td></tr></table>
									<hr />
									
									
									<?php  
										if ($active == "0")
										{
											echo '<div class="info-alert">Account is unverified, please confirm your email by 
											clicking on the link sent to your email!</div>
											<a href="resend.php"><button class="button button-block" name="resend"/>Resend Link</button></a>';
											
										}
										else{
											echo '<div class="row">
											
											<!-- Update profile -->
											<div class="6u 12u$(small)">
												<h3>Update your profile</h3>
												<div class="form">
													<div id="update profile">  
														<form id="updateform" name="updateform" onsubmit="return update_validation();" method="post" autocomplete="off">
															<div class="field-wrap">
																<label>
																	New First Name<span class="req">*</span>
																</label>
																<input type="text" autocomplete="off" name="new_first_name" id="new_first_name"/>
															</div>          
															<div class="field-wrap">
																<label>
																	New Last Name<span class="req">*</span>
																</label>
															<input type="text" autocomplete="off" name="new_last_name" id="new_last_name"/>
															</div>
															<div class="field-wrap">
																<label>
																	Current Password<span class="req">*</span>
																</label>
															<input type="password" autocomplete="off" name="current_password" id="current_password"/>
															</div>
															<span id="update_message"></span>
															<button type="submit" class="button special fit" name="update" id="update"/>Update Profile</button>
														</form>
													</div>
												</div>
											</div>
											<!-- Change password -->
											<div class="6u$ 12u$(small)">
												<h3>Change your password</h3>
												<div class="form">
													<form id="changeform" name="changeform" action="changepassword.php" onsubmit="return change_validation();" method="post">
														<div class="field-wrap">
															<label>
																New Password<span class="req">*</span>
															</label>
															<input type="password" autocomplete="off" name="new_password" id="new_password"/>
														</div>
														<div class="field-wrap">
															<label>
																Confirm New Password<span class="req">*</span>
															</label>
															<input type="password" autocomplete="off" name="confirm_new_password" id="confirm_new_password"/>
														</div>
														<div class="field-wrap">
															<label>
																Current Password<span class="req">*</span>
															</label>
															<input type="password" autocomplete="off" name="current_password" id="current_password"/>
														</div>
														<span id="change_message"></span>
														<button class="button special fit" name="change" id="change"/>Change Password</button>
													</form>
												</div>    
												
											</div>
											
									</div>';
											
										}
										
										
										
									?>
									

									
									
									
									
								</section>
								<?php include 'last_posts.php'; ?>
						</div>
					</div>

				<?php include 'footer.php'; ?>