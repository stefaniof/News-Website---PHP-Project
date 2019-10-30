<?php
    require 'includes/dbcon.php';
    session_start();

    if (isset($_GET['id']) && !empty($_GET['id']) AND isset($_GET['hash']) && !empty($_GET['hash']))
    {
        $id = $mysqli->escape_string($_GET['id']); 
        $hash = $mysqli->escape_string($_GET['hash']); 

        $result = $mysqli->query("SELECT * FROM users WHERE user_id='$id' AND hash='$hash'");
        
        if ($result->num_rows == 0)
        { 
            $_SESSION['message'] = "<div class='info-alert'>Password can not be reset. The URL you have entered is not valid!</div>";
            header("location: error.php");
        }
    }
    else
    {
        $_SESSION['message'] = "<div class='info-alert'>Something went wrong, please try again!</div>";
        header("location: error.php");  
    }
?>

<!DOCTYPE html>
<html >
<head>
    <meta charset="UTF-8">
    <title>Reset Your Password</title>
	<script src="js/validation.js" type="text/javascript"></script>
    <?php include 'header.php'; ?>
</head>
<body>

			<!-- Content -->
			<section>

				<div class="form">
					<h1>Choose Your New Password</h1>   
					<form action="reset_password.php" method="post">      
						<div class="field-wrap">
							<label>
								New Password<span class="req">*</span>
							</label>
							<input type="password"required name="newpassword" autocomplete="off"/>
						</div>
						<div class="field-wrap">
							<label>
								Confirm New Password<span class="req">*</span>
							</label>
							<input type="password"required name="confirmpassword" autocomplete="off"/>
						</div>
						<input type="hidden" name="id" value="<?= $id ?>">
						<input type="hidden" name="hash" value="<?= $hash ?>">
						<button class="button button-block"/>Apply</button>
					</form>
				</div>
			</section>
<?php include 'last_posts.php'; ?>
</div>
</div>
<?php include 'footer.php'; ?>